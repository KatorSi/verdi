function Popup_v2(options) {
    var
        self = this,
        createDiv = function(className) {
            var $d = $('<div>');
            if(typeof className != 'undefined') $d.addClass(className);
            return $d;
        },
        createFrame = function(src) {
            var $iframe = $('<iframe>');
            $iframe.attr('frameborder',0);
            $iframe.css({
                'width': '100%',
                'height': '100%',
            }).addClass('loading');
            if(typeof src != 'undefined') $iframe.attr('src',src);
            return $iframe;
        },
        controlBtns = function() {
            var $c = $('<div>');
            $c.addClass('close-btn').append('<i class="glyphicon glyphicon-remove"></i>');
            var $b = $('<div>');
            $b.addClass('close-popup-btn').html('<< назад');
            return {
                back_btn : $b,
                remove_btn : $c
            };
        },
        defaultOptions = {
            type: 'block',
            center: false,
            visible: true,
            openUpdate: true,
            backButton: true,
            containerWidth: '.wrap',
            containerHeight: '.wrap',
            backgroundWidth: '100%',
            backgroundHeight: '100%',
        },
        backgroundDiv = createDiv('popup-background'),
        containerDiv = createDiv('popup-content-container'),
        controlsDiv = createDiv('popup-controls'),
        contentDiv = createDiv('popup-content-wrap');

    if(typeof options != 'undefined') {
        $.extend(defaultOptions, options);
    }

    this.center = function() {
        backgroundDiv.css({
            top: '50%',
            left: '50%',
            transform: 'translate(-50%,-50%)',
        });
    },

        this.afterClose = function() {
            if(typeof defaultOptions.afterClose != 'undefined' && typeof defaultOptions.afterClose == 'function') {
                defaultOptions.afterClose();
            }
        },

        this.afterShow = function() {
            setTimeout(function() {
                // contentDiv.find('iframe').removeClass('loading');
            }, 200);
            if(typeof defaultOptions.afterShow != 'undefined' && typeof defaultOptions.afterShow == 'function') {
                defaultOptions.afterShow();
            }
        },

        this.beforeShow = function() {
            if(typeof defaultOptions.beforeShow != 'undefined' && typeof defaultOptions.beforeShow == 'function') {
                defaultOptions.beforeShow();
            }
        },

        this.show = function() {
            self.beforeShow();
            backgroundDiv.show();
            self.afterShow();
        },

        this.hide = function() {
            backgroundDiv.hide();
            self.afterClose();
        },

        this.remove = function() {
            backgroundDiv.remove();
            self.afterClose();
        },

        this.addContent = function(content) {
            switch (defaultOptions.type) {
                case 'iframe':
                    contentDiv.html(createFrame(content));
                    break
                case 'img':
                    contentDiv.html('<img src="'+content+'">');
                    break
                case 'ajax':
                    $.ajax({
                        type: "POST",
                        url: content,
                        cache:false,
                        data:{},
                        success: function(data) {
                            contentDiv.html(data);
                        }
                    });
                    break;
                default:
                    contentDiv.html(content);
                    break;
            }
        },

        this.setCSSOptions = function() {
            /*
            3 size types:
                1. full width of background and container;
                2. full width of background and fixed container;
                3. fixed background and container;
            */
            if(typeof defaultOptions.containerWidth != 'undefined') {
                if(defaultOptions.containerWidth.indexOf('px') >= 0 || defaultOptions.containerWidth.indexOf('%') >= 0) {
                    containerDiv.css('width',defaultOptions.containerWidth);
                } else {
                    if($(defaultOptions.containerWidth).length > 0) {
                        containerDiv.css('width',$(defaultOptions.containerWidth).width());
                    }
                }
            }
            if(typeof defaultOptions.containerHeight != 'undefined') {
                if(defaultOptions.containerHeight.indexOf('px') >= 0 || defaultOptions.containerHeight.indexOf('%') >= 0) {
                    containerDiv.css('height',defaultOptions.containerHeight);
                } else {
                    if($(defaultOptions.containerHeight).length > 0) {
                        containerDiv.css('height',$(defaultOptions.containerHeight).height());
                    }
                }
            }
            if(typeof defaultOptions.backgroundWidth != 'undefined') {
                if(defaultOptions.backgroundWidth.indexOf('px') >= 0 || defaultOptions.backgroundWidth.indexOf('%') >= 0) {
                    backgroundDiv.css('width',defaultOptions.backgroundWidth);
                } else {
                    if($(defaultOptions.backgroundWidth).length > 0) {
                        backgroundDiv.css('width',$(defaultOptions.backgroundWidth).width());
                    }
                }
            }
            if(typeof defaultOptions.backgroundHeight != 'undefined') {
                if(defaultOptions.backgroundHeight.indexOf('px') >= 0 || defaultOptions.backgroundHeight.indexOf('%') >= 0) {
                    backgroundDiv.css('height',defaultOptions.backgroundHeight);
                } else {
                    if($(defaultOptions.backgroundHeight).length > 0) {
                        backgroundDiv.css('height',$(defaultOptions.backgroundHeight).height());
                    }
                }
            }
            if(typeof defaultOptions.backgroundColor != 'undefined') {
                backgroundDiv.css('background-color',defaultOptions.backgroundColor);
            }

            if(defaultOptions.center) {
                this.center();
            }
        },

        this.createPopup = function() {
            var controls = controlBtns();

            this.setCSSOptions();
            this.addContent(defaultOptions.content);

            if(defaultOptions.id) {
                backgroundDiv.attr('data-id',defaultOptions.id);
            }

            if(defaultOptions.openUpdate) {
                controls.back_btn.click(this.remove);
                controls.remove_btn.click(this.remove);
            } else {
                controls.back_btn.click(this.hide);
                controls.remove_btn.click(this.hide);
            }

            if(defaultOptions.backButton) {
                controlsDiv.append(controls.back_btn);
            }
            controlsDiv.append(controls.remove_btn);

            containerDiv.html(controlsDiv).append(contentDiv);
            backgroundDiv.html(containerDiv);
            if(!defaultOptions.visible) {
                backgroundDiv.hide();
            }
            self.beforeShow();
            top.$('body').append(backgroundDiv);
            self.afterShow();
        },
        this.init = function() {
            if(defaultOptions.openUpdate) {
                $('body .popup-background').not('[data-id]').remove();
                $('body .popup-background[data-id]').hide();
                this.createPopup();
            } else {
                if($('body .popup-background').length > 0) {
                    if($('body .popup-background[data-id="'+defaultOptions.id+'"]').length > 0) {
                        backgroundDiv = $('body .popup-background[data-id="'+defaultOptions.id+'"]');
                        this.show();
                    } else {
                        //$('body .popup-background').remove();
                        this.createPopup();
                    }
                } else {
                    this.createPopup();
                }
            }
        };
    this.init();
}
function fullSizePopup(options) {
    var defaults = {
        containerWidth : '100%',
        containerHeight : '100%',
    }
    $.extend(defaults,options);
    return new Popup_v2(defaults);
}
function wrapSizePopup(options) {
    return new Popup_v2(options);
}

function changeProfilePic(btn) {
    var popup = new Popup_v2({
        id: 'profilePic',
        type: 'iframe',
        center: true,
        content: $(btn).data('thehref'),
        backButton: false,
        containerWidth: '100%',
        containerHeight: '100%',
        backgroundColor: 'transparent',
        backgroundWidth: '580px',
        backgroundHeight: '680px',
        afterClose: function() { $('[data-onclick="profilePopup"]').removeClass('active-btn') }
    });
    return false;
}