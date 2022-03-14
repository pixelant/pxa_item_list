window.addEventListener('load', (event) => {
  let input = document.querySelectorAll('.js__filter-checkbox__input'),
    item = document.querySelectorAll('.js__filtering-list__item'),
    target = document.querySelectorAll('.js__filtering-list__item-target'),
    preview = document.querySelectorAll('.js__filtering-list__item-preview'),
    close = document.querySelectorAll('.js__close-preview'),
    selected = []

  input.forEach(element => {
    element.addEventListener('change', function () {
      toggleFilters()
      toggleItems()
    })
  })

  target.forEach(element => {
    element.addEventListener('click', function (e) {
      toggleTarget(element)
    })
  })

  close.forEach(element => {
    element.addEventListener('click', function (e) {
      element.closest(item.forEach(element => {
        element.classList.remove('_item-open')
      }))
      element.closest(preview.forEach(element => {
        element.classList.add('hidden')
      }))
    })
  })

  orderItem()

  function orderItem() {
    var count = 1;
    var itemVisible = document.getElementsByClassName('_item-visible')
    Object.keys(itemVisible).forEach(element => {
      itemVisible[element].classList.remove('_item-1', '_item-2', '_item-3'),
      itemVisible[element].classList.add('_item-' + count)
      count++
      if (count == 4) {
        count = 1
      }
    })
  }

  function toggleFilters(e) {
    selected = []
    input.forEach(element => {
      if (element.checked) {
        selected.push(element.value)
      }
    })
  }

  function toggleItems(e) {
    item.forEach( element => {
      if (selected.length == 0) {
        element.classList.add('_item-visible')
      } else {
        const itemCategories = element.dataset['categories'].split(',')

        const filteredArray = itemCategories.filter(value => selected.includes(value));

        const found = filteredArray.some(r => selected.indexOf(r) >= 0)

        if(found) {
          element.classList.add('_item-visible')
        } else {
          element.classList.remove('_item-visible')
        }
      }
    })
    orderItem()
  }

  function toggleTarget(item) {
    const targetId = item.dataset['targetId']
    const previewItem = document.getElementById(targetId)
    const isHidden = previewItem.classList.contains('hidden')

    preview.forEach(element => {
      if(element.id !== targetId) {
        element.classList.add('hidden')
        element.parentElement.classList.remove('_item-open')
      }
    });

    if (isHidden) {
      previewItem.classList.remove('hidden')
      item.parentElement.classList.add('_item-open')
      previewItem.scrollIntoView();
    } else {
      previewItem.classList.add('hidden')
      item.parentElement.classList.remove('_item-open')
    }
  }
})
