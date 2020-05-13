import $ from 'jquery';
import {
  $header,
  $backdrop,
  $searchModal,
  $win,
  $doc,
  $body,
} from '../global/selectors';
import { breakpoints } from '../global/ui';
import debounce from '../helpers/debounce';
import wasEnter from '../helpers/wasEnter';
import { toggleNewsletterSignup } from './newsletter-signup';

const headerHeight = () => $header.outerHeight();
const headerOffset = () => $header.find('.k-header--top').outerHeight();
const $nav = $header.find('.k-header--nav');
const $navTrigger = $('#k-nav-trigger');
const $dropdownTriggers = $('.k-has-dropdown a');
const $accessibleSkip = $('.k-header__skip-to-main');
// const $cartTrigger = $('#k-carttoggle');
const $cartTrigger = $('#k-carttoggle-wrapper');
const $cartParent = $('.k-header--cart');
const $logo = $header.find('.k-header--logo');
const $searchParent = $header.find('.k-searchparent');
const $searchIcon = $header.find('#k-searchicon');
const $main = $('main');

let didScroll = false;

function toggleNavDrawer() {
  const isActive = $header.hasClass('is-open');

  if ($body.hasClass('newsletter-signup')) {
    toggleNewsletterSignup();
  }

  if (isActive) {
    $header.removeClass('is-open');
  } else {
    $header.addClass('is-open');
  }
}

function doHeaderOffsets() {
  if (window.innerWidth < 767) {
    $nav.css({ top: headerHeight() });
  } else {
    $nav.removeAttr('style');
  }

  $header.css({ top: -headerOffset() });
}

(function handleScroll() {
  if (didScroll) {
    if (window.pageYOffset > headerOffset()) {
      $header.addClass('k-header--traveling');
    } else {
      $header.removeClass('k-header--traveling');
    }
    didScroll = false;
  }

  requestAnimationFrame(handleScroll);
})();

let interval;

$dropdownTriggers.click(function() {
  const $t = $(this);
  const $clickedDropdown = $t.next();
  const $content = $clickedDropdown.find('.k-dropdown--liner');
  const isOpen = $clickedDropdown.hasClass('k-dropdown--open');

  closeAllDropdowns();

  $clickedDropdown.addClass('k-dropdown--open');

  if (isOpen) {
    $clickedDropdown.height(0);
    $clickedDropdown.removeClass('k-dropdown--open');

    if (!$searchModal.hasClass('k-modal--open')) {
      $backdrop.removeClass('menu');
    }
  } else {
    $clickedDropdown.height($content.outerHeight());
    $clickedDropdown.addClass('k-dropdown--open');
    $backdrop.addClass('menu');
  }
});

export function closeAllDropdowns() {
  /**
   * Going forward, this function is resposible for resetting
   * the header back to the closed state.
   */
  $dropdownTriggers.each(function() {
    const $t = $(this);
    $t.next().height(0);
    $t.next().removeClass('k-dropdown--open');
  });

  if ($backdrop.hasClass('menu')) {
    $backdrop.removeClass('menu');
  }
}

function handleMobileNav() {
  if ($win.width() < breakpoints.md) {
    $cartTrigger.detach();
    $searchIcon.detach();
    $cartTrigger.insertAfter($logo);
    $searchIcon.insertAfter($cartTrigger);
  } else {
    $cartTrigger.detach();
    $cartParent.append($cartTrigger);
    $searchIcon.detach();
    $searchParent.append($searchIcon);
  }
}

$navTrigger.click(toggleNavDrawer);
window.addEventListener('resize', () => debounce(doHeaderOffsets, interval));
window.addEventListener('scroll', () => (didScroll = true));
document.addEventListener('DOMContentLoaded', doHeaderOffsets);

$doc.ready(handleMobileNav);
$win.resize(handleMobileNav);

$accessibleSkip.focusin(function() {
  $(this).addClass('k-header__skip-to-main--focused');
});

$accessibleSkip.blur(function() {
  $(this).removeClass('k-header__skip-to-main--focused');
});

$accessibleSkip.click(() => {
  $main.focus();
});

$accessibleSkip.keypress(function(e) {
  if (wasEnter(e)) {
    $main.focus();
  }
});
