// from https://bitbucket.org/pixelant/pxa_filtering_js/src/ae23857d728bb7734ea58d641126f996e0b13d4a/pxa_filtering.js?at=master&fileviewer=file-view-default

(function ($) {
    var pxaFilter = {
        filters: [],

        init: function (options, items) {
            var self = this;
            // get options
            self.options = $.extend({}, $.fn.pxaFiltering.options, options);

            if (self.options.filters.length && items.length) {
                self.items = items;
                self.initFilters(self.options.filters);
            } else {
                console.log('PxaFilters undefined');
            }
        },

        // init all filters here
        initFilters: function (filters) {
            var self = this;
            var selectors = '';

            for (var i = filters.length - 1; i >= 0; i--) {
                selectors += selectors.length === 0 ? filters[i].selectorId : ', ' + filters[i].selectorId;
                self.filters[i] = $(filters[i].selectorId);

                self.filters[i].on(self.options.triggerFilterOnEvent, function (e) {
                    e.preventDefault();
                    if (self.options.putActiveFilterClassOnParent) {
                        $(this).parent().toggleClass(self.options.activeClassFilterItem);
                    } else {
                        $(this).toggleClass(self.options.activeClassFilterItem);
                    }

                    self.doFiltering($(this));
                });
            }
        },

        doFiltering: function (fireElement) {
            var self = this;

            var visibleItems = self.items.filter(function () {
                var isVisible = false;

                if (self.areAnyFiltersActive()) {
                    for (var i = self.filters.length - 1; i >= 0; i--) {
                        var data = String($(this).data(self.options.filters[i].data));

                        var activeFilters = self.filters[i].filter(':checked');
                        //don't do filtering of no active filters
                        if (activeFilters.length > 0) {
                            isVisible = self.doFilteringByFilters(data, activeFilters, self.options.filters[i].logicalOperator);
                        }
                        else {
                            continue;
                        }

                        if (self.filters.length > 1) {
                            if (self.options.logicalOperatorFilters == 'OR' && isVisible) {
                                break;
                            } else if (self.options.logicalOperatorFilters == 'AND' && !isVisible) {
                                break;
                            }
                        }
                    }
                } else {
                    return true;
                }

                return isVisible;
            });

            self.changeVisibilityOfItems(visibleItems);
            self.triggerCall('onFilteringDone', fireElement);
        },

        doFilteringByFilters: function (valueOfItem, filters, logicalOperator) {
            var self = this,
                isVisible = false;

            $(filters).each(function () {
                if (self.isInList(valueOfItem, self.getFilterValue($(this)))) {
                    isVisible = true;
                    if (logicalOperator == 'OR') return false;

                } else if (logicalOperator == 'AND') {
                    isVisible = false;
                    return false;
                }
            });

            return isVisible;
        },

        changeVisibilityOfItems: function (visibleItems) {
            var self = this,
                hiddenItems = self.items.not(visibleItems);

            switch (self.options.effect) {
                case 'fade':
                    hiddenItems.fadeOut(self.options.animationSpeed);
                    visibleItems.fadeIn(self.options.animationSpeed);
                    break;
                case 'slide':
                    hiddenItems.slideUp(self.options.animationSpeed);
                    visibleItems.slideDown(self.options.animationSpeed);
                    break;
                default:
                    hiddenItems.hide();
                    visibleItems.show();
            }

            hiddenItems.removeClass(self.options.activeClassItem);
            visibleItems.addClass(self.options.activeClassItem);
        },

        getFilterValue: function (filterElement) {
            var self = this;

            if (self.options.useDataToGetFilterAttribute) {
                return filterElement.data(self.options.filterAttributeName);
            } else {
                return filterElement.attr(self.options.filterAttributeName);
            }
        },

        areAnyFiltersActive: function () {
            var self = this,
                count = 0;
            for (var i = self.filters.length - 1; i >= 0; i--) {
                count += self.filters[i].filter(':checked').length;
            }

            return count > 0;
        },

        isInList: function (haystack, needle) {
            return (',' + haystack + ',').indexOf(',' + needle + ',') !== -1;
        },

        triggerCall: function (eventName) {
            var self = this;

            if (typeof self.options[eventName] !== 'undefined' && $.isFunction(self.options[eventName])) {
                self.options[eventName](arguments[1], arguments[2], arguments[3], arguments[4], arguments[5]);
            }
        }
    };

    $.fn.pxaFiltering = function (options) {

        var pxaFilterObject = Object.create(pxaFilter);
        pxaFilterObject.init(options, this);

        return this;
    };

    $.fn.pxaFiltering.options = {
        effect: 'slide',
        activeClassFilterItem: 'active',
        putActiveFilterClassOnParent: false,
        activeClassItem: 'active',
        logicalOperatorFilters: 'AND',
        animationSpeed: 'fast',
        triggerFilterOnEvent: 'change',
        filterAttributeName: 'value',
        useDataToGetFilterAttribute: false,
        filters: []/*,
        onFilteringDone: function(filterElement)*/
    };

})(jQuery);