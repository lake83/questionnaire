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
    $('.description span').html(current.data('hint'));
    
    var group = current.find('.form-group');
    
    if ((group.hasClass('required') && !group.hasClass('has-success')) || group.hasClass('has-error')) {
        $('#next').attr('disabled', 'disabled');
    } else {
        if (id != 0) {
            $('#next').removeAttr('disabled');
        }
    }
    if (current.hasClass('test_done')) {
        $('.q_buttons button[type="button"]').hide();
        $('#dynamicmodel-referrer').val(document.referrer);
        $('#send').show();
    }
    if (current.find('.slick-slider').length) {
        $('.slick-slider').slick('resize');
    }
});

$('.type_options_and_img').on('click', function() {
    $(this).parents('.slick-slide').find('input').trigger('click');
});
$('.type_options_and_img_check .type_options .checkbox, .type_options_check .type_options .checkbox, .type_options_and_img_check .type_options .checkbox label, .type_options_check .type_options .checkbox label').on('click', function(e) {
    if (!$(e.target).is('input:checkbox')) {
        var checkbox = $(this).find('input:checkbox');
        checkbox.prop('checked', !checkbox.prop('checked')).change();
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
    var $this = $(this);
    if ($this.closest('.form-group').hasClass('required')) {
        if ($this.val() != '' || $this.find('input:checked').length) {
            $('#next').removeAttr('disabled');
        } else {
            $('#next').attr('disabled', 'disabled');
        }
    }
});

$('.slider_field input').on('slideStop', function(slideEvt) {
	var slider = $(this).parents('.slider_field');
    
    if (!isNaN(slideEvt.value[0])) {
        slider.find('.min strong').text(formatSlider(slideEvt.value[0]));
    }        
    if (!isNaN(slideEvt.value[1])) {
        slider.find('.max strong').text(formatSlider(slideEvt.value[1]));
    }
});

function formatSlider(val)
{
    while (/(\d+)(\d{3})/.test(val.toString())){
        val = val.toString().replace(/(\d+)(\d{3})/, '$1' + ' ' + '$2');
    }
    return val;
}

$('#date-field, #time-field').on('change', function() {
    var date = $('#date-field').val(), time = $('#time-field').val();
    if (date != '' && time != '') {
        $('#dynamicmodel-field_1').val(date + ' ' + time).change();
    } else {
        $('#next').attr('disabled', 'disabled');
    }
});