$(document).ready(function () {
    // Gestion dynamique de l'affichage de l'image
    //------------------------------------------------------------
    const inputImgUp = $('#appbundle_observation_imageFile_file'),
        imageBox = $('#add-observation-img');

    function readURL(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                imageBox.attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    inputImgUp.change(function(){
        readURL(this);
    });

    // Gestion de la géolocalisation
    //------------------------------------------------------------
    function currentPosition(position) {
        const lat = position.coords.latitude,
            lng = position.coords.longitude,
            latInput = $('#appbundle_observation_lat'),
            lngInput = $('#appbundle_observation_lng'),
            geolocBtn = $('#geoloc-btn');

        geolocBtn.click(function (e) {
            e.preventDefault();
            e.stopPropagation();

            latInput.val(lat);
            lngInput.val(lng);
            //Géocodage inversé
            initMap(lat, lng);
        })
    }

    function errorPosition(error) {
        let info = "Erreur lors de la géolocalisation : ";
        switch (error.code) {
            case error.TIMEOUT:
                info += "Timeout !";
                break;
            case error.PERMISSION_DENIED:
                info += "Vous n’avez pas donné la permission";
                break;
            case error.POSITION_UNAVAILABLE:
                info += "La position n’a pu être déterminée";
                break;
            case error.UNKNOWN_ERROR:
                info += "Erreur inconnue";
                break;
        }
        $("#infoposition").innerHTML = info;
    }

    // Géocodage
    function initMap(lat, lng) {
        let geocoder = new google.maps.Geocoder;
        geocoder.geocode(
            {'location': {lat: lat, lng: lng} },
            function(results, status) {
                if (status === 'OK') {
                    town = results[2].address_components[1].long_name;
                    console.log(town);
                    $('#appbundle_observation_city').val(town);
                } else {
                    console.log('La ville n\'a pas été récupérée : ' + status);
                }
            }
        );
    }

    if(navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(currentPosition, errorPosition, {enableHighAccuracy:true});
    }
});