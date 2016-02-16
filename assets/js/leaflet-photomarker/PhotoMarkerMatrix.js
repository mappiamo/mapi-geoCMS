L.PhotoMarkerMatrix = L.Class.extend({
  initialize: function(config) {
    var levels = [];
    for(var k in config) {
      levels.push(parseInt(k, 10));
    }
    // Sort the levels array numerically
    levels.sort(function(a,b){return(a-b);});
    var m = this.metric = {};
    // Find the highest and lowest zooms we have data for
    m.min = levels[0];
    m.minScale = config[levels[0]];
    m.max = levels[levels.length-1];
    m.maxScale = config[levels[levels.length-1]];
    m.zooms = {};
    var last;
    for(var i = m.min; i <= m.max; i ++) {
      if(config[i]) {
        m.zooms[i] = config[i];
        last = config[i];
      }
      else {
        m.zooms[i] = (last !== undefined) ? last : config[m.max];
      }
    }
  },
  findScale: function(zoom) {
    var m = this.metric,
        z = parseInt(zoom, 10);

    if ( z < m.min ) {
      return m.minScale;
    }
    else if ( z > m.max ) {
      return m.maxScale;
    }
    else {
      return (m.zooms[z] !== undefined) ? m.zooms[z] : m.maxScale;
    }
  }
});
