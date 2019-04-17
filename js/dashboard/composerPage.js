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

function setBookRow(file, filename, index, composerId)
{
    $('<input type="hidden" class="form-control" name="books['+index+'][owner_id]" value="'+composerId+'" />').appendTo(file);
    $('<td class="col-2"></td>').append('<input type="text" class="form-control" name="books['+index+'][title]" value="'+filename+'" />').appendTo(file);
    $('<td class="col-1"></td>').append('<input class="form-control date-year" autocomplete="off" type="number" max="9999" name="books['+index+'][year]" value="">').appendTo(file);
    $('<td class="col-2"></td>').append('<input class="form-control date-year" autocomplete="off" type="text" name="books['+index+'][creator]" value="">').appendTo(file);
    $('<td class="col-5 pr-5"></td>').append('<textarea class="form-control non-cke" name="books['+index+'][description]"></textarea>').appendTo(file);
    return file;
}

function setFilmRow(file, filename, index, composerId)
{
    $('<input type="hidden" class="form-control" name="films['+index+'][owner_id]" value="'+composerId+'" />').appendTo(file);
    $('<td class="col-2"></td>').append('<input type="text" class="form-control" name="films['+index+'][title]" value="'+filename+'" />').appendTo(file);
    $('<td class="col-1"></td>').append('<input class="form-control date-year" autocomplete="off" type="number" max="9999" name="films['+index+'][year]" value="">').appendTo(file);
    $('<td class="col-2"></td>').append('<input class="form-control date-year" autocomplete="off" type="text" name="films['+index+'][creator]" value="">').appendTo(file);
    $('<td class="col-2"></td>').append('<input class="form-control date-year" autocomplete="off" type="text" name="films['+index+'][actors]" value="">').appendTo(file);
    $('<td class="col-5 pr-5"></td>').append('<textarea class="form-control non-cke" name="films['+index+'][description]"></textarea>').appendTo(file);
    return file;
}

function setErrorRow(file)
{
    $('<td class="col-2"></td>').html('<span class="has-error">Ошибка. Неизвестный тип файла</span>').appendTo(file);
    return file;
}

var removeFromList = function (event) {
    $(event.target).siblings('table').find('tbody tr').remove();
    $(event.target).closest('form').get(0).reset();
};


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
        autoUpload: false,//true, //временно
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
                    switch (type) {
                        case 'books':
                            newFile = setBookRow(newFile, name, id, composerId);
                            break;
                        case 'films':
                            newFile = setFilmRow(newFile, name, id, composerId);
                            break;
                        default:
                            newFile = setErrorRow(newFile);
                    }

                    listFiles.append(newFile);
                }
            });
            $('.'+type+'-submit').off('click.fileupload').on('click.fileupload', function () {
                data.submit();
            });
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
            console.log(result);
            var type = this.name;
            var listFiles = $('.composer-' + type).find('.list-composer-' + type).find('tbody');
            var id = data.data.lastModified + data.data.size;
            var file = listFiles.find('#' + id);

            file.attr('id', result.response.id).attr('data-href', result.response.path + result.response.name);
            file.find('.progress-block').remove();
            /*file.find('input[name="title"]').attr('name', 'films[' + result.response.id + '][title]');
            $('<td class="col-1"></td>').append('<input class="form-control date-year" autocomplete="off" type="text" name="films[' + result.response.id + '][year]" value="">').appendTo(file);
            $('<td class="col-2"></td>').append('<input class="form-control date-year" autocomplete="off" type="text" name="films[' + result.response.id + '][creator]" value="">').appendTo(file);
            $('<td class="col-2"></td>').append('<input class="form-control date-year" autocomplete="off" type="text" name="films[' + result.response.id + '][actors]" value="">').appendTo(file);
            $('<td class="col-5 pr-5"></td>').append('<textarea class="form-control non-cke" name="films[' + result.response.id + '][description]"></textarea><span class="remove badge badge-danger badge-pill badge-button"><i class="fa fa-remove" aria-hidden="true"></i></span>').appendTo(file);*/
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
    $('button[type="reset"]').on('click', function(event) {
        removeFromList(event);
    });

    blockFilms.submit(function(e){
        e.preventDefault();
        CKupdate();
        var data = $(this).serializeObject();
        $.ajax({
            url:'/dashboard/composer/' + composerId + '/saveFilms',
            type: 'POST',
            data: data,
            success: function(response) {
                console.log(response);
            },
        });
        //console.log(this, $(this),data);
    });

    blockBooks.submit(function(e){
        e.preventDefault();
        CKupdate();
        var data = $(this).serializeObject();
        $.ajax({
            url:'/dashboard/composer/' + composerId + '/saveBooks',
            type: 'POST',
            data: data,
            success: function(response){
                console.log(response);
            }
        });
        console.log(this, $(this),data);
    });
});

$(document).on('click', 'span.remove.badge', function (event) {
    event.preventDefault();
    removeFile(this);
});

function removeFile(target) {
    let file = $(target).closest('tr');
    let id = $(file).attr('id');
    $.ajax({
        url: '/dashboard/file/remove/',
        data: {id: id},
        success: function (res) {
            if (res) {
                res = JSON.parse(res);
                if (res.response) {
                    var modal = $('#alertModal');
                    if (true === res.response.status) {
                        file.remove();

                        modal.find('.response-message').text(res.response.message);
                        modal.modal('show');
                    } else {
                        modal.find('.response-message').text(res.response.error);
                        modal.modal('show');
                    }
                }
            }
        }
    })
}

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