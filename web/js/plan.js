$(document).ready(function() {
    
    $('#plan-salle .content .rangee').mouseenter(function(e) {
        //if ($('#plan-salle').data('show') != 1) {
            $('.rangee'+$(this).data('num')).toggleClass('hide');
        //}
        $(this).css("background-color", 'rgb(255,255,170)');
    });

    $('#plan-salle .content .rangee').mouseout(function(e) {
        //if ($('#plan-salle').data('show') != 1) {
            $('.rangee'+$(this).data('num')).toggleClass('hide');
            $('.rg').addClass('hide');
        //}
        $(this).css('background-color', 'lightgrey');
    });

    $('#plan-salle .content .rangee').click(function(e) {
        $('#plan-salle').data('show', 1);

        $('.rg, .crg').addClass('hide');
        $('.crangee'+$(this).data('num')).removeClass('hide');
    });

});