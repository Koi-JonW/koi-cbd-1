import $ from 'jquery';
import { $win, $body } from '../global/selectors';
import { closeAllDropdowns } from '../components/site-header';

const $trigger = $('.k-header__newsletter-trigger');
const $signup = $('.k-header__newsletter-signup');
const $submit = $('.k-header__newsletter-submit');
const $form = $('.k-header__newsletter-signup form');
const openClass = 'k-header__newsletter-signup--open';
let scrollYPos = 0;

export function debounce(func, wait, immediate) {
  let timeout;
  return function() {
    let context = this,
      args = arguments;
    let later = function() {
      timeout = null;
      if (!immediate) func.apply(context, args);
    };
    let callNow = immediate && !timeout;
    clearTimeout(timeout);
    timeout = setTimeout(later, wait);
    if (callNow) func.apply(context, args);
  };
}

export function toggleNewsletterSignup(event) {
  if (event) {
    event.stopPropagation();
  }

  closeAllDropdowns();

  $body.toggleClass('newsletter-signup');

  scrollYPos = window.pageYOffset;

  $signup.slideToggle({
    duration: 225,
    complete: () => {
      $signup.toggleClass(openClass);
    },
  });
}

$trigger.click(toggleNewsletterSignup);

$win.scroll(debounce(checkSignup, 10));

$form.submit(e => {
  const headerFields = {
    firstName: document.querySelector('#k-newsletter-first'),
    lastName: document.querySelector('#k-newsletter-last'),
    email: document.querySelector('#k-newsletter-email'),
    button: $submit[0],
  };

  submitForm(e, headerFields, true);
});

function checkSignup() {
  const currentYPos = window.pageYOffset;
  const difference = Math.abs(scrollYPos - currentYPos);
  if ($signup.hasClass(openClass) && difference > window.innerHeight) {
    $signup.slideUp();
    $signup.removeClass(openClass);
  } else {
    return;
  }
}

export function submitForm(e, fieldSelectors, fromHeader = false) {
  e.preventDefault();
  if (typeof fieldSelectors != 'object') {
    console.warn('fieldSelectors was not an object.');
    console.error(Error(error));
    return;
  }

  let formSubmit = false;
  fieldSelectors.button.innerHTML = 'Submitting...';

  const formEndpoint =
    'https://api.hsforms.com/submissions/v3/integration/submit/6283239/eae9de54-3f3d-46f7-a523-5e504254f49f';

  const payload = {
    fields: [
      {
        name: 'email',
        value: fieldSelectors.email.value,
      },
      {
        name: 'firstname',
        value: fieldSelectors.firstName.value,
      },
      {
        name: 'lastname',
        value: fieldSelectors.lastName.value,
      },
    ],
    submittedAt: Date.now(),
  };

  const xhr = new XMLHttpRequest();
  xhr.open('POST', formEndpoint, true);
  xhr.setRequestHeader('content-type', 'application/json');
  xhr.send(JSON.stringify(payload));
  xhr.onreadystatechange = () => {
    if (xhr.readyState == 4 && xhr.status >= 200 && xhr.status < 300) {
      formSubmit = true;
    }
  };

  const wait = setInterval(() => {
    if (formSubmit === true) {
      const { button } = fieldSelectors;

      button.style.background = 'transparent';
      button.innerHTML = 'Complete!';

      if (fromHeader) {
        setTimeout(() => {
          $signup.slideUp();
        }, 3000);
      }

      clearInterval(wait);
    }
  }, 2500);
}
