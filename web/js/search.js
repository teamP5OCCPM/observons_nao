

// Defining the remote json dataset

let birds = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('species'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: 'birds.json'
});

let observations = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('title'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: 'titles.json'
});

let locations = new Bloodhound({
    datumTokenizer: Bloodhound.tokenizers.obj.whitespace('city'),
    queryTokenizer: Bloodhound.tokenizers.whitespace,
    prefetch: 'locations.json'
});


// Initializing the typeahead
$('.typeahead').typeahead({

    hint: true,
    highlight: true,
    minLength: 3
},
{
    name: 'locations',
    display: 'city',
    source: locations,
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
            name: 'locations',
            display: 'city',
            source: locations
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
            name: 'locations',
            display: 'city',
            source: locations,
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










