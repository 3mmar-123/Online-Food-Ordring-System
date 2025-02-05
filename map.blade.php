@extends('layouts.main')
@section('styles')
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- Leaflet LocateControl CSS -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.83.0/dist/L.Control.Locate.min.css" />
    <link rel="stylesheet" href="{{asset('assets/css/login.css')}}">

    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <!-- Leaflet LocateControl JS -->
    <script src="https://cdn.jsdelivr.net/npm/leaflet.locatecontrol@0.83.0/dist/L.Control.Locate.min.js"></script>
    <style>
        #map {
            height: 500px;
            width: 100%;
        }
        .leaflet-bar button {
            background-color: white;
            border: none;
            padding: 5px;
            cursor: pointer;
        }
        .leaflet-bar button:hover {
            background-color: #f0f0f0;
        }
    </style>

@endsection
@section('content')

    <div style=" background: #0a4e25;height: 100vh">


        <div class="pen-title">
        </div>

        <div class="module form-module map">
            <div class="toggle">

            </div>

            <div class="form">
                <form id="locationForm" method="POST" action="{{ route('location.save') }}">
                    @csrf
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                    <div class="row">
                        <div class="form-group col-sm-12">
                            <label for="example-text-input">Restaurant Name</label>
                            <input class="form-control" type="text" name="restaurant_name"
                                   id="example-text-input">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="exampleInputCity">City</label>
                            <input type="text" class="form-control" name="city"
                                   id="exampleInputCity">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="example-image">Profile Image</label>
                            <input class="form-control" type="file" name="image"
                                   id="example-image">
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="example-address">Your Address</label>
                            <input class="form-control" type="text" name="address"
                                   id="example-address">
                        </div>
                    </div>
                    <h2>Select Your Location</h2>
                    <div id="map"></div>
                    <div class="form-group col-sm-12">
                        <label for="exampleTextarea">Brief Description</label>
                        <textarea class="form-control" id="exampleTextarea"  name="description" rows="3"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <p> <input type="submit" value="Save" name="submit" class="btn theme-btn"> </p>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        // Default location (fallback if user denies access or an error occurs)
        const defaultLocation = { lat: 51.505, lng: -0.09 };

        // Initialize the map variable
        let map = null;
        let marker = null;

        // Function to initialize the map with a given location
        function initializeMap(lat, lng) {
            if (!map) {
                // Initialize map if it's not already initialized
                map = L.map('map').setView([lat, lng], 13);

                // Add OpenStreetMap tiles
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(map);

                // Add a draggable marker
                marker = L.marker([lat, lng], { draggable: true }).addTo(map);

                // Update hidden inputs when the marker is moved
                marker.on('moveend', function (e) {
                    const position = e.target.getLatLng();
                    updateLatLng(position.lat, position.lng);
                });
            } else {
                // If the map is already initialized, just update the view and marker
                map.setView([lat, lng], 13);
                marker.setLatLng([lat, lng]);
                // Add the Leaflet LocateControl button to the map

            }
            const locateControl = L.control.locate({
                position: 'topright',    // Position the button at the top-right corner of the map
                drawCircle: true,       // Disable the circle around the location
                follow: true,            // Automatically follow the user's location
                setView: true,           // Center the map when the location is found
                keepCurrentZoomLevel: false, // Keep the zoom level fixed
            }).addTo(map);

            // Automatically trigger location search on map load
            locateControl.start();
            // Update the hidden form inputs
            updateLatLng(lat, lng);
        }

        // Function to update hidden inputs
        function updateLatLng(lat, lng) {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        }

        // Function to get the user's location
        function getUserLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    function (position) {
                        const { latitude, longitude } = position.coords;
                        initializeMap(latitude, longitude); // Use user's location
                    },
                    function () {
                        alert('Unable to retrieve your location. Using default location.');
                        initializeMap(defaultLocation.lat, defaultLocation.lng); // Use fallback location
                    },
                    {
                        enableHighAccuracy: true, // Request high accuracy
                        timeout: 10000,          // Wait up to 10 seconds
                        maximumAge: 0            // Prevent cached locations
                    }
                );
            } else {
                alert('Geolocation is not supported by your browser. Using default location.');
                initializeMap(defaultLocation.lat, defaultLocation.lng); // Use fallback location
            }
        }

        // Initialize the map on page load with geolocation (if available)
        getUserLocation();


    </script>
@endsection
