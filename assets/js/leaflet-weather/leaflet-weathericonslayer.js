/* jshint camelcase:false */
/* global L */
'use strict';

(function () {
    var Icon = L.Icon.extend({
        options: {
            popupAnchor: new L.Point(0, -25)
        },

        initialize: function (options) {
            return L.Util.setOptions(this, options);
        },

        createIcon: function () {
            var div, span;
            div = document.createElement('div');
            div.className = 'leaflet-marker-icon weather-icon';
            div.style.margin = '-30px 0px 0px -30px';
            div.style.width = '60px';
            div.style.height = '20px';
            div.style.padding = '' + this.options.textOffset + 'px 0px 0px 0px';
            div.style.background = 'url(' + this.options.image + ') no-repeat center top';
            div.style.textAlign = 'center';
            span = document.createElement('span');
            span.innerHTML = this.options.text;
            div.appendChild(span);
            return div;
        },

        createShadow: function () {
            return null;
        }
    });

    var Layer = L.Class.extend({
        defaultI18n: {
            temperature: 'Temperature',
            maximumTemperature: 'Max. temp',
            minimumTemperature: 'Min. temp',
            humidity: 'Humidity',
            wind: 'Wind',
            pressure: 'Pressure',
            attribution: 'Weather data provided by <a href="http://openweathermap.org/">OpenWeatherMap</a>.'
        },

        includes: L.Mixin.Events,

        initialize: function (options) {
            this.options = options || {};
            this.layer = new L.LayerGroup();

            var host = this.options.host || 'http://openweathermap.org';

            this.sourceUrl = host + '/data/2.5/box/city?bbox={bbox},{zoom}&units=' + (this.options.units || 'metric') + '&APPID=' + this.options.apiKey;
            this.i18n = this.options.i18n || this.defaultI18n;

            this.options.temperatureDigits = this.options.temperatureDigits || 0;
            this.options.maxAgeSeconds = this.options.maxAgeSeconds || (24 * 3600);

            if (this.options.iconMap) {
                this.iconMap = this.options.iconMap;
            } else {
                // based on empirical research: http://codepen.io/anon/pen/OPyxeX
                this.iconMap = [
                    {
                        range: function (i) {
                            return i <= 8 && i !== 4;
                        },
                        pattern: host + '/images/icons60/{full}.png'
                    },
                    {
                        id: 50,
                        pattern: host + '/img/w/{full}.png'
                    },
                    host + '/images/icons60/{numeric}.png'
                ];
            }

            this.iconMap.transparentUrl = this.iconMap.transparentUrl || host + '/images/icons60/transparent.png';
        },

        onAdd: function (map) {
            this.map = map;
            this.map.addLayer(this.layer);
            this.map.on('moveend', this.update, this);
            this.update();
        },

        onRemove: function (map) {
            if (this.map !== map) {
                return;
            }
            this.map.off('moveend', this.update, this);
            this.map.removeLayer(this.layer);
            this.map = void 0;
        },

        getAttribution: function () {
            return this.i18n.attribution;
        },

        update: function () {
            var that = this;

            if (this.sourceRequest) {
                this.sourceRequest.abort();
            }

            var url = this.sourceUrl.replace('{bbox}', this.map.getBounds().toBBoxString()).replace('{zoom}', this.map.getZoom());

            this.sourceRequest = Layer.Utils.requestXhr(url, function (data) {
                delete that.sourceRequest;
                that.map.removeLayer(that.layer);
                that.layer.clearLayers();

                for (var i = 0; i < data.list.length; i++) {
                    var marker = that.buildMarker(data.list[i]);
                    if (marker) {
                        that.layer.addLayer(marker);
                    }
                }

                that.map.addLayer(that.layer);
            });
        },

        buildMarker: function (stationData) {
            var freshnessThreshold = new Date((stationData.dt + this.options.maxAgeSeconds) * 1000);

            if (freshnessThreshold < new Date().getTime()) {
                return; // too old
            }

            var weatherText = stationData.weather[0].main;
            var weatherIcon = this.weatherIcon(stationData);

            var popupContent = '<div class="weather-place">';
            popupContent += '<img height="38" width="45" style="border: none; float: right;" alt="' + weatherText + '" src="' + weatherIcon + '" />';
            popupContent += '<h3>' + stationData.name + '</h3>';
            popupContent += '<p>' + weatherText + '</p>';
            popupContent += '<p>';
            popupContent += this.i18n.temperature + ':&nbsp;' + this.formatTemperature(stationData.main.temp) + '°C<br />';

            if (stationData.main.temp_max) {
                popupContent += this.i18n.maximumTemperature + ':&nbsp;' + this.formatTemperature(stationData.main.temp_max) + '°C<br />';
            }
            if (stationData.main.temp_min) {
                popupContent += this.i18n.minimumTemperature + ':&nbsp;' + this.formatTemperature(stationData.main.temp_min) + '°C<br />';
            }
            if (stationData.main.humidity) {
                popupContent += '' + this.i18n.humidity + ':&nbsp;' + stationData.main.humidity + '%<br />';
            }
            if (stationData.wind && stationData.wind.speed) {
                popupContent += '' + this.i18n.wind + ':&nbsp;' + stationData.wind.speed + '&nbsp;m/s<br />';
            }
            if (stationData.main.pressure) {
                popupContent += '' + this.i18n.pressure + ':&nbsp;' + stationData.main.pressure + '&nbsp;hPa<br />';
            }

            popupContent += '</p>';
            popupContent += '</div>';

            var markerIcon = new Icon({
                image: weatherIcon,
                text: this.formatTemperature(stationData.main.temp) + '&nbsp;°C',
                textOffset: 45
            });

            var marker = new L.Marker(stationData.coord, {
                icon: markerIcon
            });

            marker.bindPopup(popupContent);
            return marker;
        },

        weatherIcon: function (stationData) {
            var icon = stationData.weather[0].icon;
            var numeric = icon.substr(0, 2);
            var parsed = parseInt(numeric);

            for (var i = 0; i < this.iconMap.length; ++i) {
                var definition = this.iconMap[i];
                if (Layer.Utils.checkIconPatternMatch(definition, parsed)) {
                    var pattern = definition.pattern || definition;
                    return pattern.replace('{full}', icon).replace('{numeric}', numeric);
                }
            }

            return this.iconMap.transparentUrl;
        },

        formatTemperature: function (t) {
            var p = Math.pow(10, this.options.temperatureDigits);
            return (Math.round(t * p) / p).toString();
        }
    });

    Layer.Utils = {
        requestXhr: function (url, callback) {
            var req = new XMLHttpRequest();
            req.onload = function () {
                var res = this.response;
                if (typeof (res) === 'string') {
                    res = JSON.parse(res);
                }
                callback(res);
            };
            req.open('get', url, true);
            req.send();

            return req;
        },

        checkIconPatternMatch: function (definition, id) {
            if (typeof (definition) === 'string') {
                return true;
            }
            if (typeof (definition.range) === 'function') {
                return definition.range(id);
            }
            if (definition.id) {
                return definition.id === id;
            }
            return false;
        }
    };

    L.WeatherIconsLayer = Layer;

})();