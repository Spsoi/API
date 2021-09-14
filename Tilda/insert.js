console.log('Загрузка basketFormSubmitting');
window.onload = function () {
  const cart = document.querySelector('.t706__cartwin-content');
  const form = cart.querySelector('form')
  let yandexMetrikaUserId = getCookie('_ym_uid')

  function sendForm(url) {
    if (!cart || !form) {
      return false;
    }

    let productsElements = cart.querySelectorAll('.t706__product')
    if (productsElements.length == 0) {
      return false;
    }
    console.log(cart);
    let amount = 0
    let products = []
    let productName = ''
    let productAmount = 0

    for (let item of productsElements) {
      productName = item.querySelector('.t706__product-title a').text
      productAmount = parseInt(
        item.querySelector('.t706__product-amount')
          .textContent.replace(/[^\d]/g, '')
      )
      amount += productAmount
      products.push(productName + '=' + productAmount)
    }

    let paymentObj = {
      products: products,
      amount: amount
    }
    let formInputs = form.querySelectorAll('.t-form__inputsbox input')
    let formInputsArr = []
    for (let input of formInputs) {
      switch (input.type) {
        case 'radio':
          if (input.checked) {
            formInputsArr.push([input.type, input.name, input.value, input.checked])
          }
          break
        case 'checkbox':
          if (input.checked) {
            formInputsArr.push([input.type, input.name, 'yes', input.checked])
          }
          break
        default:
          formInputsArr.push([input.type, input.name, input.value, input.checked])
      }
    }
    let data = new Map([
      ['formsubmit', 1],
      ['formid', form.id],
      ['formname', form.name],
      ['payment', JSON.stringify(paymentObj)]
    ])
    for (let line of formInputsArr) {
      data.set(line[1], line[2])
    }

    let formData = new FormData()
    for (let pair of data.entries()) {
      formData.append(pair[0], pair[1]);
    }

    let utmString = getCookie('TILDAUTM')
    if (typeof utmString != 'undefined') {
      let pairs = utmString.split('|||')
      let keyval = []
      for (let i in pairs) {
        keyval = pairs[i].split('=')
        keyval[0] = keyval[0].toLowerCase()
        if (keyval[0].indexOf('utm') != -1) {
          formData.append(keyval[0], keyval[1]);
        }
      }
    }
    if (typeof yandexMetrikaUserId != 'undefined') {
        formData.append('_ym_uid', yandexMetrikaUserId);
    }
    fetch(url, { method: 'POST', body: formData })
  }
  

  function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
      "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ))
    return matches ? decodeURIComponent(matches[1]) : undefined
  }

  window[form.dataset.formsendedCallback] = function () {
    if (form.querySelector('input[name=facebook_pixel_course_name]') !== null) {
      let courseName = form.querySelector('input[name=facebook_pixel_course_name]').value
      let amount = parseInt(
          cart.querySelector('.t706__cartwin-prodamount').textContent.replace(/[^\d]/g, '')
        )
      fbq('trackCustom', courseName, { currency: "RUB", value: amount });
    }
    sendForm('https://jacques-web.ru/tilda-courses-buy-forms-hook')
    $(".t706__cartwin-products").slideUp(10, function(){});
    $(".t706__cartwin-bottom").slideUp(10, function(){});
    $(".t706 .t-form__inputsbox").slideUp(700,function(){});
    try{tcart__unlockScroll()}catch(e){}

  }

  if (typeof yandexMetrikaUserId != 'undefined') {
    let input = null

    let consultationForms = document.querySelectorAll('form[data-success-callback=t702_onSuccess]')
    for (let consForm of consultationForms) {
        input = document.createElement('input');
        input.type = 'hidden'
        input.name = '_ym_uid'
        input.value = yandexMetrikaUserId
        consForm.append(input)
    }
  }

}
