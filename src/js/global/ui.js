import $ from 'jquery';

import {
  $doc,
  $win,
  $header,
  $cartSidebar,
  $searchModal,
  $backdrop,
  $reviewModal,
  //Imported
  $myDrop,
  $myNews,
  $myOpenCart,
  $myOpenSearch,
  $myOpenMenu,
  $myOpenNews,
  $body,
} from './selectors';

import { closeAllDropdowns } from '../components/site-header';
// import { closeSidebar } from './cart-actions';

const IS_SAFARI =
  /constructor/i.test(window.HTMLElement) ||
  (function(p) {
    return p.toString() === '[object SafariRemoteNotification]';
  })(
    !window['safari'] ||
      (typeof safari !== 'undefined' && safari.pushNotification)
  );

export const breakpoints = {
  sm: 580,
  md: 767,
  lg: 992,
  xl: 1199,
  xxl: 1440,
  max: 1800,
};

const $tiltTargets = $('.k-tilt');
const $blogFilterBy = $('.k-blognav--filterby select');
const $logoutTrigger = $('.k-customer-logout');

function slugify(string) {
  return string.replace(/ /g, '-').toLowerCase();
}

function initializeTilt() {
  if ($win.width() < breakpoints.md || !$tiltTargets.length || IS_SAFARI)
    return;

  const tiltProps = {
    maxTilt: 5,
    speed: 1200,
    easing: 'cubic-bezier(0.075,  0.820, 0.165, 1.000)',
  };

  $tiltTargets.tilt(tiltProps);
}

function goToCategoryListing() {
  const $t = $(this);
  const selectedCategory = $t.val();
  const slugified = slugify(selectedCategory);

  window.location.href = `${window.SITE_GLOBALS.root}/blog?category=${slugified}`;
}

function setInitialBlogCategory() {
  const selectedCategory = new URLSearchParams(window.location.search).get(
    'category'
  );
  const $optionEls = $blogFilterBy.find('option');
  const slugifiedOptions = [...$optionEls].map(({ value }) => slugify(value));

  slugifiedOptions.forEach((option, idx) => {
    if (option == selectedCategory) {
      $($optionEls[idx]).attr('selected', true);
    }
  });
}

$blogFilterBy.change(goToCategoryListing);

$doc.ready(function() {
  initializeTilt();
  setInitialBlogCategory();

  let $liveChat;
  let interval;

  // wait for the thing to actually get embedded first
  interval = setInterval(function() {
    $liveChat = $('#livechat-compact-container');

    if ($liveChat.length) {
      $liveChat.css({ 'z-index': 100 });
      clearInterval(interval);
    }
  }, 1000);

  // eliminate woocart garbage
  let counter = 0;
  const wooCart = setInterval(function() {
    const wooCartAppend = document.querySelector('.festi-cart-window-content');
    counter++;
    if (wooCartAppend) {
      wooCartAppend.remove();

      const styles = document.querySelector('#festi-cart-styles-css');
      const cartDropdowns = document.querySelector(
        '#festi-cart-cart-customize-style-css'
      );
      const dropdowns = document.querySelector(
        '#festi-cart-dropdown-list-customize-style-css'
      );
      const widgetStyles = document.querySelector(
        '#festi-cart-widget-customize-style-css'
      );
      const popup = document.querySelector(
        '#festi-cart-popup-customize-style-css'
      );
      const festiSpinner = document.querySelector(
        '#festi-jquery-ui-spinner-css'
      );
      const storage = document.querySelector('[src*="woocommerce-woocartpro"]');
      const inline = document.querySelector('.festi-cart-products');
      const festiSpinnerScript = document.querySelector(
        '[src*="jquery-ui.spinner"]'
      );

      const wooCartGarbage = [
        styles,
        cartDropdowns,
        dropdowns,
        widgetStyles,
        popup,
        festiSpinner,
        storage,
        inline,
        festiSpinnerScript,
      ];

      wooCartGarbage.forEach(trash => {
        trash.remove();
      });

      clearInterval(wooCart);
    } else if (counter >= 100) {
      clearInterval(wooCart);
    }
  }, 80);
});

export function backdropTriggerClose() {
  const headerDropdowns = $header.find('.k-dropdown');

  if ($backdrop.hasClass('menu')) {
    headerDropdowns.removeClass('k-dropdown--open');
    headerDropdowns.removeAttr('style');
    closeAllDropdowns();
  }

  if ($backdrop.hasClass('cart')) {
    $cartSidebar.removeClass('k-cart-sidebar--open');
    // closeSidebar();
  }

  if ($searchModal.hasClass('k-modal--open')) {
    $searchModal.removeClass('k-modal--open');
  }

  if ($reviewModal.hasClass('k-modal--open')) {
    $reviewModal.removeClass('k-modal--open');
  }

  if ($body.hasClass('cart-sidebar-open')) {
    $body.removeClass('cart-sidebar-open');
  }

  $backdrop.removeAttr('class');
}

$backdrop.click(function() {
  /**
   * Regardless of under what conditions the backdrop is clicked,
   * it should close once clicked.
   */
  backdropTriggerClose();
});

$logoutTrigger.click(function(e) {
  e.preventDefault();

  $.ajax({
    url: `${window.SITE_GLOBALS.root}/wp-admin/admin-ajax.php`,
    method: 'GET',
    data: { action: 'customer_logout' },
    complete: () => (window.location.href = `${window.SITE_GLOBALS.root}`),
  });
});

$myOpenCart.click(function() {
  // $myNews.removeClass('k-header__newsletter-signup--open');
  // $myNews.css('display', 'none');
  // $searchModal.removeClass('k-modal--open');
  // $backdrop.removeClass('active');
  // $myDrop.removeClass('k-dropdown--open');
  window.location.href = "/cart";
});

$myOpenSearch.click(function() {
  $myNews.removeClass('k-header__newsletter-signup--open');
  $myNews.css('display', 'none');
  $myDrop.removeClass('k-dropdown--open');
  $myDrop.css('height', 0);
});

$myOpenMenu.click(function() {
  $myNews.removeClass('k-header__newsletter-signup--open');
  $myNews.css('display', 'none');
  $searchModal.removeClass('k-modal--open');
  $cartSidebar.removeClass('k-cart-sidebar--open');
});

$myOpenNews.click(function() {
  $searchModal.removeClass('k-modal--open');
  $backdrop.removeClass('active');
  $cartSidebar.removeClass('k-cart-sidebar--open');
  $myDrop.removeClass('k-dropdown--open');
});
