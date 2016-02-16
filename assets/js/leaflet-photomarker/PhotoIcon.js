L.PhotoIcon = L.Class.extend({
  options: {
    className: 'leaflet-photomarker-img'
  },

  initialize: function (options) {
    L.setOptions(this, options);
    this.original_size = L.point(options.size);
    this.size = this.original_size;
  },

  scale: function(factor) {
    var to = this.original_size.multiplyBy(factor);
    if ( (to.x !== this.size.x) && (to.y !== this.size.y) ) {
      this.resize(to);
    }
  },

  createIcon: function () {
    var src = this.options.src;

    if (!src) {
      if (name === 'icon') {
        throw new Error("iconUrl not set in Icon options (see the docs).");
      }
      return null;
    }

    this._container = L.DomUtil.create("div", 'leaflet-photomarker-container');
    this._container.style.position = 'relative';
    this.img = this._createImg(src);
    this._container.appendChild(this.img);

    // Add class names
    L.DomUtil.addClass(this.img, 'leaflet-marker-icon');
    L.DomUtil.addClass(this.img, this.options.className);

    // Set size styles
    this._setIconSize(this.img, this.size);

    // return this.img;
    return this._container;
  },

  resize: function(size) {
    this.size = size;
    this._setIconSize(this.img, this.size);
  },

  createShadow: function () {
    return null;
  },

  _setIconSize: function (img, size) {
    var anchor = size.divideBy(2, true);

    if (anchor) {
      img.style.marginLeft = (-anchor.x) + 'px';
      img.style.marginTop  = (-anchor.y) + 'px';
    }

    if (size) {
      img.style.width  = size.x + 'px';
      img.style.height = size.y + 'px';
    }
  },

  _createImg: function (src) {
    var el;

    if (!L.Browser.ie6) {
      el = document.createElement('img');
      el.src = src;
    } else {
      el = document.createElement('div');
      el.style.filter =
              'progid:DXImageTransform.Microsoft.AlphaImageLoader(src="' + src + '")';
    }
    return el;
  }
});
