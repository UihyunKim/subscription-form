function checkPwConfirm() {
  var pw = $('.password input').val();
  var pwConfirm = $('.password-confirm input').val();

  console.log(pwConfirm);

  // pwConfirm only exist in signup page
  if (pwConfirm === undefined) {
    return true;
  }

  if (pwConfirm && pw === pwConfirm) {
    $('.password-confirm input').css('border-color', '#28a745');
    // $('.password-confirm input:focus').css('box-shadow', '0 0 0 0.2rem rgba(40,167,69,.25)');
    $('.password-confirm .invalid-feedback').hide();
    return true;
  } else {
    $('.password-confirm input').css('border-color', '#dc3545');
    // $('.password-confirm input:focus').css('box-shadow', '0 0 0 0.2rem rgba(220,53,69,.25)');
    $('.password-confirm .invalid-feedback').show();

    return false;
  }
}

(function () {
  'use strict';
  window.addEventListener('load', function () {

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');

    // Loop over them and prevent submission
    var validation = Array
      .prototype
      .filter
      .call(forms, function (form) {
        form
          .addEventListener('submit', function (event) {
            if (form.checkValidity() === false || checkPwConfirm() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form
              .classList
              .add('was-validated');

            // password-confirm works independently!!
            checkPwConfirm();

            console.log(checkPwConfirm);

          }, false);

      });
  }, false);
})();

// Check confirm password indentical after submit
$('.pw-confirm-input').keyup(function (e) {
  if ($('form.sign-up-form').hasClass('was-validated')) {
    checkPwConfirm();
  }
});