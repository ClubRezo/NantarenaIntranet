/**
 * Scripts additionnels pour l'intranet de la Nantarena
 * 
 * @author Drake <drake@nantarena.net>
 * 
 */

$(document).ready(function() {
    $('.cancelable').click(function(e) {
        if (!confirm('Êtes-vous sûr de vouloir effectuer cette action')) {
            e.preventDefault();
        }
    });
});