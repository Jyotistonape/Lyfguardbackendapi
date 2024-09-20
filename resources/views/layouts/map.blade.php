<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>


<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyADBDfJGV0ynOh92YaopuPLIAZnsKV_H2o&libraries=places&callback=initMap" async defer></script>
{{--<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>--}}
{{--<script src="{{asset('assets/vendor/global/global.min.js')}}"></script>--}}
<script>

    function initMap() {
        var ind = {lat: 12.931701, lng: 77.62910599999998};
        document.getElementById('address').onkeyup = function() {
        var map = new google.maps.Map(
            document.getElementById('map'), {zoom: 17, center: ind});
        var marker = new google.maps.Marker({position: ind, map: map});
        var input = document.getElementById('address');
//            var options = {
//                types: ['(bengaluru)'],
//                componentRestrictions: {country: "in"}
//            };
        var autocomplete = new google.maps.places.Autocomplete(input);

        // Set initial restrict to the greater list of countries.
        autocomplete.setComponentRestrictions({
            country: ["in"],
//                city: ["bengaluru"]
//                postalCode: "560102"
        });

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function () {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }
            map.setZoom(17);
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);
            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }
            infowindowContent.children['place-icon'].src = place.icon;
            infowindowContent.children['place-name'].textContent = place.name;
            infowindowContent.children['place-address'].textContent = address;
            infowindow.open(map, marker);
            console.log(place.address_components);
            console.log(place.geometry.location);
            console.log(place.geometry.location.lat());
            console.log(place.geometry.location.lng());
            for (var i = 0; i < place.address_components.length; i++) {
                for (var j = 0; j < place.address_components[i].types.length; j++) {
                    if (place.address_components[i].types[j] == "postal_code") {
                        //  document.getElementById('postal_code').innerHTML = place.address_components[i].long_name;
//                            console.log(place.address_components[i].long_name);
                        document.getElementById("pin_code").value = place.address_components[i].long_name;

                    }
                    if (place.address_components[i].types[j] == "administrative_area_level_1") {
                        //  document.getElementById('postal_code').innerHTML = place.address_components[i].long_name;
//                            console.log(place.address_components[i].long_name);
                        document.getElementById("state_name").value = place.address_components[i].long_name;
                    }

                    if (place.address_components[i].types[j] == "locality") {
                        //  document.getElementById('postal_code').innerHTML = place.address_components[i].long_name;
//                            console.log(place.address_components[i].long_name);
                        document.getElementById("city_name").value = place.address_components[i].long_name;
                    }

                    if (place.address_components[i].types[j] == "country") {
                        //  document.getElementById('postal_code').innerHTML = place.address_components[i].long_name;
//                            console.log(place.address_components[i].long_name);
                        document.getElementById("country").value = place.address_components[i].long_name;
                    }
                }
            }
            document.getElementById("latitude").value = place.geometry['location'].lat();
            document.getElementById("longitude").value = place.geometry['location'].lng();

        });
    }
        document.getElementById('destination_address').onkeyup = function() {

        var map = new google.maps.Map(
            document.getElementById('destination-map'), {zoom: 17, center: ind});
        var marker = new google.maps.Marker({position: ind, map: map});
        var input = document.getElementById('destination_address');
//            var options = {
//                types: ['(bengaluru)'],
//                componentRestrictions: {country: "in"}
//            };
        var autocomplete = new google.maps.places.Autocomplete(input);

        // Set initial restrict to the greater list of countries.
        autocomplete.setComponentRestrictions({
            country: ["in"],
//                city: ["bengaluru"]
//                postalCode: "560102"
        });

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('destination-infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function () {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                window.alert("No details available for input: '" + place.name + "'");
                return;
            }
            if (place.geometry.viewport) {
                map.fitBounds(place.geometry.viewport);
            } else {
                map.setCenter(place.geometry.location);
                map.setZoom(17);  // Why 17? Because it looks good.
            }
            map.setZoom(17);
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);
            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ''),
                    (place.address_components[1] && place.address_components[1].short_name || ''),
                    (place.address_components[2] && place.address_components[2].short_name || '')
                ].join(' ');
            }
            infowindowContent.children['destination-place-icon'].src = place.icon;
            infowindowContent.children['destination-place-name'].textContent = place.name;
            infowindowContent.children['destination-place-address'].textContent = address;
            infowindow.open(map, marker);
            // console.log('test');
            // console.log(place);
            console.log(place.address_components);
            console.log(place.geometry.location);
            console.log(place.geometry.location.lat());
            console.log(place.geometry.location.lng());
            for (var i = 0; i < place.address_components.length; i++) {
                for (var j = 0; j < place.address_components[i].types.length; j++) {
                    if (place.address_components[i].types[j] == "postal_code") {
                        //  document.getElementById('postal_code').innerHTML = place.address_components[i].long_name;
//                            console.log(place.address_components[i].long_name);
                        document.getElementById("destination_pin_code").value = place.address_components[i].long_name;

                    }
                    if (place.address_components[i].types[j] == "administrative_area_level_1") {
                        //  document.getElementById('postal_code').innerHTML = place.address_components[i].long_name;
//                            console.log(place.address_components[i].long_name);
                        document.getElementById("destination_state_name").value = place.address_components[i].long_name;
                    }

                    if (place.address_components[i].types[j] == "locality") {
                        //  document.getElementById('postal_code').innerHTML = place.address_components[i].long_name;
//                            console.log(place.address_components[i].long_name);
                        document.getElementById("destination_city_name").value = place.address_components[i].long_name;
                    }

                    if (place.address_components[i].types[j] == "country") {
                        //  document.getElementById('postal_code').innerHTML = place.address_components[i].long_name;
//                            console.log(place.address_components[i].long_name);
                        document.getElementById("destination_country").value = place.address_components[i].long_name;
                    }
                }
            }
            document.getElementById("destination_latitude").value = place.geometry['location'].lat();
            document.getElementById("destination_longitude").value = place.geometry['location'].lng();

        });
    }
    }

</script>