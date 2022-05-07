const signupForm                = document.querySelector(".registration-form");
const signupButton              = document.querySelector("#registrationSubmitButton");
const checkIDValidityButton     = document.querySelector("#checkIDValidityButton");
const checkEmailValidityButton  = document.querySelector("#checkEmailValidityButton")

const userID            = document.querySelector("#userID");
const userNickname      = document.querySelector("#userNickname");
const userPassword1     = document.querySelector("#userPassword1");
const userPassword2     = document.querySelector("#userPassword1");
const userEmail         = document.querySelector("#userEmail");
const agreementCheckbox = document.querySelector("#flexCheckDefault");


// ID 확인하기
checkIDValidityButton.addEventListener("click", function (e) {

    location.href = "checkID.php?id=" + userID.value;

});

// E-mail 확인하기
checkEmailValidityButton.addEventListener("click", function (e) {

    location.href = "checkEmail.php?email=" + userEmail.value;

});

signupButton.addEventListener("click", function (e) {

    if(agreementCheckbox.checked == true){

        signupForm.submit();

    } else {

        Swal.fire({
            icon: 'error',
            title: '회원약관 동의 필요',
            footer: '회원약관을 읽으신 다음, 해당 약관에 동의하셔야(체크표시에 체크) 회원가입이 진행되며 향후 서비스를 이용하실 수 있습니다.'
        })

    }

});