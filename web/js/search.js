$(document).ready(function(){
    
        // Defining the local dataset
    
        var birds = new Bloodhound({
            datumTokenizer: Bloodhound.tokenizers.obj.whitespace('species'),
            queryTokenizer: Bloodhound.tokenizers.whitespace,
            prefetch: 'birds.json'
          });    
        
    
        // Constructing the suggestion engine
    
        var places = new BloodHound({
            
        })
    
        
    
        // Initializing the typeahead
    $('.filter-search').on('change', function() {
        if (this.value === "species") {
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
        }else{
            $('.typeahead').typeahead('destroy');
            console.log('mauvais filtre');
        } 
    }); 
     
    
});
