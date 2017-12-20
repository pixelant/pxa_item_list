// this file is disabled by default.
// If you need to use custom.js in your project you need to enable it in TS.
// themes_t3kit/Configuration/TypoScript/Library/page.includeJS.setupts
$(document).ready(function () {
    var PxaProjectDetailView = function () {
        var self = this;

        self.scrollFix = '';
        self.currentVisible = null;
        self.detailDesktopViewHeight = 0;
        self.detailMobileViewHeight = 0;
        self.smallMobilePreviewHeightFix = 0;
        self.smallDesktopPreviewHeightFix = 0;
        self.transEndEventName = '';
        self.init = function () {
            var item = $('#items-list');
            self.scrollFix = item.data('scroll-fix');
            self.detailDesktopViewHeight = item.data('detail-desktop-height');
            self.detailMobileViewHeight = item.data('detail-mobile-height');
            self.smallMobilePreviewHeightFix = item.data('detail-small-mobile-preview-height-fix');
            self.smallDesktopPreviewHeightFix = item.data('detail-small-desktop-preview-height-fix');

            self.transEndEventName = self.whichTransitionEvent();

            $('.item-item .item-short-info').on('click', function (e) {
                self.click(e, $(this).parent());
            });

            // hide all visible on filtering
            $('#categories-filter input[type="checkbox"]').on('change', function () {
                if (self.currentVisible != null) {
                    self.hideVisible(self.currentVisible, false);
                    self.currentVisible = null;
                    $('.item-item').css('height', 'auto').removeClass('active');
                }
            });
        };

        self.click = function (event, elem) {
            event.preventDefault();

            var isAnyVisible = self.currentVisible !== null;
            var currentTempVisible = isAnyVisible ? self.currentVisible : null;
            var additionScroll = 0;

            // initialize again
            self.currentVisible = null;
            if (isAnyVisible && currentTempVisible.data('uid') == elem.data('uid')) {
                self.hideVisible(currentTempVisible, true);
                // remove hash
                history.pushState("", document.title, window.location.pathname);
            } else if (isAnyVisible && currentTempVisible.data('uid') != elem.data('uid')) {
                if (self.isSameRow(elem, currentTempVisible)) {
                    currentTempVisible.css('visibility', 'hidden');
                    self.showDetailView(elem, false);
                    self.hideVisible(currentTempVisible, false);
                } else {
                    self.showDetailView(elem, true);
                    self.hideVisible(currentTempVisible, true);
                    additionScroll = self.isBelowRow(elem, currentTempVisible) ? self.getDetailViewHeight() : 0;
                }
            } else {
                self.showDetailView(elem, true);
            }

            self.scroll(elem, additionScroll);
        };

        // check if last opened element and new are on a same row. then don't need any animation
        self.isSameRow = function (elem, currentVisible) {
            var elemPrevious = $('#item-item-' + currentVisible.data('uid'));

            return elem.offset().top == elemPrevious.offset().top;
        };

        self.isBelowRow = function (elem, currentVisible) {
            var elemPrevious = $('#item-item-' + currentVisible.data('uid'));

            return elem.offset().top > elemPrevious.offset().top;
        };

        self.showDetailView = function (elem, animate) {
            var template = $('#preview').clone();

            var images = elem.data('image').split(',|,');
            if (images.length > 1) {
                var image = $('#carousel-example-generic-detail-project').clone();
                var imageSlideWrapper = image.find('.carousel-inner');
                image.attr('id', 'carousel-detail-project');
                image.find('.carousel-control').attr('href', '#carousel-detail-project');

                for (var i = 0; i < images.length; i++) {
                    var imageTemp = $('<img/>', {
                        src: images[i],
                        alt: elem.data('name')
                    });

                    var imageWrapp = $('<div/>', {
                        html: imageTemp,
                        class: 'item' + (i === 0 ? ' active' : '')
                    });
                    imageSlideWrapper.append(imageWrapp);
                }

                image.removeClass('hidden').carousel();
            } else if (images.length === 1) {
                var img = '<img src="' + elem.data('image-public-url') + '" class="img-responsive">';
                var image = $('<img/>', {
                    src: images[0],
                    alt: elem.data('name'),
                    class: 'img-responsive'
                });
            } else {
                var img = '<img src="' + elem.data('image-public-url') + '" class="img-responsive">';
                var image = $('<img/>', {
                    src: images[0],
                    alt: elem.data('name')
                });
            }

            //elem.css('height', self.listItemHeight + 'px');

            // fill it with info
            template.find('.row .preview-img').append(image);

            template.attr('id', 'detailView');
            template.data('uid', elem.data('uid'));
            template.css('height', '0');
            template.css('display', 'block');
            if (animate) {
                template.css('transition', 'height 350ms linear');
            } else {
                template.css('transition', 'none');
            }

            var fields = ['name', 'customer', 'product_choice', 'architect', 'consultant', 'installer', 'description', 'categories'];
            for (var i = 0; i < fields.length; i++) {
                var value = elem.data(fields[i]);
                var fieldWrapper = template.find('.item-' + fields[i]);
                if (value.length > 0 && value !== '0') {
                    var method = fields[i] === 'description' ? 'html' : 'text';
                    fieldWrapper[method](value);
                } else {
                    value = TYPO3.lang['label.none'];
                    var method = fields[i] === 'description' ? 'html' : 'text';
                    fieldWrapper[method](value);
                }
            }

            var pdfUrl = elem.data('pdf-public-url');
            if (pdfUrl) {
                template.find('a[data-usage="template-pdf"]').attr('href', pdfUrl).show();
            } else {
                template.find('a[data-usage="template-pdf"]').hide();
            }

            elem.find('.item-short-info').after(template);
            if (animate) {
                elem.css('transition', 'height 350ms linear');
            } else {
                elem.css('transition', 'none');
            }
            elem.css('height', elem.outerHeight() + self.getDetailViewHeight(true) + 'px').addClass('active');
            self.currentVisible = template;
            self.currentVisible.css('height', self.getDetailViewHeight() + 'px');
            self.currentVisible.find('.preview-detail').css('height', self.getDetailViewHeight() + 'px');

            // init scroll container
            var swiper = new Swiper(template.find('.swiper-container-project-view'), {
                direction: 'vertical',
                slidesPerView: 'auto',
                freeMode: true,
                mousewheelReleaseOnEdges: true,
                scrollbarHide: true
            });

            var scrollButton = template.find('.small_arrow'),
                mainDescriptionWrapper = template.find('.main-description-area');

            scrollButton.on('click', function (e) {
                self.scrollClick(e, $(this), swiper, mainDescriptionWrapper);
            });

            //set hash
            window.location.hash = 'detail=' + elem.data('uid');
        };

        self.hideButton = function () {
            self.hideVisible(self.currentVisible, true);
            self.currentVisible = null;
            history.pushState("", document.title, window.location.pathname);
        };

        self.scroll = function (elem, additionScroll) {
            $("html, body").animate({
                scrollTop: elem.offset().top - self.scrollFix - additionScroll
            }, 600);
        };

        self.hideVisible = function (currentVisible, animate) {
            var elem = $('#item-item-' + currentVisible.data('uid'));
            elem.removeClass('active');

            if (animate) {
                elem.css('transition', 'height 350ms linear');
                currentVisible.css('transition', 'height 350ms linear');

                currentVisible.css('height', '0').one(self.transEndEventName, function () {
                    $(this).remove();
                });
            } else {
                currentVisible.remove();
                elem.css('transition', 'none');
            }

            elem.css('height', elem.outerHeight() - self.getDetailViewHeight(true) + 'px');
        };

        self.getDetailViewHeight = function (forPreview) {
            if ($(window).width() > 767) {
                return self.detailDesktopViewHeight + (forPreview === true ? self.smallDesktopPreviewHeightFix : 0);
            } else {
                return self.detailMobileViewHeight + (forPreview === true ? self.smallMobilePreviewHeightFix : 0);
            }
        };

        // define transitionEnd event
        self.whichTransitionEvent = function () {
            var el = document.createElement('fake'),
                transEndEventNames = {
                    'WebkitTransition': 'webkitTransitionEnd',
                    'MozTransition': 'transitionend',
                    'transition': 'transitionend'
                };
            for (var t in transEndEventNames) {
                if (el.style[t] !== undefined) {
                    return transEndEventNames[t];
                }
            }
        };

        self.scrollClick = function (event, element, swiper, mainDescriptionWrapper) {
            event.preventDefault();

            var scrollDown = !(element.find('.upsidedown').length > 0);

            if ((scrollDown && swiper.isEnd) || (!scrollDown && swiper.isBeginning)) return false;

            var translate = swiper.getWrapperTranslate(),
                step = scrollDown ? -110 : 110;

            swiper.setWrapperTranslate(translate + step);
            self.checkScrollArrowState(swiper, mainDescriptionWrapper);
        };
    };

    var PxaProjectDetailViewObj = new PxaProjectDetailView();
    PxaProjectDetailViewObj.init();

    // if detail view link
    if (window.location.hash) {
        var parts = window.location.hash.substring(1).split('=');

        if (parts[0] != "undefined" && parts[1] != "undefined" && parts[0] == "detail") {
            $('#item-item-' + parts[1] + ' .item-short-info').trigger('click');
        }
    }

    $('.go-top a').on('click', function (e) {
        e.preventDefault();
        $("html, body").animate({
            scrollTop: 0
        }, 600);
    });

    $('#items-list .short-info').pxaFiltering({
        activeClassItem: 'filter-visible',
        effect: 'none',
        putActiveFilterClassOnParent: true,
        filters: [
            {
                selectorId: '#categories-filter .column-filter-1 input[type="checkbox"]',
                logicalOperator: 'OR',
                data: 'categories'
            },
            {
                selectorId: '#categories-filter .column-filter-2 input[type="checkbox"]',
                logicalOperator: 'OR',
                data: 'categories'
            }
        ]
    });
});
