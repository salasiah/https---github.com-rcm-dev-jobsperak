var customIcons = {
  restaurant: {
	icon: 'http://labs.google.com/ridefinder/images/mm_20_blue.png',
	shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
  },
  bar: {
	icon: 'http://labs.google.com/ridefinder/images/mm_20_red.png',
	shadow: 'http://labs.google.com/ridefinder/images/mm_20_shadow.png'
  }
};

function load() {
  var map = new google.maps.Map(document.getElementById("map"), {
	center: new google.maps.LatLng(4.612358, 101.113014),
	zoom: 13,
	mapTypeId: 'roadmap'
  });
  var infoWindow = new google.maps.InfoWindow;

  // Change this depending on the name of your PHP file
  downloadUrl("roadshow_place.php", function(data) {
	var xml = data.responseXML;
	var markers = xml.documentElement.getElementsByTagName("marker");
	for (var i = 0; i < markers.length; i++) {
	  var name = markers[i].getAttribute("name");
	  var address = markers[i].getAttribute("address");
	  var type = markers[i].getAttribute("type");
	  var point = new google.maps.LatLng(
		  parseFloat(markers[i].getAttribute("lat")),
		  parseFloat(markers[i].getAttribute("lng")));
	  var html = "<b>" + name + "</b> <br/>" + address + "<br/>" + type;
	  var icon = customIcons[type] || {};
	  var marker = new google.maps.Marker({
		map: map,
		position: point,
		icon: icon.icon,
		shadow: icon.shadow,
		animation: google.maps.Animation.DROP
	  });
	  bindInfoWindow(marker, map, infoWindow, html);
	}
	
    for (var i = 0; i < markers.length; i++) {
      setTimeout(function() {
        addMarker();
      }, i * 200);
    }

  });
}

function bindInfoWindow(marker, map, infoWindow, html) {
  google.maps.event.addListener(marker, 'click', function() {
	infoWindow.setContent(html);
	infoWindow.open(map, marker);
  });
}

function downloadUrl(url, callback) {
  var request = window.ActiveXObject ?
	  new ActiveXObject('Microsoft.XMLHTTP') :
	  new XMLHttpRequest;

  request.onreadystatechange = function() {
	if (request.readyState == 4) {
	  request.onreadystatechange = doNothing;
	  callback(request, request.status);
	}
  };

  request.open('GET', url, true);
  request.send(null);
}

function doNothing() {}

//]]>