<?php
global $wp;

$root = get_template_directory_uri();
$current_url = home_url(add_query_arg(array(), $wp->request));
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php the_title(); ?></title>
  <link rel="apple-touch-icon" sizes="57x57" href="<?php echo $root . '/dist/apple-icon-57x57.png'; ?>">
  <link rel="apple-touch-icon" sizes="60x60" href="<?php echo $root . '/dist/apple-icon-60x60.png'; ?>">
  <link rel="apple-touch-icon" sizes="72x72" href="<?php echo $root . '/dist/apple-icon-72x72.png'; ?>">
  <link rel="apple-touch-icon" sizes="76x76" href="<?php echo $root . '/dist/apple-icon-76x76.png'; ?>">
  <link rel="apple-touch-icon" sizes="114x114" href="<?php echo $root . '/dist/apple-icon-114x114.png'; ?>">
  <link rel="apple-touch-icon" sizes="120x120" href="<?php echo $root . '/dist/apple-icon-120x120.png'; ?>">
  <link rel="apple-touch-icon" sizes="144x144" href="<?php echo $root . '/dist/apple-icon-144x144.png'; ?>">
  <link rel="apple-touch-icon" sizes="152x152" href="<?php echo $root . '/dist/apple-icon-152x152.png'; ?>">
  <link rel="apple-touch-icon" sizes="180x180" href="<?php echo $root . '/dist/apple-icon-180x180.png'; ?>">
  <link rel="icon" type="image/png" sizes="192x192"  href="<?php echo $root . '/dist/android-icon-192x192.png'; ?>">
  <link rel="icon" type="image/png" sizes="32x32" href="<?php echo $root . '/dist/favicon-32x32.png'; ?>">
  <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $root . '/dist/favicon-96x96.png'; ?>">
  <link rel="icon" type="image/png" sizes="16x16" href="<?php echo $root . '/dist/favicon-16x16.png'; ?>">
  <link rel="manifest" href="<?php echo $root . '/dist/manifest.json'; ?>">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="msapplication-TileImage" content="<?php echo $root . '/dist/ms-icon-144x144.png'; ?>">
  <meta name="theme-color" content="#ffffff">

  <?php wp_head(); ?>

  <script>
    // IntersectionObserver polyfill
    !function(){"use strict";if("object"==typeof window)if("IntersectionObserver"in window&&"IntersectionObserverEntry"in window&&"intersectionRatio"in window.IntersectionObserverEntry.prototype)"isIntersecting"in window.IntersectionObserverEntry.prototype||Object.defineProperty(window.IntersectionObserverEntry.prototype,"isIntersecting",{get:function(){return this.intersectionRatio>0}});else{var t=window.document,e=[];o.prototype.THROTTLE_TIMEOUT=100,o.prototype.POLL_INTERVAL=null,o.prototype.USE_MUTATION_OBSERVER=!0,o.prototype.observe=function(t){if(!this._observationTargets.some(function(e){return e.element==t})){if(!t||1!=t.nodeType)throw new Error("target must be an Element");this._registerInstance(),this._observationTargets.push({element:t,entry:null}),this._monitorIntersections(),this._checkForIntersections()}},o.prototype.unobserve=function(t){this._observationTargets=this._observationTargets.filter(function(e){return e.element!=t}),this._observationTargets.length||(this._unmonitorIntersections(),this._unregisterInstance())},o.prototype.disconnect=function(){this._observationTargets=[],this._unmonitorIntersections(),this._unregisterInstance()},o.prototype.takeRecords=function(){var t=this._queuedEntries.slice();return this._queuedEntries=[],t},o.prototype._initThresholds=function(t){var e=t||[0];return Array.isArray(e)||(e=[e]),e.sort().filter(function(t,e,n){if("number"!=typeof t||isNaN(t)||t<0||t>1)throw new Error("threshold must be a number between 0 and 1 inclusively");return t!==n[e-1]})},o.prototype._parseRootMargin=function(t){var e=(t||"0px").split(/\s+/).map(function(t){var e=/^(-?\d*\.?\d+)(px|%)$/.exec(t);if(!e)throw new Error("rootMargin must be specified in pixels or percent");return{value:parseFloat(e[1]),unit:e[2]}});return e[1]=e[1]||e[0],e[2]=e[2]||e[0],e[3]=e[3]||e[1],e},o.prototype._monitorIntersections=function(){this._monitoringIntersections||(this._monitoringIntersections=!0,this.POLL_INTERVAL?this._monitoringInterval=setInterval(this._checkForIntersections,this.POLL_INTERVAL):(i(window,"resize",this._checkForIntersections,!0),i(t,"scroll",this._checkForIntersections,!0),this.USE_MUTATION_OBSERVER&&"MutationObserver"in window&&(this._domObserver=new MutationObserver(this._checkForIntersections),this._domObserver.observe(t,{attributes:!0,childList:!0,characterData:!0,subtree:!0}))))},o.prototype._unmonitorIntersections=function(){this._monitoringIntersections&&(this._monitoringIntersections=!1,clearInterval(this._monitoringInterval),this._monitoringInterval=null,r(window,"resize",this._checkForIntersections,!0),r(t,"scroll",this._checkForIntersections,!0),this._domObserver&&(this._domObserver.disconnect(),this._domObserver=null))},o.prototype._checkForIntersections=function(){var t=this._rootIsInDom(),e=t?this._getRootRect():{top:0,bottom:0,left:0,right:0,width:0,height:0};this._observationTargets.forEach(function(o){var i=o.element,r=s(i),h=this._rootContainsTarget(i),c=o.entry,a=t&&h&&this._computeTargetAndRootIntersection(i,e),u=o.entry=new n({time:window.performance&&performance.now&&performance.now(),target:i,boundingClientRect:r,rootBounds:e,intersectionRect:a});c?t&&h?this._hasCrossedThreshold(c,u)&&this._queuedEntries.push(u):c&&c.isIntersecting&&this._queuedEntries.push(u):this._queuedEntries.push(u)},this),this._queuedEntries.length&&this._callback(this.takeRecords(),this)},o.prototype._computeTargetAndRootIntersection=function(e,n){if("none"!=window.getComputedStyle(e).display){for(var o,i,r,h,a,u,d,l,p=s(e),f=c(e),g=!1;!g;){var _=null,v=1==f.nodeType?window.getComputedStyle(f):{};if("none"==v.display)return;if(f==this.root||f==t?(g=!0,_=n):f!=t.body&&f!=t.documentElement&&"visible"!=v.overflow&&(_=s(f)),_&&(o=_,i=p,r=void 0,h=void 0,a=void 0,u=void 0,d=void 0,l=void 0,r=Math.max(o.top,i.top),h=Math.min(o.bottom,i.bottom),a=Math.max(o.left,i.left),u=Math.min(o.right,i.right),l=h-r,!(p=(d=u-a)>=0&&l>=0&&{top:r,bottom:h,left:a,right:u,width:d,height:l})))break;f=c(f)}return p}},o.prototype._getRootRect=function(){var e;if(this.root)e=s(this.root);else{var n=t.documentElement,o=t.body;e={top:0,left:0,right:n.clientWidth||o.clientWidth,width:n.clientWidth||o.clientWidth,bottom:n.clientHeight||o.clientHeight,height:n.clientHeight||o.clientHeight}}return this._expandRectByRootMargin(e)},o.prototype._expandRectByRootMargin=function(t){var e=this._rootMarginValues.map(function(e,n){return"px"==e.unit?e.value:e.value*(n%2?t.width:t.height)/100}),n={top:t.top-e[0],right:t.right+e[1],bottom:t.bottom+e[2],left:t.left-e[3]};return n.width=n.right-n.left,n.height=n.bottom-n.top,n},o.prototype._hasCrossedThreshold=function(t,e){var n=t&&t.isIntersecting?t.intersectionRatio||0:-1,o=e.isIntersecting?e.intersectionRatio||0:-1;if(n!==o)for(var i=0;i<this.thresholds.length;i++){var r=this.thresholds[i];if(r==n||r==o||r<n!=r<o)return!0}},o.prototype._rootIsInDom=function(){return!this.root||h(t,this.root)},o.prototype._rootContainsTarget=function(e){return h(this.root||t,e)},o.prototype._registerInstance=function(){e.indexOf(this)<0&&e.push(this)},o.prototype._unregisterInstance=function(){var t=e.indexOf(this);-1!=t&&e.splice(t,1)},window.IntersectionObserver=o,window.IntersectionObserverEntry=n}function n(t){this.time=t.time,this.target=t.target,this.rootBounds=t.rootBounds,this.boundingClientRect=t.boundingClientRect,this.intersectionRect=t.intersectionRect||{top:0,bottom:0,left:0,right:0,width:0,height:0},this.isIntersecting=!!t.intersectionRect;var e=this.boundingClientRect,n=e.width*e.height,o=this.intersectionRect,i=o.width*o.height;this.intersectionRatio=n?Number((i/n).toFixed(4)):this.isIntersecting?1:0}function o(t,e){var n,o,i,r=e||{};if("function"!=typeof t)throw new Error("callback must be a function");if(r.root&&1!=r.root.nodeType)throw new Error("root must be an Element");this._checkForIntersections=(n=this._checkForIntersections.bind(this),o=this.THROTTLE_TIMEOUT,i=null,function(){i||(i=setTimeout(function(){n(),i=null},o))}),this._callback=t,this._observationTargets=[],this._queuedEntries=[],this._rootMarginValues=this._parseRootMargin(r.rootMargin),this.thresholds=this._initThresholds(r.threshold),this.root=r.root||null,this.rootMargin=this._rootMarginValues.map(function(t){return t.value+t.unit}).join(" ")}function i(t,e,n,o){"function"==typeof t.addEventListener?t.addEventListener(e,n,o||!1):"function"==typeof t.attachEvent&&t.attachEvent("on"+e,n)}function r(t,e,n,o){"function"==typeof t.removeEventListener?t.removeEventListener(e,n,o||!1):"function"==typeof t.detatchEvent&&t.detatchEvent("on"+e,n)}function s(t){var e;try{e=t.getBoundingClientRect()}catch(t){}return e?(e.width&&e.height||(e={top:e.top,right:e.right,bottom:e.bottom,left:e.left,width:e.right-e.left,height:e.bottom-e.top}),e):{top:0,bottom:0,left:0,right:0,width:0,height:0}}function h(t,e){for(var n=e;n;){if(n==t)return!0;n=c(n)}return!1}function c(t){var e=t.parentNode;return e&&11==e.nodeType&&e.host?e.host:e&&e.assignedSlot?e.assignedSlot.parentNode:e}}();
  </script>
  <script>
    // NodeList.forEach() polyfill
    "NodeList"in window&&!NodeList.prototype.forEach&&(NodeList.prototype.forEach=function(o,t){t=t||window;for(var i=0;i<this.length;i++)o.call(t,this[i],i,this)});
  </script>
  <script>
    // URLSearchParams polyfill
    !function(t){"use strict";var n,r=t.URLSearchParams&&t.URLSearchParams.prototype.get?t.URLSearchParams:null,e=r&&"a=1"===new r({a:1}).toString(),o=r&&"+"===new r("s=%2B").get("s"),i="__URLSearchParams__",a=!r||((n=new r).append("s"," &"),"s=+%26"===n.toString()),c=l.prototype,s=!(!t.Symbol||!t.Symbol.iterator);if(!(r&&e&&o&&a)){c.append=function(t,n){y(this[i],t,n)},c.delete=function(t){delete this[i][t]},c.get=function(t){var n=this[i];return t in n?n[t][0]:null},c.getAll=function(t){var n=this[i];return t in n?n[t].slice(0):[]},c.has=function(t){return t in this[i]},c.set=function(t,n){this[i][t]=[""+n]},c.toString=function(){var t,n,r,e,o=this[i],a=[];for(n in o)for(r=h(n),t=0,e=o[n];t<e.length;t++)a.push(r+"="+h(e[t]));return a.join("&")};var u=!!o&&r&&!e&&t.Proxy;Object.defineProperty(t,"URLSearchParams",{value:u?new Proxy(r,{construct:function(t,n){return new t(new l(n[0]).toString())}}):l});var f=t.URLSearchParams.prototype;f.polyfill=!0,f.forEach=f.forEach||function(t,n){var r=v(this.toString());Object.getOwnPropertyNames(r).forEach(function(e){r[e].forEach(function(r){t.call(n,r,e,this)},this)},this)},f.sort=f.sort||function(){var t,n,r,e=v(this.toString()),o=[];for(t in e)o.push(t);for(o.sort(),n=0;n<o.length;n++)this.delete(o[n]);for(n=0;n<o.length;n++){var i=o[n],a=e[i];for(r=0;r<a.length;r++)this.append(i,a[r])}},f.keys=f.keys||function(){var t=[];return this.forEach(function(n,r){t.push(r)}),g(t)},f.values=f.values||function(){var t=[];return this.forEach(function(n){t.push(n)}),g(t)},f.entries=f.entries||function(){var t=[];return this.forEach(function(n,r){t.push([r,n])}),g(t)},s&&(f[t.Symbol.iterator]=f[t.Symbol.iterator]||f.entries)}function l(t){((t=t||"")instanceof URLSearchParams||t instanceof l)&&(t=t.toString()),this[i]=v(t)}function h(t){var n={"!":"%21","'":"%27","(":"%28",")":"%29","~":"%7E","%20":"+","%00":"\0"};return encodeURIComponent(t).replace(/[!'\(\)~]|%20|%00/g,function(t){return n[t]})}function p(t){return t.replace(/[ +]/g,"%20").replace(/(%[a-f0-9]{2})+/gi,function(t){return decodeURIComponent(t)})}function g(n){var r={next:function(){var t=n.shift();return{done:void 0===t,value:t}}};return s&&(r[t.Symbol.iterator]=function(){return r}),r}function v(t){var n={};if("object"==typeof t)if(S(t))for(var r=0;r<t.length;r++){var e=t[r];if(!S(e)||2!==e.length)throw new TypeError("Failed to construct 'URLSearchParams': Sequence initializer must only contain pair elements");y(n,e[0],e[1])}else for(var o in t)t.hasOwnProperty(o)&&y(n,o,t[o]);else{0===t.indexOf("?")&&(t=t.slice(1));for(var i=t.split("&"),a=0;a<i.length;a++){var c=i[a],s=c.indexOf("=");-1<s?y(n,p(c.slice(0,s)),p(c.slice(s+1))):c&&y(n,p(c),"")}}return n}function y(t,n,r){var e="string"==typeof r?r:null!=r&&"function"==typeof r.toString?r.toString():JSON.stringify(r);n in t?t[n].push(e):t[n]=[e]}function S(t){return!!t&&"[object Array]"===Object.prototype.toString.call(t)}}("undefined"!=typeof global?global:"undefined"!=typeof window?window:this);
  </script>
  <script>
    var SITE_GLOBALS = {
      root: '<?php echo site_url(); ?>',
    };
  </script>
  <!-- Remember to add the live chat script here!! -->
  <!--
    <script type="text/javascript" async src="https://cdn.livechatinc.com/tracking.js"></script>
  -->

  <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Overlock:400,700&display=swap" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css" />
  <link rel="stylesheet" href="https://cdn.plyr.io/3.5.6/plyr.css" />

  <link rel="stylesheet" href="<?php echo $root.'/dist/css/main.css?v=1.12.4' ?>" />
<style type="text/css">
.hero-media-img-top{margin-top:165px;}
.sticky_banner{margin-top:110px;}

.k-login__form{position:relative !important;}
.k-login__form h2{margin:10px 0px;}
.k-liner{width:100% !important; max-width:1200px !important; display:flex; flex-wrap:wrap; overflow:hidden;}
.k-login__form--default{width:46% !important; margin:2%; }
.k-login__form--register{width:46% !important; margin:2%;}
.k-login__form button[type="submit"]{margin:10px 0px 0px 0px !important;}
.k-login__rememberme{margin:0px !important;}
.woocommerce form.register, .woocommerce-form-login{margin:0.5em 0 !important;}

.hubwoo_checkout_marketing_optin{padding:0px !important;}
#hubwoo_checkout_marketing_optin{display:inline !important; opacity:1 !important; position:relative !important; z-index:999; 
appearance:checkbox !important;
-webkit-appearance:checkbox !important;
-moz-appearance:checkbox !important; min-width:0px !important; margin-top:-7px; margin-right:5px;}

#hubwoo_registeration_marketing_optin{display:inline !important; opacity:1 !important; position:relative !important; z-index:999; 
appearance:checkbox !important;
-webkit-appearance:checkbox !important;
-moz-appearance:checkbox !important; min-width:0px !important; margin-top:-7px; margin-right:5px;}


@media only screen and (max-width:1260px){
.k-header--nav a{font-size: 15px !important;}
.k-header--nav li{margin-right: 8px !important;}
.k-header--nav{width:98% !important;left:1% !important;}
}
@media only screen and (max-width:1200px){
.select_options_area, .select_options_text{width:100%; float:none;}
.select_options_text{font-size:15px !important;}
}
@media only screen and (max-width:992px){
.hero-media-img-top{margin-top:135px;}
.sticky_banner{margin-top:85px;}
.k-header--nav a{font-size: 13px !important;}
.k-header--nav li{margin-right: 5px !important;}
}
@media only screen and (max-width:840px){
.k-header--nav a{letter-spacing:-0.8px;}
}
@media only screen and (max-width:767px){
.k-header--nav a{font-size: 18px !important; letter-spacing:0px;}
.hero-media-img-top{margin-top:18%;}
.hero-media-img-top img{width:1000px !important; margin-left:-10%;}
.sticky_banner{margin-top:8%;}
.k-header.is-open{position:absolute !important;}
#k-backdrop{position:relative !important;}
.k-login__form--default{width:96% !important; margin:2%; }
.k-login__form--register{width:96% !important; margin:2%;}
}
@media only screen and (max-width:480px){
.hero-media-img-top{margin-top:30%;}
.sticky_banner{margin-top:15%;}
}
</style>
<script>
var $ = jQuery.noConflict();
$(document).ready(function(){
    $("#k-nav-trigger").click(function() {
        $("html, body").animate({ scrollTop: 0 }, "fast");
        return false;
    });
});
</script>
</head>
<body <?php body_class(); ?>>
  <script>
    (function() {
      var isIE11 = !!window.MSInputMethodContext && !!document.documentMode;

      if (isIE11) {
        console.log('document.body', document.body);
        document.body.classList.add('is-ie11');
      }
    })();
  </script>
  <?php get_template_part('partials/site-header'); ?>
  <main role="main" id="k-main" tabindex="0" class="mag-override-woo">