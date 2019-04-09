function deleteComposer(id) {

    $.ajax({
        url: '/dashboard/composer/delete',
        data: {
            id: id
        },
        success: function (res) {
            if (res) {
                res = JSON.parse(res);
                if (res.response) $('[data-composer=' + id + ']').remove();
            } else {
                $('#alertModal').find('.response-message').text(res.response.status);
                $('#alertModal').modal('show');
                $('[data-autocomplete]').each(function () {
                    prepareAutocompletes.call(this);
                });
            }
        }
    })
}

function createComposer() {
    CKupdate();
    var fs = new FormService('.new-composer-form');
    $('#newComposerModal').modal('hide');
    $.ajaxSetup({url: '/dashboard/composer/create'});
    fs.submit(function (res) {
        setTimeout(function () {
            if (!res.response.error) {
                $('#composersPage').replaceWith(res.response.message);
            }
            $('#alertModal').find('.response-message').text(res.response.status);
            $('#alertModal').modal('show');
            $('[data-autocomplete]').each(function () {
                prepareAutocompletes.call(this);
            });
            $.ajaxSetup(defaultAjax);
        }, 200)
    });
}

function updateComposer() {
    CKupdate();
    var fs = new FormService('.edit-composer-form');

    $.ajaxSetup({url: '/dashboard/composer/update'});
    fs.submit(function (res) {
        $('#alertModal').find('.response-message').text(res.response.status);
        $('#alertModal').modal('show');
        $('[data-autocomplete]').each(function () {
            prepareAutocompletes.call(this);
        });
        $.ajaxSetup(defaultAjax);
    });
}



$(function(){
    $( 'textarea:not(.non-cke)' ).ckeditor({
        language: 'ru',
        height: '350px'
    });
    var composerId = $('input[name="id"]').val(),
        blockFilms = $('form.composer-films'),
        blockBooks = $('form.composer-books');

    var options = {
        singleFileUploads: true,
        autoUpload: true,
        async: true,
        type: 'PUT',
        multipart: false,
        add: function (e, data) {
            var type = this.name;
            var listFiles = $('.composer-' + type).find('.list-composer-' + type).find('tbody');
            data.url = '/dashboard/composer/' + composerId + '/upload/' + type;

            data.originalFiles.forEach(function (file) {

                var id = file.lastModified + file.size;
                if (listFiles.find('tr#' + id).length === 0) {
                    var newFile = $('<tr></tr>').attr('id', id);

                    var name = file.name.split('.');
                    name.pop();
                    if(type === 'films'){
                        $('<td class="col-2"></td>').html('<input type="text" class="form-control" name="title" value="' +  name + '" />').appendTo(newFile);
                        $('<td class="col-10 progress-block" colspan="4"><div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0;"></div></div></td>').appendTo(newFile);
                    }

                    listFiles.append(newFile);
                }
            });

            data.submit();
        },

        progress: function (e, data) {
            var type = this.name;
            var listFiles = $('.composer-' + type).find('.list-composer-' + type).find('tbody');
            var id = data.data.lastModified + data.data.size;
            var file = listFiles.find('tr#' + id);
            var progress = parseInt(data.loaded / data.total * 100, 10);
            file.find('.progress-bar').css('width', progress + '%').text(progress + '%');
        },

        done: function (e, data) {
            var result = JSON.parse(data.result);

            var type = this.name;
            var listFiles = $('.composer-' + type).find('.list-composer-' + type).find('tbody');
            var id = data.data.lastModified + data.data.size;
            var file = listFiles.find('#' + id);

            file.attr('id', result.response.id).attr('data-href', result.response.path + result.response.name);
            file.find('.progress-block').remove();
            file.find('input[name="title"]').attr('name', 'films[' + result.response.id + '][title]');
            $('<td class="col-1"></td>').append('<input class="form-control date-year" autocomplete="off" type="text" name="films[' + result.response.id + '][year]" value="">').appendTo(file);
            $('<td class="col-2"></td>').append('<input class="form-control date-year" autocomplete="off" type="text" name="films[' + result.response.id + '][creator]" value="">').appendTo(file);
            $('<td class="col-2"></td>').append('<input class="form-control date-year" autocomplete="off" type="text" name="films[' + result.response.id + '][actors]" value="">').appendTo(file);
            $('<td class="col-5 pr-5"></td>').append('<textarea class="form-control non-cke" name="films[' + result.response.id + '][description]"></textarea><span class="remove badge badge-danger badge-pill badge-button"><i class="fa fa-remove" aria-hidden="true"></i></span>').appendTo(file);
        }
    };

    blockFilms.find('input[type="file"]').fileupload(options);
    blockBooks.find('input[type="file"]').fileupload(options);

    $('.block-composer-films')
        .on('click', 'button.upload', function () {
            $('input[type="file"][name="films"]').click();
        });
    $('.block-composer-books')
        .on('click', 'button.upload', function () {
            $('input[type="file"][name="books"]').click();
        });

    blockFilms.submit(function(e){
        e.preventDefault();
        CKupdate();
        var data = $(this).serializeObject();
        $.ajax({
            url:'/dashboard/composer/' + composerId + '/saveFilms',
            type: 'POST',
            data: data,
            success: function(response){
                console.log(response);
            }
        });
        console.log(this, $(this),data);
    });
});

$.fn.serializeObject = function() {
    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
};