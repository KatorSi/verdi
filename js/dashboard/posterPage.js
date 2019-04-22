var alertModal = $('#alertModal');

function updatePoster() {
    $.ajaxSetup({url: '/dashboard/poster/update/'});
    var fs = new FormService('.poster-form');
    setTimeout(function(){
        fs.submit(function (res) {
            alertModal.find('.response-message').text(res.response.status);
            alertModal.modal('show');
            $('[data-autocomplete]').each(function () {
                prepareAutocompletes.call(this);
            });
            $.ajaxSetup(defaultAjax);
        });
    },200);

}