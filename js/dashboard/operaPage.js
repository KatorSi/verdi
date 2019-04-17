$(function () {
    $('textarea').ckeditor({
        language: 'ru',
        height: '350px'
    });

    var operaId = $('input[name="id"]').val();
    var operaFiles = $('.opera-files');
    var listFiles = null;

    var options = {
        singleFileUploads: true,
        autoUpload: true,
        async: true,
        maxChunkSize: 10000000,
        type: 'PUT',
        multipart: false,
        add: function (e, data) {
            var type = this.name;
            listFiles = operaFiles.find('.list-' + type);


            data.originalFiles.forEach(function (file) {
                data.url = '/dashboard/opera/' + operaId + '/upload/' + type + '?s=' + file.size;
                var id = file.size;
                if (listFiles.find('#' + id).length === 0) {
                    var newFile = $('<a></a>').attr('href', '#').attr('id', id).addClass('list-group-item list-group-item-action d-flex justify-content-between align-items-center');

                    var name = file.name.split('.');
                    name.pop();

                    $('<span></span>').addClass('file-title w-50').text(name.join('.')).appendTo(newFile);
                    $('<div class="progress w-50"><div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0;"></div></div>').appendTo(newFile);
                    $('<span class="badge badge-danger badge-pill badge-button"><i class="fa fa-remove" aria-hidden="true"></i></span>').appendTo(newFile);
                    listFiles.append(newFile);
                }
            });

            data.submit();
        },

        progress: function (e, data) {
            var type = this.name;
            var listFiles = operaFiles.find('.list-' + type);
            var id = data.total;

            var file = listFiles.find('#' + id);
            var progress = parseInt(data.loaded / data.total * 100, 10);
            file.find('.progress-bar').css('width', progress + '%').text(progress + '%');
            console.log(data.loaded, data.total);
        },

        done: function (e, data) {
            var result = JSON.parse(data.result);

            console.log(data);
            var type = this.name;
            var listFiles = operaFiles.find('.list-' + type);
            var id = data.total;
            var file = listFiles.find('#' + id);

            file.attr('id', result.response.id).attr('data-href', result.response.path + result.response.name);
            file.find('.progress').remove();

        },
        error: function(e, data){
            console.log(e, data);
        }
    };


    $('#validate').mouseover(function () {
        if ($('#indicator').val() === '') {
            $('#message').html("<span class='alert_custom'>Создайте композитора!</span>");
            setTimeout(function () {
                $('#message').html("");
            }, 1500);
        }
    });

    operaFiles.find('input[type="file"]').fileupload(options);
    operaFiles
        .on('click', 'button.upload', function () {
            $('input[type="file"][name="' + this.dataset.type + '"]').click();
        });

    $(document)
        .on('click', 'a[href="#"]', function (event) {
            event.preventDefault();
            var href = $(this).data('href');
            if (href && href !== '' && $(event.target).is('a, .file-title')) {
                window.open(href, '_blank');
            } else {
                removeFile(event.target);
            }
        })
        .on('click', '.add-opera-production', addOperaProduction);

    // переключение списка композиторов
    $(document).on('click', 'button.composer_check', function(event) {
        var composerId = $(event.target).attr('data-composer');
        var $againstComposer = $('button:not([data-composer="'+composerId+'"])[data-composer]');
        console.log($(event.target));
        console.log(composerId);
        console.log($againstComposer);
        if ($(event.target).hasClass('active') === true && $againstComposer.hasClass('active') === false) {
            $(event.target).removeClass('active');
            $('div[data-composer]').each(function (index, item) {
                $(item).removeClass('d-none');
                $(item).addClass('d-flex');
            });
        }
        else if ($(event.target).hasClass('active') === false && $againstComposer.hasClass('active') === true) {
            $againstComposer.removeClass('active');
            $(event.target).addClass('active');
            $('div[data-composer="'+$againstComposer.attr('data-composer')+'"]').each(function (index, item) {
                $(item).addClass('d-none');
                $(item).removeClass('d-flex');
            });
            $('div[data-composer="'+composerId+'"]').each(function (index, item) {
                $(item).removeClass('d-none');
                $(item).addClass('d-flex');
            });
        }
        else {
            $(event.target).addClass('active');
            $('div[data-composer="'+$againstComposer.attr('data-composer')+'"]').each(function (index, item) {
                $(item).addClass('d-none');
                $(item).removeClass('d-flex');
            });
        }

    });
});

function addOperaProduction() {
    var listProductions = $('.list-opera-productions').find('tbody');

    var newItem = $('<tr></tr>').addClass('d-flex');
    $('<td></td>').addClass('col-1').append('<input type="text" class="year form-control" name="yearProduction" />').appendTo(newItem);
    $('<td></td>').addClass('col-1').append('театр').appendTo(newItem);
    $('<td></td>').addClass('col-1').append('Дирижер').appendTo(newItem);
    $('<td></td>').addClass('col-1').append('Сонет').appendTo(newItem);
    $('<td></td>').addClass('col-8').append('Время').appendTo(newItem);

    listProductions.append(newItem);
}

var alertModal = $('#alertModal');

$(document).on({
    ajaxStart: function () {
        $("body").addClass("loading");
    },
    ajaxStop: function () {
        $("body").removeClass("loading");
    }
});

function removeFile(target) {
    var file = $(target).parents('a');
    var id = file.attr('id');
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

function createOpera() {
    CKupdate();
    $.ajaxSetup({url: '/dashboard/opera/create/'});
    var fs = new FormService('.opera-form');
    $('#newOperaModal').modal('hide');
    fs.submit(function (res) {
        setTimeout(function () {
            if (!res.response.error) {
                $('#operasPage').replaceWith(res.response.message);
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

function deleteOpera(id) {


    $.ajax({
        url: '/dashboard/opera/delete',
        data: {
            id: id
        },
        success: function (res) {
            if (res) {
                res = JSON.parse(res);
                if (res.response) $('[data-opera=' + id + ']').remove();
            } else {
                alertModal.find('.response-message').text(res.response.status);
                alertModal.modal('show');
                $('[data-autocomplete]').each(function () {
                    prepareAutocompletes.call(this);
                });
            }
        }
    })
}

function updateOpera() {
    $.ajaxSetup({url: '/dashboard/opera/update/'});
    var fs = new FormService('.opera-form');

    CKupdate();
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