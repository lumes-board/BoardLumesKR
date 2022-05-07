const signupForm                = document.querySelector(".registration-form");
const signupButton              = document.querySelector("#registrationSubmitButton");
const checkIDValidityButton     = document.querySelector("#checkIDValidityButton");
const checkEmailValidityButton  = document.querySelector("#checkEmailValidityButton")

const userID            = document.querySelector("#userID");
const userNickname      = document.querySelector("#userNickname");
const userPassword1     = document.querySelector("#userPassword1");
const userPassword2     = document.querySelector("#userPassword2");
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

    // 클라이언트 측 검증은 최소한만 하고 서버에서 확실하게 처리하도록 한다.

    // 약관 동의 여부
    if(agreementCheckbox.checked == true){

        // 모든 값이 작성되어 있는지?
        if(userID.value && userNickname.value && userPassword1.value && userPassword2.value && userEmail.value){

            // 패스워드가 두개 모두 일치하는지?
            if(userPassword1.value === userPassword2.value){

                signupForm.submit();

            } else {

                Swal.fire({
                    icon: 'error',
                    title: '비밀번호 입력 오류',
                    footer: '비밀번호와 비밀번호 확인(다시 입력)란에 정확하게 같은 비밀번호를 입력하세요.'
                })

            }

        } else {

            Swal.fire({
                icon: 'error',
                title: '무언가가 허전하군요...',
                footer: '모든 내용을 빠짐없이 잘 작성하셨나요?'
            })

        }

    } else {

        Swal.fire({
            icon: 'error',
            title: '회원약관 동의 필요',
            footer: '회원약관을 읽으신 다음, 해당 약관에 동의하셔야(체크표시에 체크) 회원가입이 진행되며 향후 서비스를 이용하실 수 있습니다.'
        })

    }

});