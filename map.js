<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>

<script type="text/javascript">
 /*
  * A generic function to add a marker
  */

 function addMarker(myPos,myTitle,myMap,popupContent,infowindow) {
   var marker = new google.maps.Marker({
     position: myPos, 
     map: myMap, 
     title: myTitle
   });

   google.maps.event.addListener(marker, 'click', function() {
     infowindow.setContent(popupContent);
     infowindow.open(myMap, marker);
   });
 }

function addComment(id, comment) {
  var xmlhttp;
  if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  }
  xmlhttp.onreadystatechange=function() {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
      alert("comment successfully added");
      location.reload();
    }
  }
  xmlhttp.open("GET","insertUserComment.php?id=" + id + "&comment=" + document.getElementById(id).value,true);
  xmlhttp.send();
}
function getComments(id) {
  var xmlhttp;
  if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
    xmlhttp=new XMLHttpRequest();
  }
  xmlhttp.open("GET","getUserComment.php?id=" + id,false);
  xmlhttp.send();
  return xmlhttp.responseText;
}
function initialize() {


var mapOptions = {
center: new google.maps.LatLng(53.1,-3.5),
zoom: 6,
mapTypeId: google.maps.MapTypeId.ROADMAP
       };
       var map = new google.maps.Map(document.getElementById("map_canvas"),
           mapOptions);

/*
* Create an infowindow object. In this example, we'll only use one infowindow, rather than allowing multiple ones
*/

var infowindow = new google.maps.InfoWindow( {maxWidth: 200} );

/*
* Iterate through data, and create new markers
*/

for (id in opData) {

/*
* Create some content for the infowindow
*/
var comments = getComments(opData[id].id);
var infoText = "<div class='map_popup'><h2>" + opData[id].title + "</h2><p>" + opData[id].inscraw + "</p>Comment: <input id=" + opData[id].id + " type='text'/><input type='button' value='add' onClick='addComment(" + opData[id].id + ")'/><br/>Comments: <div id='" + opData[id].id + "comments'>" + comments + "</div></div>";

addMarker(new google.maps.LatLng(opData[id].lat,
opData[id].lng),
opData[id].title,
map,
infoText,
infowindow);
}
}
</script>
