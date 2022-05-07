const signupForm                = document.querySelector(".registration-form");
const signupButton              = document.querySelector("#registrationSubmitButton");
const checkIDValidityButton     = document.querySelector("#checkIDValidityButton");
const checkEmailValidityButton  = document.querySelector("#checkEmailValidityButton")

const userID                = document.querySelector("#userID");
const userNickname          = document.querySelector("#userNickname");
const userPassword1         = document.querySelector("#userPassword1");
const userPassword2         = document.querySelector("#userPassword1");
const userEmail             = document.querySelector("#userEmail");


// ID 확인하기
checkIDValidityButton.addEventListener("click", function(e){

    location.href = "checkID.php?id=" + userID.value;

})

// E-mail 확인하기
checkEmailValidityButton.addEventListener("click", function(e){

    location.href = "checkEmail.php?email=" + userEmail.value;

})

signupButton.addEventListener("click", function(e){

    

})