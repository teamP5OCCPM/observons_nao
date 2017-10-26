$(document).ready(function(){
    
        // Defining the local dataset
    
        var birds = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('species'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: 'birds.json'
          });    
        
    
        // Constructing the suggestion engine
    
       console.log(birds);
    
        
    
        // Initializing the typeahead
    
        $('.typeahead').typeahead({
    
            hint: true,
    
            highlight: true, /* Enable substring highlighting */
    
            minLength: 1 /* Specify minimum characters required for showing suggestions */
    
        },
    
        {
    
            name: 'birds',
            display: 'species',
            source: birds
    
        });
    
    });  