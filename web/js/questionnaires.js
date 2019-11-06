if (typeof jQuery == 'undefined') {
    alert('Для работы опроса необходим jQuery.');
} else {
    var scripts = document.getElementsByTagName('script'), domain = scripts[scripts.length - 1].src.split('/js/')[0], head = document.getElementsByTagName('head')[0], link = document.createElement('link');

    link.rel = 'stylesheet';
    link.type = 'text/css';
    link.href = domain + '/css/modal.css';
    head.appendChild(link);

    $('body').append('<div id="questionnaires_modal" class="qModal"><div class="modalContent"><span class="closeModal">&times;</span><div class="modalBody"></div><img id="loading" src="' + domain + '/images/loading.gif"/></div></div>');

    var modal = $('#questionnaires_modal');
        
    $(document).on('click', '.closeModal', function(e){
        modal.hide();
        $('#loading').show();
    });
    window.onclick = function(event) {
        if (event.target == document.getElementById('questionnaires_modal')) {
            modal.hide();
            $('#loading').show();
        }
    }
    $(document).on('click', 'a[data-questionnaire]', function(e){
        e.preventDefault();
        modal.find('.modalBody').html('<iframe id="container" src="' + domain + '/questionnaires/view?id=' + $(this).data('questionnaire') + '" scrolling="auto" frameborder="0" onload="$(\'#loading\').hide();"></iframe>');
        modal.show();
    });
}