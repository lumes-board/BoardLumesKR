<!-- reCAPTCHA v3 사이트 측 통합 -->

<script src="https://www.google.com/recaptcha/api.js?render=6LelKNIfAAAAADwO6i1cQ7fxIMZYd3AAYKFaQqJm"></script>

<script>
   grecaptcha.ready(function () {
       grecaptcha.execute("[여기에_클라이언트_측_reCAPTCHA키를_넣으세요]", {
           action: 'homepage'
       }).then(function (token) {
           document.getElementById('g-recaptcha').value = token;
       });
   });
</script>
