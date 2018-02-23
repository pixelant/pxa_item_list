
const filterModule = (function () {

  /** Return array of all categories of filtered item
    * 
    * @param $elem - filtered item (DOM element)
    */

  var _getCategories = function ($elem) {
    return $elem.attr('data-categories') ? $elem.attr('data-categories').split(',') : []
  }

  /**
    * @param $elem - filtered item (DOM element)
    * @param categorys - array of categories selected by user
    */

  var _matchCategory = function ($elem, categorys) {
    for (var i = 0; i < categorys.length; i++) {
      for (var n = 0; n < _getCategories($elem).length; n++) {
        if (_getCategories($elem)[n] == categorys[i]) {
          return true
        }
      }
    }
  }

 /** 
  * Set class with sequence number for each visible item
  * (necessary for styling)
  */

  var _orderItem = function () {
    var count = 1;
    $('._item-visible').each(function (i) {
      $(this).removeClass('_item-1 _item-2 _item-3').addClass('_item-' + count);
      count ++
      if (count == 4) {
        count = 1
      }
    })
  }

  return { 

    /** 
    * Sets class for items which category are the same, 
    * as user have selected
    *
    * @param categorys - array of categories selected by user
    */

    itemsFilter: function (categorys) {
      $('.js__filtering-list__item').each(function (i) {
        $(this).addClass('_item-visible')
        if (categorys.length && !_matchCategory($(this), categorys)) {
          $(this).removeClass('_item-visible')
        }
      })
      _orderItem()
    }
  }

}());

/**
 *  Load event
 */

$(window).on('load', function () {
  var $input = $('.js__filter-checkbox__input'),
      $item = $('.js__filtering-list__item'),
      $target = $('.js__filtering-list__item-target'),
      $close = $('.js__close-preview')

  filterModule.itemsFilter([])

  /**
  *  Change event, runs filtering method
  */

  $input.on('change', function () {
    var selected = []
    $input.each(function () {
      if(this.checked) {
        selected.push($(this).val())
      }
    })
    filterModule.itemsFilter(selected)
  })

  /**
  *  Click event, show/hide preview item
  */

  $target.on('click', function () {
    $(this).parent().toggleClass('_item-open').siblings().removeClass('_item-open');

    /**
    *  Initilize swiper after item opened
    */
    var $sl = new Swiper($(this).parent().find('.js__item-description__scroll-helper'), {
      direction: 'vertical',
      slidesPerView: 'auto',
      freeMode: true,
      nextButton: $(this).parent().find('.arrow-down'),
      prevButton: $(this).parent().find('.arrow-up')
    })
  })

  /**
  *  Click event, hide preview item
  */

  $close.on('click', function () {
    $(this).closest($item).removeClass('_item-open');
  })
})


