// Initialize and add the map
function initMap() {
    // The location of Uluru
    const uluru = { lat: 38.89037, lng: -77.03196 };
    // The map, centered at Uluru
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 4,
      center: uluru,
    });
    // The marker, positioned at Uluru
    const marker = new google.maps.Marker({
      position: uluru,
      map: map,
    });
    const marker2 = new google.maps.Marker({
        position: { lat: 32.22155, lng: -110.96976 },
        map: map
    });
    const infowindow = new google.maps.InfoWindow({
        content: "Welcome to the District!  GO CAPS!",
      });
      marker.addListener('click', function() {
        console.log("Marker clicked", marker);
        infowindow.open({
            anchor: marker,
            map,
            shouldFocus: false,
          });
      });
      
  }
  
window.initMap = initMap;
