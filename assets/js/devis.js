/* ============================================================
   TCP Inter – Devis Form JS
   Validation, file upload preview, AJAX submit
   ============================================================ */

(function () {
  'use strict';

  const form    = document.getElementById('devis-form');
  if (!form) return;

  const msgBox  = document.getElementById('form-message');
  const fileInput = document.getElementById('file-media');
  const fileLabel = document.getElementById('file-label-text');

  /* ---------- File upload preview ---------- */
  if (fileInput && fileLabel) {
    fileInput.addEventListener('change', () => {
      const files = Array.from(fileInput.files);
      if (files.length === 0) {
        fileLabel.textContent = 'Glissez et déposez (ou) Choisissez des fichiers';
        return;
      }
      const names = files.map(f => f.name).join(', ');
      fileLabel.textContent = files.length === 1
        ? names
        : `${files.length} fichiers sélectionnés`;
    });

    // Drag and drop
    const dropZone = document.getElementById('file-drop-zone');
    if (dropZone) {
      ['dragenter', 'dragover'].forEach(evt => {
        dropZone.addEventListener(evt, (e) => {
          e.preventDefault();
          dropZone.style.borderColor = 'var(--color-secondary)';
          dropZone.style.background  = 'var(--color-surface-container)';
        });
      });

      ['dragleave', 'drop'].forEach(evt => {
        dropZone.addEventListener(evt, (e) => {
          e.preventDefault();
          dropZone.style.borderColor = '';
          dropZone.style.background  = '';
        });
      });

      dropZone.addEventListener('drop', (e) => {
        fileInput.files = e.dataTransfer.files;
        fileInput.dispatchEvent(new Event('change'));
      });
    }
  }

  /* ---------- Phone formatting ---------- */
  const phoneInput = document.getElementById('phone');
  if (phoneInput) {
    phoneInput.addEventListener('input', () => {
      let val = phoneInput.value.replace(/\D/g, '');
      if (val.length > 10) val = val.slice(0, 10);
      // Format: 06 12 34 56 78
      const parts = val.match(/.{1,2}/g) || [];
      phoneInput.value = parts.join(' ');
    });
  }

  /* ---------- Form validation ---------- */
  const required = form.querySelectorAll('[required]');

  const showError = (input, msg) => {
    input.style.borderColor = 'var(--color-error)';
    let err = input.parentElement.querySelector('.field-error');
    if (!err) {
      err = document.createElement('span');
      err.className = 'field-error';
      err.style.cssText = 'font-size:0.8rem;color:var(--color-error);margin-top:0.25rem;display:block;';
      input.parentElement.appendChild(err);
    }
    err.textContent = msg;
  };

  const clearError = (input) => {
    input.style.borderColor = '';
    const err = input.parentElement.querySelector('.field-error');
    if (err) err.remove();
  };

  required.forEach(input => {
    input.addEventListener('input', () => clearError(input));
  });

  const validate = () => {
    let valid = true;
    required.forEach(input => {
      clearError(input);
      if (!input.value.trim()) {
        showError(input, 'Ce champ est obligatoire.');
        valid = false;
      } else if (input.type === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value)) {
        showError(input, 'Adresse e-mail invalide.');
        valid = false;
      }
    });
    return valid;
  };

  /* ---------- AJAX submit ---------- */
  form.addEventListener('submit', (e) => {
    e.preventDefault();

    if (!validate()) return;

    const submitBtn = form.querySelector('[type="submit"]');
    const origText  = submitBtn.textContent;

    submitBtn.disabled  = true;
    submitBtn.innerHTML = '<svg style="width:1.2em;height:1.2em;animation:spin 0.8s linear infinite;fill:none;stroke:currentColor;stroke-width:3;margin-right:0.5em;" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10" opacity=".25"/><path d="M12 2a10 10 0 0 1 10 10" stroke-linecap="round"/></svg>Envoi en cours…';

    // Add spin animation
    if (!document.getElementById('tcp-spin-style')) {
      const style = document.createElement('style');
      style.id = 'tcp-spin-style';
      style.textContent = '@keyframes spin{to{transform:rotate(360deg)}}';
      document.head.appendChild(style);
    }

    const data = new FormData(form);
    data.append('action', 'tcp_devis_submit');
    data.append('nonce',  tcpAjax.nonce);

    fetch(tcpAjax.ajaxUrl, {
      method: 'POST',
      body: data,
      credentials: 'same-origin',
    })
      .then(r => r.json())
      .then(res => {
        msgBox.className = 'form-message ' + (res.success ? 'success' : 'error');
        msgBox.textContent = res.data.message;
        msgBox.scrollIntoView({ behavior: 'smooth', block: 'nearest' });

        if (res.success) {
          form.reset();
          if (fileLabel) fileLabel.textContent = 'Glissez et déposez (ou) Choisissez des fichiers';
        }
      })
      .catch(() => {
        msgBox.className = 'form-message error';
        msgBox.textContent = 'Une erreur est survenue. Veuillez réessayer ou nous appeler directement.';
        msgBox.style.display = 'block';
      })
      .finally(() => {
        submitBtn.disabled = false;
        submitBtn.textContent = origText;
      });
  });

})();
