L.Routing.control({
    //waypoints: [
    //    L.latLng(57.74, 11.94),
    //    L.latLng(57.6792, 11.949)
    //],
    geocoder: L.Control.Geocoder.nominatim(),
    routeWhileDragging: true,
    reverseWaypoints: true
}).addTo(map);