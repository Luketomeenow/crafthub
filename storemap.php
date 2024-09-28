<?php
include 'dbconnect.php';

function getCoordinates($address) {
    $url = "https://nominatim.openstreetmap.org/search?format=json&q=" . urlencode($address);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERAGENT, '2DMapApp/1.0 (your-email@example.com)');
    $response = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($response, true);
    if (isset($data[0])) {
        return [
            'lat' => $data[0]['lat'],
            'lon' => $data[0]['lon']
        ];
    } else {
        return null;
    }
} 

$select = "SELECT * FROM crafthub_merchant_applicant";
$result = $conn->query($select);

$locations = [];

while ($row = mysqli_fetch_assoc($result)) {
    $address = $row['shop_street'].','.$row['shop_barangay'] . ', ' . $row['shop_municipality'] . ', ' . 'Bataan'. ', ' . 'Philippines';
    $coordinates = getCoordinates($address);
    if ($coordinates) {
        $locations[] = [
            'lat' => $coordinates['lat'],
            'lng' => $coordinates['lon'],
            'shopName' => $row['shop_name'],
            'description' => $address
        ];
    }
}

$locationsJson = json_encode($locations);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CraftHub: An Online Marketplace</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
  <!--=============== REMIXICONS ===============-->
  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <!--=============== BOXICONS ==============-->
  <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
  <script src="https://kit.fontawesome.com/dd5559ee21.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/storemap.css">
  <link rel="stylesheet" href="css/navigation.css">
  
</head>
<body>

        <!--=============== NAVIGATION ==============-->
        <div class="flexMain sticky-top py-4" id="mainNavigation">
                <div class="flex3">
                    <ul class="list-unstyled d-md-block">
                        <li class="mx-4 d-inline-block"><a href="homepage.php" class="logo"><img src="images/navlogo.png"> </a></li>
                    </ul>
                </div>
                <div class="flex2">
                <form action="usearch.php" method="get">
                        <div class="form-input">
                            <input type="search" name="searchbar" placeholder="Search...">
                            <button type="submit" class="search-btn" name="btnsearch"><i class='bx bx-search'></i></button>
                        </div>
                    </form>
                </div>
                <div class="flex4" id="icons">
                    <ul class="list-unstyled">
                      
                        <li class="hideAtCustom mx-4 d-inline-block"><a href="chatroom.php"><i class="ri-chat-2-line"></i></a></li>
                        <li class="hideAtCustom mx-4 d-inline-block"><a href="cart.php"><i class="ri-shopping-cart-line"></i></a></li>
                    </ul>
                </div>
                <div class="flex5">
                    <div class="dropdown">
                        <button class="dropbtn"> Menu </button>
                        <div class="dropdown-content">
                            <a href="accountsettings.php">Account</a>
                            <a href="mypurchase.php">My Purchases</a>
                            <a href="storemap.php">Store Map</a>
                            <a href="index.php">Log Out</a>
                        </div>
                    </div>
                </div>
                <nav class="responsive">
                    <input type="checkbox" id="sidebar-active">
                    <label for="sidebar-active" class="open-sidebar-button">
                        <svg xmlns="http://www.w3.org/2000/svg" height="42" padding-top="20px" viewBox="0 -960 960 960" width="32">
                            <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z"/>
                        </svg>
                    </label>
                    <label id="overlay" for="sidebar-active"></label>
                    <div class="links-container">
                        <label for="sidebar-active" class="close-sidebar-button">
                            <svg xmlns="http://www.w3.org/2000/svg" height="32" viewBox="0 -960 960 960" width="32">
                                <path d="m256-200-56-56 224-224-224-224 56-56 224 224 224-224 56 56-224 224 224 224-56 56-224-224-224 224Z"/>
                            </svg>
                        </label>
                        <a href="homepage.php">Home</a>
                        <a href="chatroom.php">Messages</a> 
                        <a href="cart.php">Cart</a>
                        <a href="accountsettings.php">Account</a>
                        <a href="mypurchase.php">My Purchase</a>
                        <a href="storemap.php">Store Map</a>
                        <a href="index.php">Log out</a>
                    </div>
                </nav>
        </div>
        <!--=============== END NAVIGATION ==============-->

        <div id="map"></div>
<script>
        const map = L.map('map').setView([14.6417, 120.52260], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // Fetching locations data from PHP
        const locations = <?php echo $locationsJson; ?>;

        // Function to calculate distance between two lat/lng pairs using Haversine formula
        function getDistance(lat1, lon1, lat2, lon2) {
            const R = 6371e3; // Earth radius in meters
            const φ1 = lat1 * Math.PI / 180;
            const φ2 = lat2 * Math.PI / 180;
            const Δφ = (lat2 - lat1) * Math.PI / 180;
            const Δλ = (lon2 - lon1) * Math.PI / 180;

            const a = Math.sin(Δφ / 2) * Math.sin(Δφ / 2) +
                      Math.cos(φ1) * Math.cos(φ2) *
                      Math.sin(Δλ / 2) * Math.sin(Δλ / 2);
            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

            const d = R * c; // Distance in meters
            return d;
        }

        // Function to find the nearest shop
        function findNearestShop(lat, lon) {
            let nearestShop = null;
            let minDistance = Infinity;

            locations.forEach(location => {
                const distance = getDistance(lat, lon, location.lat, location.lng);
                if (distance < minDistance) {
                    minDistance = distance;
                    nearestShop = location;
                }
            });

            return nearestShop;
        }

        // Display all shops on the map
        locations.forEach(location => {
            L.marker([location.lat, location.lng])
                .addTo(map)
                .bindPopup(`<b>${location.shopName}</b><br>${location.description}`);
        });

        let userMarker, circle, zoomed, nearestLine;

        navigator.geolocation.watchPosition(success, error);

        function success(pos) {
            const lat = pos.coords.latitude;
            const lng = pos.coords.longitude;
            const accuracy = pos.coords.accuracy;

            if (userMarker) {
                map.removeLayer(userMarker);
                map.removeLayer(circle);
                if (nearestLine) {
                    map.removeLayer(nearestLine);
                }
            }

            userMarker = L.marker([lat, lng]).addTo(map);
            circle = L.circle([lat, lng], { radius: accuracy }).addTo(map);

            if (!zoomed) {
                zoomed = map.fitBounds(circle.getBounds());
            }

            map.setView([lat, lng]);

            // Find and display the nearest shop
            const nearestShop = findNearestShop(lat, lng);
            if (nearestShop) {
                // Highlight the nearest shop marker
                const nearestMarker = L.marker([nearestShop.lat, nearestShop.lng], { icon: L.icon({
                    iconUrl: 'https://leafletjs.com/examples/custom-icons/leaf-red.png',
                    shadowUrl: 'https://leafletjs.com/examples/custom-icons/leaf-shadow.png',
                    iconSize: [38, 95],
                    shadowSize: [50, 64],
                    iconAnchor: [22, 94],
                    shadowAnchor: [4, 62],
                    popupAnchor: [-3, -76]
                }) }).addTo(map)
                  .bindPopup(`<b>Nearest Shop: ${nearestShop.shopName}</b><br>${nearestShop.description}`)
                  .openPopup();

                // Draw a line between the user and the nearest shop
                nearestLine = L.polyline([[lat, lng], [nearestShop.lat, nearestShop.lng]], { color: 'red' }).addTo(map);
            }
        }

        function error(err) {
            if (err.code === 1) {
                alert("Please allow geolocation access");
            } else {
                alert("Cannot get current location");
            }
        }
    </script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

</body>
</html>
