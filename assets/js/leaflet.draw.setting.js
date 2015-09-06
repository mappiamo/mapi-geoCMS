var draw_layer = L.featureGroup().addTo(map);

map.addControl(new L.Control.Draw({
    draw: {
        polygon: {
            shapeOptions: {
                color: 'purple'
            },
            allowIntersection: false,
            drawError: {
                color: 'orange',
                timeout: 1000
            },
            showArea: true,
            metric: false,
            repeatMode: true
        },
        polyline: {
            shapeOptions: {
                color: 'red'
            },
            showArea: true,
            metric: false,
            repeatMode: true
        },
        rect: {
            shapeOptions: {
                color: 'green'
            },
            showArea: true,
            metric: false,
            repeatMode: true
        },
        /* circle: {
         shapeOptions: {
         color: 'steelblue'
         },
         showArea: true,
         metric: false,
         repeatMode: true
         }, */
        circle : false
    },
    edit: {
        edit: {
            selectedPathOptions: {
                color: '#0000FF',
                fillColor: '#0000FF'
            }
        },
        featureGroup: draw_layer
    }
}));

var geojson_ed = null;
var geojson_imp = null;
var wkt_ed = null;
var wkt_import = null;
var circle_radius = null;
var shapes = {};
var AddedID = null;
var GeomDATA = null;
var SubCollection = null;
var ObjectCount = 0;

map.on('draw:created', function(event) {
    var layer = event.layer;
    draw_layer.addLayer(layer);

    var geojson = event.layer.toGeoJSON();
    var wkt = Terraformer.WKT.convert(geojson.geometry);

    if (layer instanceof L.Circle) {
        circle_radius = layer.getRadius();
        wkt = wkt + ' | radius: ' + circle_radius;
    }

    AddedID = layer._leaflet_id;
    shapes[AddedID] = wkt;
    SubCollection = '';
    ObjectCount = 0;
    $.each (shapes, function(shindex, shname) {
        ObjectCount++;
        SubCollection = SubCollection + shname + ',';
        //alert(shindex + '->' + shname);
    });
    if (ObjectCount > 1) {
        GeomDATA = 'GeometryCollection(' + SubCollection.slice(0, -1) + ')';
    } else {
        GeomDATA = SubCollection.slice(0, -1);
    }
    //alert(GeomDATA);
    document.getElementById("content_route").value = GeomDATA;
});

map.on('draw:edited', function (event) {

    var layers = event.layers;

    layers.eachLayer(function (layer) {
        if (layer instanceof L.Circle) {
            geojson_ed = layer.toGeoJSON();
            circle_radius = layer.getRadius();
            wkt_ed = Terraformer.WKT.convert(geojson_ed.geometry) + ' | radius: ' + circle_radius;
            AddedID = layer._leaflet_id;
            shapes[AddedID] = wkt_ed;
            //alert(wkt_ed);
        }

        if (layer instanceof L.Polyline) {
            //shapes.push(layer.getLatLngs());
            geojson_ed = layer.toGeoJSON();
            wkt_ed = Terraformer.WKT.convert(geojson_ed.geometry);
            AddedID = layer._leaflet_id;
            shapes[AddedID] = wkt_ed;
            //alert(wkt_ed);
        }

        if (layer instanceof L.Marker) {
            geojson_ed = layer.toGeoJSON();
            wkt_ed = Terraformer.WKT.convert(geojson_ed.geometry);
            AddedID = layer._leaflet_id;
            shapes[AddedID] = wkt_ed;
            //alert(wkt_ed);
        }
    });
    SubCollection = '';
    ObjectCount = 0;
    $.each (shapes, function(shindex, shname) {
        ObjectCount++;
        SubCollection = SubCollection + shname + ',';
        //alert(shindex + '->' + shname);
    });
    if (ObjectCount > 1) {
        GeomDATA = 'GeometryCollection(' + SubCollection.slice(0, -1) + ')';
    } else {
        GeomDATA = SubCollection.slice(0, -1);
    }
    //alert(GeomDATA);
    document.getElementById("content_route").value = GeomDATA;
});

map.on('draw:deleted', function (event) {
    var layers = event.layers;
    layers.eachLayer(function (layer) {
        var AddedID = layer._leaflet_id;
        delete shapes[AddedID];
        //alert(AddedID);
    });
    SubCollection = '';
    ObjectCount = 0;
    $.each (shapes, function(shindex, shname) {
        ObjectCount++;
        SubCollection = SubCollection + shname + ',';
        //alert(shindex + '->' + shname);
    });
    if (ObjectCount > 1) {
        GeomDATA = 'GeometryCollection(' + SubCollection.slice(0, -1) + ')';
    } else {
        GeomDATA = SubCollection.slice(0, -1);
    }
    //alert(GeomDATA);
    document.getElementById("content_route").value = GeomDATA;
});

function DrawSavedData(TheGEOM) {
    var geoj = $.geo.WKT.parse(TheGEOM);
    L.geoJson(geoj, {onEachFeature: moveToFeatureGroup});
}

function moveToFeatureGroup(feature, layer) {
    layer.addTo(draw_layer);
    ObjectCount++;

    AddedID = layer._leaflet_id;
    geojson_imp = layer.toGeoJSON();
    wkt_import = Terraformer.WKT.convert(geojson_imp.geometry);
    shapes[AddedID] = wkt_import;
    SubCollection = SubCollection + wkt_import + ',';
}