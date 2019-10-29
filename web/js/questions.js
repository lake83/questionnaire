$(document).on('click', '.q_buttons button[type="button"]', function(e){
    var block = $('.q_content div:visible').eq(0), id = parseInt(block.attr('id')), current = 0, progress = 0;
        
    if ($(this).is('#next')) {
        current = $('#' + (id+1)); progress = current.data('progress');
    } else {
        current = $('#' + (id-1)); progress = current.data('progress');
    }
    if (current.length) {
        block.hide();
        current.show();
    }
    if ($('.second-col .discount').length) {
        $('.second-col .discount strong').text(current.data('discount'));
    }
    $('.q_buttons small span').text(progress);
    $('.progress-bar').css('width', progress + '%').attr('aria-valuenow', progress);
    $('.second-col .description').html(current.data('hint'));
    
    if (current.hasClass('test_done')) {
        $('.q_buttons button[type="button"]').hide();
        $('#send').show();
    }
});

$('#dynamicmodel-conditions').click(function() {
    if ($(this).is(":checked")) {
        $('#send').removeAttr('disabled');
    } else {
        $('#send').attr('disabled', 'disabled');
    }
});