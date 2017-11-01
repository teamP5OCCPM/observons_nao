

function initAutocomplete() {

    if (pageResults) {
        initResults();
    }

    if (pageObservation) {
        initObservation();
    }

    // Defining the remote json dataset

    var birds = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('species'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: 'birds.json'
    });

    var observations = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('title'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        prefetch: 'titles.json'
    });


    var substringMatcher = function(strs) {
        return function findMatches(q, cb) {
            var matches, substringRegex;
            // an array that will be populated with substring matches
            matches = [];
            // regex used to determine if a string contains the substring `q`
            substrRegex = new RegExp(q, 'i');
            // iterate through the pool of strings and for any string that
            // contains the substring `q`, add it to the `matches` array
            $.each(strs, function(i, str) {
                if (substrRegex.test(str)) {
                    matches.push(str);
                }
            });
            cb(matches);
        };
    };

    // Décode lat et lng en adresse
//Retrieve json file   
$.getJSON(locationsURL, function(data) {
    //preparing the json for use
    var loc = JSON.stringify(data);
    var locations = JSON.parse(loc); 
    
     //Transforming a json array of latlng into an array of towns and returns it     
     function geocodeLatLng(geocoder) {       
        var i, town;
        var towns = [];
        for (i = 0; i < locations.length; i++) {
            geocoder.geocode(
                {'location': {lat: locations[i]['lat'], lng: locations[i]['lng']} },
                function(results, status) {
                    if (status === 'OK') {  
                        var town = results[2].address_components[1].long_name;
                        towns.push(town);   
                    
                        } else {
                            window.alert('La ville n\'a pas été récupérée : ' + status);
                    }
                }
            );
        }
        return towns;
    }
    //Initialisation of geocoder and call of geocode function
    
    var geocoder = new google.maps.Geocoder;
    var places = geocodeLatLng(geocoder);
            
    // Initializing the typeahead
    $('.typeahead').typeahead({
        
        hint: true,
        highlight: true, 
        minLength: 3 
    },
    {
        name: 'places',
        source: substringMatcher(places),
        templates: {
            header: '<h3 class="places-title">Lieux</h3>'
        }
    },
    {        
        name: 'birds',
        display: 'species',
        source: birds,
        templates: {
            header: '<h3 class="birds-title">Espèces</h3>'
        }
    },
    {        
        name: 'observations',
        display: 'title',
        source: observations,
        templates: {
            header: '<h3 class="obs-title">Observations</h3>'
        }       
    });

    //Changing the datasets depending on filter search selected
    $('.filter-search').on('change', function() {
        switch(this.value) {
            case "species":
            $('.typeahead').typeahead('destroy');
            $('.typeahead').typeahead({
                
                    hint: true,
                    highlight: true,         
                    minLength: 3         
                },       
                {        
                    name: 'birds',
                    display: 'species',
                    source: birds       
            });
            break;

            case "place":
            $('.typeahead').typeahead('destroy');
            $('.typeahead').typeahead({
                
                hint: true,
                highlight: true, 
                minLength: 3 
            },
            {
                name: 'places',
                source: substringMatcher(places)
            });
            break;

            case "name":
            $('.typeahead').typeahead('destroy');
            $('.typeahead').typeahead({
                
                hint: true,
                highlight: true, 
                minLength: 3 
            },
            {
                name: 'places',
                source: substringMatcher(places),
                templates: {
                    header: '<h3 class="places-name">Lieux</h3>'
                }
            },
            {        
                name: 'birds',
                display: 'species',
                source: birds,
                templates: {
                    header: '<h3 class="birds-title">Espèces</h3>'
                }       
            },
            {        
                name: 'observations',
                display: 'title',
                source: observations,
                templates: {
                    header: '<h3 class="obs-title">Observations</h3>'
                }
            });
            break;
            
            default:
            $('.typeahead').typeahead('destroy');
            break;            
        }
    }); 
     
    
});
}
            
    
      

    

