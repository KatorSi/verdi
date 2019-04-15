$(document).ready(function () {
    $('#target').css({marginRight: getScrollbarWidth() + "px"});

    $('.table-default thead tr').on('click', 'td:not([data-sorter="none"])', function (e) {
        if($(e.target).is(':not(select)')) {
            var
                element = $(this),
                sort = element.data('sort');

            if (typeof sort === "undefined") {
                sort = 'asc';
            } else if (sort === 'asc') {
                sort = 'desc'
            } else {
                sort = 'asc';
            }

            $('.table-default thead tr').find('td').removeData('sort').removeAttr('data-sort');
            element.attr('data-sort', sort).data('sort', sort);

            var collection = $(".table-data > tbody tr.sort");

            collection.sort(function (a, b) {
                var value = $(a).find('td:eq(' + element.index() + ')').text().toString().toLowerCase().trim();
                var value1 = $(b).find('td:eq(' + element.index() + ')').text().toString().toLowerCase().trim();

                if (sort === 'asc') {
                    return value1 < value ? 1 : -1;
                } else {
                    return value < value1 ? 1 : -1
                }

            }).appendTo($('.table-data > tbody'));
        }
    });




    $('#country').change(function () {
        var $value = $(this).find("option:selected").val();
        var $collection = $(".table-default").find(".inFilter");
        refresh($collection);
        $collection.each(function (index, item) {
            if ($value !== "all") {
                $collection.each(function (index, item) {
                    if (item.getAttribute("data-country") !== $value) {
                        item.classList.add("hidden");
                    }
                });
            }
        });
    });

    $('#genre').change(function () {
        var $value = $(this).find("option:selected").val();
        var $collection = $(".table-default").find(".inFilter");
        refresh($collection);
        $collection.each(function (index, item) {
            if ($value !== "all") {
                $collection.each(function (index, item) {
                    if (item.getAttribute("data-genre") !== $value) {
                        item.classList.add("hidden");
                    }
                });
            }
        });
    });

    function refresh(collection) {
        collection.each(function (index, item) {
            item.classList.remove("hidden");
        });
    }

    function getScrollbarWidth() {
        var outer = document.createElement("div");
        outer.style.visibility = "hidden";
        outer.style.width = "100px";
        document.body.appendChild(outer);

        var widthNoScroll = outer.offsetWidth;
        // force scrollbars
        outer.style.overflow = "scroll";

        // add innerdiv
        var inner = document.createElement("div");
        inner.style.width = "100%";
        outer.appendChild(inner);

        var widthWithScroll = inner.offsetWidth;

        // remove divs
        outer.parentNode.removeChild(outer);

        return widthNoScroll - widthWithScroll;
    }


    $('.opera-view-full-history').click(function (e) {
        e.preventDefault();
        var operaFullHistory = $('.opera-full-history');
        if (operaFullHistory.is(':visible')) {
            operaFullHistory.slideUp(300);
            $(this).text('(Развернуть)');
        } else {
            operaFullHistory.slideDown(300);
            $(this).text('(Свернуть)');
        }
    });


    // close lk page
    /*$(document).on('click', '#ok', function() {
        $('#lk_page .close').trigger('click');
    });
    $(document).on('click', '.fancybox-item.fancybox-close', function() {
        $('#lk_page .close').trigger('click');
    });*/
    $(document).on('click', '#auth_login', function() {
        $('#lk_page .close').trigger('click');
    });

});

// composers
$(function () {
    var popup = $('.popup-window');
    popup.find('.btn-back').on('click', 'a', function (e) {
        e.preventDefault();
        popup.hide();
        popup.find('.list-films tbody tr').unbind('click');
    });

    $('.open-videos').click(function (e) {
        e.preventDefault();
        popup.show();
        popup.find('.opera-video-block').show();
        popup.find('.list-films tbody').on('click', 'tr[data-href]', function () {
            var link = $(this).data('href'),
                playerBlock = popup.find('.opera-video-player'),
                video = $('<video autoplay></video>').attr('src', link);

            playerBlock.html(video).show();
            video.videoplayer({fullScreen: true, autoplay: true}, false);
            setTimeout(function () {
                playerBlock.on('click', '#actionClose', function () {
                    playerBlock.empty()
                });
            }, 500)
        })
    });
});