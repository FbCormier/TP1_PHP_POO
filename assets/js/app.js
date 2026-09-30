// Ask for confirmation before submitting any form marked with data-confirm
document.addEventListener("DOMContentLoaded", function () {
  document.querySelectorAll("form[data-confirm]").forEach(function (form) {
    form.addEventListener("submit", function (event) {
      if (!confirm(form.dataset.confirm)) {
        event.preventDefault();
      }
    });
  });
});
