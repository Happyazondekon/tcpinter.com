(function () {
  'use strict';

  var STORAGE_KEY = 'tcp_cookie_consent';

  function hideBanner(banner) {
    banner.classList.remove('is-visible');
    setTimeout(function () { banner.style.display = 'none'; }, 450);
  }

  document.addEventListener('DOMContentLoaded', function () {
    var banner = document.getElementById('tcp-cookie-banner');
    if (!banner) return;

    if (!localStorage.getItem(STORAGE_KEY)) {
      setTimeout(function () {
        banner.classList.add('is-visible');
      }, 800);
    }

    var btnAccept = document.getElementById('cookie-accept');
    var btnRefuse = document.getElementById('cookie-refuse');

    if (btnAccept) {
      btnAccept.addEventListener('click', function () {
        localStorage.setItem(STORAGE_KEY, 'accepted');
        hideBanner(banner);
      });
    }

    if (btnRefuse) {
      btnRefuse.addEventListener('click', function () {
        localStorage.setItem(STORAGE_KEY, 'refused');
        hideBanner(banner);
      });
    }
  });
})();