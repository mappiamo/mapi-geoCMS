//var Routearray = [];
var Routearray = new Array();
var RoutePoint = '';

var routeControl = L.Routing.control({
    //waypoints: [
    //    L.latLng(57.74, 11.94),
    //    L.latLng(57.6792, 11.949)
    //],
    geocoder: L.Control.Geocoder.nominatim(),
    routeWhileDragging: true,
    reverseWaypoints: true
}).addTo(map);


$(document).ready(function() {
    var routeArray = new Array();
    var RouteCollection = '';
    var RouteLAT = null;
    var RouteLNG = null;
    var RoutesDATA = null;

    $('.leaflet-routing-container input').bind("keyup keypress", function(e) {
        var code = e.keyCode || e.which;
        if (code  == 13) {
            e.preventDefault();
            return false;
        }
    });

    $("#btn_add").add("#MSaveButton").click(function(event) {
        routeArray = routeControl.getWaypoints();
        RouteCollection = '';

        //alert (JSON.stringify(routeArray));
        //alert(routeArray[1].latLng);
        if (routeArray.length >=2 && (routeArray[1].latLng)) {
            $.each(routeArray, function(key, value) {
                RouteLAT = value.latLng.lat;
                RouteLNG = value.latLng.lng;
                RouteCollection = RouteCollection + 'POINT(' + RouteLNG + ' ' + RouteLAT + '),';
            });
            RoutesDATA = 'GeometryCollection(' + RouteCollection.slice(0, -1) + ')';
            //alert(RoutesDATA);
            document.getElementById("content_route").value = RoutesDATA;
        } else {
            alert('ERROR: Two or more markers required for this content type!');
            return false;
        }
    });
});