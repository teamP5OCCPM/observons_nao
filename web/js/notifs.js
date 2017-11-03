function countNotif($containerId, jsonUrl)
{
    let $container = $($containerId);

    $.ajax({
        type: "GET",
        url: jsonUrl,
        success: function (reponse) {
            if (reponse.message !== false) {
                $container.text(reponse.message);
            }
        }
    });
}

$(document).ready(function() {countNotif('.badge-notif', notifsObs);});
