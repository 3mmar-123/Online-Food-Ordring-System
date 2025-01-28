@extends('layouts.main')
@section('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css">
    <!-- Leaflet LocateControl CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet.locatecontrol@0.72.0/dist/L.Control.Locate.min.css">
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
        .restaurant-popup {
            font-size: 14px;
        }
        .restaurant-popup a {
            text-decoration: none;
            color: #007bff;
        }
        .restaurant-popup a:hover {
            text-decoration: underline;
        }
    </style>
@endsection

@section('content')
    <div class="container mt-5">
        <h1 class="text-center">Find Nearby Restaurants</h1>
        <div id="map"></div>
    </div>
@endsection

@section('scripts')
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- Leaflet LocateControl JS -->
    <script src="https://unpkg.com/leaflet.locatecontrol@0.72.0/dist/L.Control.Locate.min.js"></script>

    <script>
        // Set default location to Riyadh, Saudi Arabia
        const defaultLocation = { lat: 24.7136, lng: 46.6753 }; // Latitude and longitude of Riyadh
        let map, customerMarker, restaurantMarkers = [];

        function initializeMap(lat, lng) {
            // Initialize the map
            map = L.map('map').setView([lat, lng], 14);

            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);

            // Add a marker for the customer
            customerMarker = L.marker([lat, lng]).addTo(map).bindPopup("You are here").openPopup();

            // Add the LocateControl button
            L.control.locate({
                position: 'topright',
                drawCircle: true,
                follow: true,
                setView: true,
                keepCurrentZoomLevel: true,
                flyTo: true,
                icon: 'fa fa-location-arrow',
                strings: {
                    title: "Locate Me",
                    popup: "You are here",
                },
            }).addTo(map);

            // Fetch nearby restaurants
            fetchNearbyRestaurants(lat, lng);
        }

        function fetchNearbyRestaurants(lat, lng) {
            fetch(`/json/nearby?lat=${lat}&lng=${lng}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        data.restaurants.forEach(restaurant => {
                            const marker = L.marker([restaurant.latitude, restaurant.longitude], {
                                icon: L.icon({
                                    iconUrl: '{{asset('img/restauranticon.png')}}', // Replace with your restaurant marker icon
                                    iconSize: [50, 50],
                                    iconAnchor: [16, 32],
                                }),
                            })
                                .addTo(map)
                                .bindPopup(`
                                    <div class="restaurant-popup">
                                        <strong>${restaurant.name}</strong><br>
                                        ${restaurant.address}<br>
                                        <em>${restaurant.distance.toFixed(2)} km away</em><br>
                                        <a href="/menu/${restaurant.id}" target="_blank">Browse Menu</a>
                                    </div>
                                `);
                            restaurantMarkers.push(marker);
                        });
                    } else {
                        alert("No nearby restaurants found.");
                    }
                })
                .catch(error => console.error("Error fetching nearby restaurants:", error));
        }

        function getCustomerLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    position => {
                        const { latitude, longitude } = position.coords;
                        initializeMap(latitude, longitude);
                    },
                    () => {
                        alert("Unable to retrieve your location. Using default location.");
                        initializeMap(defaultLocation.lat, defaultLocation.lng);
                    },
                    { enableHighAccuracy: true }
                );
            } else {
                alert("Geolocation is not supported by your browser. Using default location.");
                initializeMap(defaultLocation.lat, defaultLocation.lng);
            }
        }

        // Initialize map with customer location
        document.addEventListener('DOMContentLoaded', getCustomerLocation);
    </script>
@endsection
