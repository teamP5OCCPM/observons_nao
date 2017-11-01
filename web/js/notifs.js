// web/js/countNote.js

function countNotif($containerId, jsonUrl)
{

    // On récupère la balise span pour le nombre des notes à réviser
    var $container = $($containerId);


    // On effectue une requête Ajax pour récupérer les informations de la base de données
    $.ajax({
        type: "GET",
        url: jsonUrl,
        success: function (reponse) {
            $container.text(reponse.message);
        }

    });
}


$(document).ready(function() {

    countNotif('.badge-notif', notifsObsWaiting);

});