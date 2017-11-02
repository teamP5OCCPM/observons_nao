
// On récupère le bouton de soumission du formulaire
let $buttonSubmit = $('#appbundle_taxref_save');


// On récupère la div pour l'image de chargement
$imgLoading = $('#img-loading');

// Par défaut on cache le bouton
$buttonSubmit.hide();


// Par défaut on cache la div de l'image de chargement
$imgLoading.hide();


$updateButton = $('#updateButton');




$updateButton.click(function() {
    $imgLoading.show();
});


// On récupère la balise <p> pour afficher le message en cas de mauvais fichier
$messageBdd = $('#messageBdd');

$(document).ready(function () {

    // On récupère le champ de sélection du fichier
    let $inputFile = $('#appbundle_taxref_csvFile_file');


    $($inputFile).change(function() {

        // On explose la chaîne dans un tableau de valeur
        let $file_name = $inputFile.val().split('.');

        // On récupère l'extension du fichier
        let $extension = $file_name[2];

        console.log($extension);

        // On effectue une condition
        // Dans le cas ou le fichier est bien un fichier csv on affiche le bouton
        if ($extension === 'csv') {
            $messageBdd.empty();
           $buttonSubmit.show();
        } else {
            $messageBdd.append('<div class="alert alert-danger">Le fichier ajouté ne correspond pas au fichier Taxref !!!</div>')
            $buttonSubmit.hide();
        }

    });



});