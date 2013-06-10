$(document).ready(function() {
    
    $('#plan-salle .content .rangee').mouseenter(function(e) {
        if ($('#plan-salle').data('show') != 1) {
            $('.rangee'+$(this).data('num')).toggleClass('hide');
            $('.gauche, .droite, .centre').toggleClass('hide');
        }
        
    });

    $('#plan-salle .content .rangee').mouseout(function(e) {
        if ($('#plan-salle').data('show') != 1) {
            $('.rangee'+$(this).data('num')).toggleClass('hide');
            $('.gauche, .droite, .centre').toggleClass('hide');
        }
    });

    $('#plan-salle .content .rangee').click(function(e) {
        $('#plan-salle').data('show', 1);

        $('.rg').addClass('hide');
        $('.rangee'+$(this).data('num')).removeClass('hide');
        $('.gauche, .droite, .centre').removeClass('hide');        
    });

});