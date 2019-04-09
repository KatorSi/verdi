var defaultAjax = {
    url: '/verdi/',
    type: 'POST'
};

$.ajaxSetup(defaultAjax);
$(document).ready(function () {
    // $('input.date-year[type="text"]').datepicker({
    //     language: 'ru',
    //     maxViewMode: 'centuries',
    //     minViewMode: 'years',
    //     format: 'yyyy',
    //     startView: 4,
    //     defaultViewDate: {year: 1400}
    // });
    // $('input.date[name="birthDate"], input.date[name="deathDate"]').datepicker({
    //     language: 'ru',
    //     maxViewMode: 4,
    //     minViewMode: 0,
    //     format: 'dd.mm.yyyy',
    //     startView: 4,
    //     defaultViewDate: {year: 1400, month: 1, day: 1}
    // });

    $('[data-autocomplete]').each(function () {
        prepareAutocompletes.call(this);
    });
    $('#toggle-btn').on('click', function (e) {
        e.preventDefault();
        if ($(window).outerWidth() > 1194) {
            $('nav.side-navbar').toggleClass('shrink');
            $('.page').toggleClass('active');
        } else {
            $('nav.side-navbar').toggleClass('show-sm');
            $('.page').toggleClass('active-sm');
        }
    });
});

function deleteItem(id, target) {
    $.ajax({
        url: '/dashboard/' + target + '/delete',
        data: {
            id: id
        },
        success: function (res) {
            if (res) {
                res = JSON.parse(res);
                if (!res.response.error) {
                    $('[data-' + target + '=' + id + ']').remove();
                } else {
                    $('#alertModal2').find('.response-message').text(res.response.status);
                    $('#alertModal2').modal('show');
                }
            }
        }
    })
}

function createItem(target) {
    $.ajaxSetup({
        url: '/dashboard/' + target + '/create'
    });
    var fs = new FormService('.new-' + target + '-form');
    fs.submit(function (res) {
        var response = res.response;
        if (true === response.status) {
            var modal = $('#alertModal2');
            $('#new' + target + 'Modal').modal('hide');
            modal.find('.response-message').text(res.response.message);
            modal.modal('show');
        }

        // if (!res.response.error) $('#' + target + 'Page').replaceWith(res.response.message);
        // $('#alertModal2').find('.response-message').text(res.response.status);
        // $('#alertModal2').modal('show');
        $.ajaxSetup(defaultAjax);
    });
}

function CKupdate() {
    for (var instance in CKEDITOR.instances) {

        if (CKEDITOR.instances.hasOwnProperty(instance)) {
            CKEDITOR.instances[instance].updateElement();
        }
    }
}