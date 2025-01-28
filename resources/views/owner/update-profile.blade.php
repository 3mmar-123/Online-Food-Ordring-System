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
                <form id="locationForm" method="POST"
                      action="{{ route('restaurant.update-profile') }}" enctype="multipart/form-data">
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
                            <label for="example-phone">Phone</label>
                            <input class="form-control" type="tel" name="phone"
                                  value="{{auth('web')->user()->phone}}" id="example-phone">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="example-image">Profile Image</label>
                            <input class="form-control" type="file" name="image"
                                   id="example-image">
                        </div>
                        <div class="form-group col-sm-12">
                            <label for="example-address">Your Address</label>
                            <input class="form-control" type="text" name="address" id="example-address">
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="country">Country</label>
                            <input class="form-control" type="text" name="country" id="country" readonly>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="state">State</label>
                            <input class="form-control" type="text" name="state" id="state" readonly>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="city">City</label>
                            <input class="form-control" type="text" name="city" id="city" readonly>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="street">Street</label>
                            <input class="form-control" type="text" name="street" id="street" readonly>
                        </div>
                        <div class="form-group col-sm-6">
                            <label for="neighborhood">Neighborhood</label>
                            <input class="form-control" type="text" name="neighborhood" id="neighborhood" readonly>
                        </div>
                        <div class="form-outline col-sm-12">
                            <label for="description">Brief Description</label>
                            <textarea class="form-control" id="description"  name="description" ></textarea>
                        </div>
                    </div>
                    <div class="form-group col-sm-12">

                    <h2>Select Your Location</h2>
                    <div id="map"></div>
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
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <script>
        const defaultLocation = { lat: 24.7136, lng: 46.6753 }; // Latitude and longitude of Riyadh
        let map, marker;

        // Initialize the map and locate control
        function initializeMap(lat, lng) {
            if (!map) {
                map = L.map('map').setView([lat, lng], 13);

                // Add OpenStreetMap tiles
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 19,
                }).addTo(map);

                // Add a draggable marker
                marker = L.marker([lat, lng], { draggable: true }).addTo(map);

                // Update hidden inputs and address when marker is moved
                marker.on('moveend', function (e) {
                    const position = e.target.getLatLng();
                    updateLatLng(position.lat, position.lng);
                    reverseGeocode(position.lat, position.lng);
                });

                // Add LocateControl for "Locate Me" button
                L.control.locate({
                    position: 'topright',
                    setView: true,
                    keepCurrentZoomLevel: false,
                }).addTo(map);

                // Update address when the map is double-clicked
                map.on('dblclick', function (e) {
                    const { lat, lng } = e.latlng;
                    marker.setLatLng([lat, lng]);
                    updateLatLng(lat, lng);
                    reverseGeocode(lat, lng);
                });
            } else {
                map.setView([lat, lng], 13);
                marker.setLatLng([lat, lng]);
            }

            updateLatLng(lat, lng);
        }

        // Update hidden inputs for latitude and longitude
        function updateLatLng(lat, lng) {
            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        }

        // Reverse geocode to get structured address
        function reverseGeocode(lat, lng) {
            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`)
                .then(response => response.json())
                .then(data => {
                    const address = data.address || {};

                    // Populate structured fields
                    if (address.country) document.getElementById('country').value = address.country;
                    if (address.state) document.getElementById('state').value = address.state;
                    if (address.city || address.town || address.village)
                        document.getElementById('city').value = address.city || address.town || address.village;
                    if (address.road) document.getElementById('street').value = address.road;
                    if (address.suburb || address.neighbourhood)
                        document.getElementById('neighborhood').value = address.suburb || address.neighbourhood;

                    // Update the full address field
                    document.getElementById('example-address').value = formatAddress(address);
                })
                .catch(error => console.error('Error fetching address:', error));
        }

        // Format the address into a structured string
        function formatAddress(address) {
            const parts = [
                address.road || '',
                address.suburb || address.neighbourhood || '',
                address.city || address.town || address.village || '',
                address.state || '',
                address.country || ''
            ];
            return parts.filter(Boolean).join(', ');
        }

        // Geocode to get lat, lng from address
        function geocodeAddress(address) {
            fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.length > 0) {
                        const { lat, lon } = data[0];
                        initializeMap(lat, lon);
                    } else {
                        alert('Address not found');
                    }
                })
                .catch(error => console.error('Error fetching location:', error));
        }

        // Get user location or fallback to default
        function getUserLocation() {
            if (window.navigator.geolocation) {
                window.navigator.geolocation.getCurrentPosition(
                    function (position) {
                        const { latitude, longitude } = position.coords;
                        initializeMap(latitude, longitude);
                    },
                    function (varn) {
                        console.log(varn)
                        alert('Unable to retrieve your location. Using default location.');
                        initializeMap(defaultLocation.lat, defaultLocation.lng);
                    },
                    { enableHighAccuracy: true, timeout: 10000 }
                );
            } else {
                alert('Geolocation is not supported by your browser. Using default location.');
                initializeMap(defaultLocation.lat, defaultLocation.lng);
            }
        }

        // Attach event listener for address input
        document.getElementById('example-address').addEventListener('blur', function () {
            const address = this.value;
            if (address) geocodeAddress(address);
        });

        // Initialize the map on page load
        getUserLocation();
    </script>
@endsection
