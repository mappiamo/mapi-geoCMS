L.PhotoMarker = L.Marker.extend({
  options: {
    title: '',
    clickable: true,
    draggable: false,
    zIndexOffset: 0,
    opacity: 1,
    riseOnHover: true,
    riseOffset: 250,
    // Default zoom matrix
    matrix: { 11: 0.125, 12: 0.25, 14: 0.5, 16: 1 }
  },
  initialize: function(latlng, options) {
    options.icon = new L.PhotoIcon({src:options.src,size:options.size});
    L.Marker.prototype.initialize.call(this, latlng, options);
  },
  _initIcon: function() {
    L.Marker.prototype._initIcon.call(this);
    this.resize();
  },
  onAdd: function(map) {
    map.on('zoomend', this.resize, this);
    L.Marker.prototype.onAdd.call(this, map);
  },
  onRemove: function(map) {
    map.off('zoomend', this.resize, this);
    L.Marker.prototype.onRemove.call(this, map);
  },
  scale: function(factor) {
    var icon = this.options.icon;
    icon.scale(factor);
  },
  resize: function() {
    if ( typeof(this.options.resize) === 'function' ) {
      this.options.resize.call(this,this._map);
    }
    else {
      this._resize(this._map);
    }
  },
  _resize: function(map) {
    // Only instantiate the matrix here if we're not overriden
    if ( this.matrix === undefined ) {
      this.matrix = new L.PhotoMarkerMatrix(this.options.matrix);
    }
    this.scale( this.matrix.findScale(map.getZoom()) );
  }
});

L.photoMarker = function (latlng, options) {
  return new L.PhotoMarker(latlng, options);
};
