$(document).on('click', '.q_buttons button[type="button"]', function(e){
    var block = $('.q_content div.q_content_block:visible').eq(0), id = parseInt(block.attr('id')), current = 0, progress = 0;
        
    if ($(this).is('#next')) {
        current = $('#' + (id+1)); progress = current.data('progress');
    } else {
        current = $('#' + (id-1)); progress = current.data('progress');
    }
    if (current.length) {
        block.hide();
        current.show();
    }
    if ($('.discount').length) {
        $('.discount strong').text(current.data('discount'));
        $('#dynamicmodel-discount').val(current.data('discount'));
    }
    $('.q_buttons small span').text(progress);
    $('.progress-bar').css('width', progress + '%').attr('aria-valuenow', progress);
    $('.description').html(current.data('hint'));
    
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
    if (current.find('.slick-slider').length) {
        $('.slick-slider').slick('resize');
    }
});

$('#dynamicmodel-conditions').click(function() {
    if ($(this).is(':checked')) {
        $('#send').removeAttr('disabled');
    } else {
        $('#send').attr('disabled', 'disabled');
    }
});

if ($('.q_content div.q_content_block:visible .form-group').hasClass('required')) {
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

$('[id^=datetime-range_]').on('changeDate', function(e){
    var start = $(this).find('input[id^=dynamicmodel-datetime_start_]').val(),
        end = $(this).find('input[id^=dynamicmodel-datetime_end_]').val(),
        field = $(this).parents('.row').find('input[type="hidden"]');
        
    if (start != '' && end != '') {
        field.val(start + ' - ' + end).change();
    } else {
        field.val('').change();
    }
});

$('.slider_field input').on('slideStop', function(slideEvt) {
	var slider = $(this).parents('.slider_field');
    
    if (!isNaN(slideEvt.value[0])) {
        slider.find('.min').text(slideEvt.value[0]);
    }        
    if (!isNaN(slideEvt.value[1])) {
        slider.find('.max').text(slideEvt.value[1]);
    }
});