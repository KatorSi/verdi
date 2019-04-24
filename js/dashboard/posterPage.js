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

function createPoster() {
    CKupdate();
    $.ajaxSetup({url: '/dashboard/poster/create/'});
    var fs = new FormService('.poster-form');
    $('#newPosterModal').modal('hide');
    fs.submit(function (res) {
        setTimeout(function () {
            if (!res.response.error) {
                $('#posterPage').replaceWith(res.response.message);
            }
            else {
                alertModal.find('.response-message').text(res.response.error.message);
            }
            alertModal.find('.response-message').text(res.response.status);
            alertModal.modal('show');
            $('[data-autocomplete]').each(function () {
                prepareAutocompletes.call(this);
            });
            $.ajaxSetup(defaultAjax);
        }, 200)
    });
}

function deletePoster(id) {
    $.ajax({
        url: '/dashboard/poster/delete',
        data: {
            id: id
        },
        success: function (res) {
            console.log(res);
            if (res) {
                res = JSON.parse(res);
                if (res.response) $('[data-poster=' + id + ']').remove();
            } else {
                alertModal.find('.response-message').text(res.response.status);
                alertModal.modal('show');
                $('[data-autocomplete]').each(function () {
                    prepareAutocompletes.call(this);
                });
            }
        },
        fail: function (error) {
            console.log(error);
        }
    })
}

function createWork()
{
    $('#workAddModal').modal('hide');
    $.ajax({
        url: '/dashboard/works/create',
        method: 'POST',
        data: {
            id: $('input[name="work-composer-id"]').val(),
            title: $('input[name="work-title"]').val(),
        },
        success: function (res) {
            res = JSON.parse(res);
            if (res) {
                alertModal.find('.response-message').text(res.response.status);
            }
            else {
                alertModal.find('.response-message').text(res.response.message);
            }
            alertModal.modal('show');
            $('[data-autocomplete]').each(function () {
                prepareAutocompletes.call(this);
            });
        },
        fail: function (error) {
            console.log(error);
        }
    })
}
