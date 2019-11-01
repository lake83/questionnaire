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
    
    var group = current.find('.form-group');
    
    if ((group.hasClass('required') && !group.hasClass('has-success')) || group.hasClass('has-error')) {
        $('#next').attr('disabled', 'disabled');
    } else {
        $('#next').removeAttr('disabled');
    }
    if (current.hasClass('test_done')) {
        $('.q_buttons button[type="button"]').hide();
        $('#send').show();
    }
});

$('#dynamicmodel-conditions').click(function() {
    if ($(this).is(':checked')) {
        $('#send').removeAttr('disabled');
    } else {
        $('#send').attr('disabled', 'disabled');
    }
});

if ($('.q_content div:visible .form-group').hasClass('required')) {
    $('#next').attr('disabled', 'disabled');
}

$('[id^=dynamicmodel-field_]').on('keyup.yii, change.yii', function(){
    if ($(this).closest('.form-group').hasClass('required')) {
        if ($(this).val() != '' || $(this).find('input:checked').length) {
            $('#next').removeAttr('disabled');
        } else {
            $('#next').attr('disabled', 'disabled');
        }
    }
});

$('#datetime-range').on('changeDate', function(e){
    var start = $('#dynamicmodel-datetime_start').val(), end = $('#dynamicmodel-datetime_end').val(),
        field = $(this).parents('.row').find('input[type="hidden"]');
        
    if (start != '' && end != '') {
        field.val(start + ' - ' + end).change();
    } else {
        field.val('').change();
    }
});