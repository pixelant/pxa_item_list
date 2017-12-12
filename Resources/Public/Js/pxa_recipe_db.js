var PxaRecepieDb = PxaRecepieDb || {};
var recipeLists = {};

PxaRecepieDb.event = {
    addListener: function(selector, type, fn) {
        $(selector).on(type, function() {
            fn($(this));
        });
    }
}

PxaRecepieDb.filter = {
    updateVisibleItems: function(selectedFilter) {

        event.preventDefault();

        PxaRecepieDb.filter.removeDetailView();

        var parent = $(selectedFilter).data('parent');
        var activeFilter = $(selectedFilter).data('filter');
        var filterClass = $('[data-usage="filter-container"][data-parent="' + parent + '"]').data('filter-class');
        var activeFilterClass = $('[data-usage="filter-container"][data-parent="' + parent + '"]').data('filter-class-active');

        // Remove "active" class on all fliters and add active on this
        $('[data-usage="recipe-filter"][data-parent="' + parent + '"]').each(function() {
            $(this).removeClass(activeFilterClass);
            // add default class if it is missing
            if(!$(this).hasClass(filterClass)) {
                $(this).addClass(filterClass);
            }
        });
        // Add "active" on seleced filter
        $(selectedFilter).addClass(activeFilterClass);

        // Loop thru all list items and set visibility
        $('[data-usage="recipe-list-item"][data-parent="' + parent + '"]').each(function() {
            if($(this).hasClass(activeFilter) || activeFilter === '*') {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    },
    loadDetail: function(item) {
        var lastItem = PxaRecepieDb.filter.getLastItemOnRow($(item));
        PxaRecepieDb.filter.addDetailView(item, lastItem);
    },
    getLastItemOnRow: function(item) {
        var nextVisibleItem = PxaRecepieDb.filter.getNextVisibleItem(item);
        if (nextVisibleItem.length > 0) {
            if (item.position().top !== nextVisibleItem.position().top) {
                return item;
            } else {
                return PxaRecepieDb.filter.getLastItemOnRow(nextVisibleItem);
            }
        } else {
            return item;
        }
    },
    getNextVisibleItem: function(item) {
        if (item.next().length > 0) {
            if (item.next().css('display') !== 'none') {
                return item.next();
            } else {
                return PxaRecepieDb.filter.getNextVisibleItem(item.next());
            }
        } else {
            return false;
        }
    },
    addDetailView: function(item, afterElement) {

        PxaRecepieDb.filter.removeDetailView();

        var template = $('#show-item-template').clone();
        template.attr("id", "detailView");
        template.find('[data-usage="template-category"]').html(item.data('category'));
        template.find('[data-usage="template-name"]').html(item.data('name'));
        template.find('[data-usage="template-description"]').html(item.data('description'));
        template.find('a[data-usage="template-pdf"]').attr('href', item.data('pdf-public-url'));

        var issuuConfigId = item.data('issuu-config-id');
        // Display image if no issuu?
        if (issuuConfigId.length > 0) {
            template.find('div[data-usage="template-embed"]').attr('data-configid', item.data('issuu-config-id'));
            template.find('div[data-usage="template-embed"]').removeClass('issuu-isrendered');
            template.find('div[data-usage="template-embed"]').addClass('issuuembed');
        } else {
            if (item.data('image-public-url')) {
                var img = '<img src="' + item.data('image-public-url') + '" class="img-responsive">';
                template.find('div[data-usage="template-embed"]').html(img);
            }

        }

        $(afterElement).after(template);
        PxaRecepieDb.event.addListener('[data-usage="close-detail-view"]', 'click', PxaRecepieDb.filter.removeDetailView);
        template.show();

        if (issuuConfigId.length > 0) {
            window.IssuuReaders.add();
        }
    },
    removeDetailView: function() {
        event.preventDefault();
        $('#detailView').remove();
    }
}

// Init 
jQuery(document).ready(function(){
    jQuery('[data-usage="recipe-list"]').each(function() {
        var identifier = $(this).data('identifier');
        recipeLists[identifier] = PxaRecepieDb.filter;
        PxaRecepieDb.event.addListener('[data-usage="recipe-filter"][data-parent="' + identifier + '"]', 'click', recipeLists[identifier].updateVisibleItems);
        PxaRecepieDb.event.addListener('[data-usage="recipe-list-item"][data-parent="' + identifier + '"]', 'click', recipeLists[identifier].loadDetail);
    });
});
