<!DOCTYPE html>
<html>
<head>
  <title>Live GPS Tracking</title>
  <style>
    #map {
      height: 400px;
      width: 100%;
    }
  </style>
</head>
<body>
  <h1>Live GPS Tracking</h1>
  <div id="map"></div>

  <script>
    function initMap() {
      const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 10,
        center: { lat: -7.797068, lng: 110.370529 }, // Set your initial map center
      });

      function updateMap() {
        fetch('http://localhost/livetrack/terimaData.php') // Endpoint to fetch latest location data
          .then(response => response.json())
          .then(data => {
            const location = data[0]; // Assuming the data is an array of coordinates

            const marker = new google.maps.Marker({
              position: { lat: parseFloat(location.latitude), lng: parseFloat(location.longitude) },
              map: map,
            });

            // Pan the map to the new marker position
            map.panTo(marker.getPosition());
          })
          .catch(error => console.error('Error:', error));
      }

      // Update map every 5 seconds (adjust interval as needed)
      setInterval(updateMap, 5000);
    }
  </script>
  <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAYtiXN1ya7NAbwe9GM2MFcQOZV-MNResU&callback=initMap"></script>
</body>
</html>
