/**
 * HeyHappy Promo Popup
 * Appears once every 7 days, 40s after page load.
 * Agency: HeyHappy — heyhappyproject@gmail.com | +229 01 68 62 87 40
 */
(function () {
  'use strict';

  var STORAGE_KEY = 'hhp_last_shown';
  var DELAY_MS    = 120000;  // 120 seconds after load
  var INTERVAL_MS = 7 * 24 * 60 * 60 * 1000; // 7 days

  function shouldShow() {
    var last = localStorage.getItem(STORAGE_KEY);
    if (!last) return true;
    return (Date.now() - parseInt(last, 10)) > INTERVAL_MS;
  }

  function showPopup() {
    var popup = document.getElementById('heyhappy-popup');
    if (!popup) return;
    popup.classList.add('visible');
    localStorage.setItem(STORAGE_KEY, Date.now().toString());
  }

  function closePopup() {
    var popup = document.getElementById('heyhappy-popup');
    if (popup) popup.classList.remove('visible');
  }

  document.addEventListener('DOMContentLoaded', function () {
    var closeBtn = document.getElementById('hhp-close');
    if (closeBtn) closeBtn.addEventListener('click', closePopup);

    if (!shouldShow()) return;
    setTimeout(showPopup, DELAY_MS);
  });
})();
