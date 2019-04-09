function AutocompleteService() {
}

AutocompleteService.prototype.requestArray = function (route) {
    return $.ajax({
        url: route,
        data: {
            name: 'select'
        }
    })
};
AutocompleteService.prototype.match = function (search, list) {
    var rgx = new RegExp(search, 'i');
    return list.filter(function (item) {
        return rgx.test(item.title);
    });
};

function prepareAutocompletes() {
    var target = this.dataset.autocomplete,
        completeArray = [],
        that = this,
        autoComplete = new AutocompleteService;

    var createAutoCompleteButton = function (data, target) {
        var btn = $('<button class="dropdown-item" type="button"></button>');
        btn[0].dataset.id = data.id;
        btn[0].dataset.title = data.title;
        btn[0].dataset.target = target;
        btn.text(data.title);
        return btn;
    };

    $('[data-autocompleteList=' + target + ']').html('');
    autoComplete.requestArray('/dashboard/' + target).done(function (res) {
        if (res) {
            res = JSON.parse(res);
            if (!res.error) {
                completeArray = res.response;
                for (var i = 0; i < res.response.length; i++) {
                    var btn = createAutoCompleteButton(res.response[i], target);
                    btn.click(function () {
                        $('input[name=' + this.dataset.target + ']').val(this.dataset.title);
                        $('input[name=' + this.dataset.target + '_id]').val(this.dataset.id);
                        $('[data-autocompleteList=' + this.dataset.target + ']').removeClass('show');
                    });
                    $('[data-autocompleteList=' + target + ']').append(btn);
                }
                that.disabled = false;
            }
        }
    });

    $(this)
        .on('focus', function (event) {
            $('[data-autocompleteList=' + this.dataset.autocomplete + ']').addClass('show');
        })
        .on('blur', function (event) {
            if (event.relatedTarget && event.relatedTarget.dataset.target && event.relatedTarget.dataset.target == this.dataset.autocomplete) return false;
            var matched = autoComplete.match(this.value, completeArray);
            if (matched.length && this.value.length) {
                $('input[name=' + this.dataset.autocomplete + ']').val(matched[0].title);
                $('input[name=' + this.dataset.autocomplete + '_id]').val(matched[0].id);
            }
            $('[data-autocompleteList=' + this.dataset.autocomplete + ']').removeClass('show');
        })
        .on('keyup', function (event) {
            var target = this.dataset.autocomplete, matched = [];
            if (this.value.length >= 2) matched = autoComplete.match(this.value, completeArray);
            if (matched.length) {
                $('[data-autocompleteList=' + target + ']').find('button').hide();
                for (var i = 0; i < matched.length; i++) {
                    $('[data-autocompleteList=' + target + ']').find('button[data-id=' + matched[i].id + ']').show();
                }
            } else {
                $('input[name=' + target + '_id]').val(null);
                $('[data-autocompleteList=' + target + ']').find('button').show();
            }
        });
}