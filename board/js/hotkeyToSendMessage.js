
let submitButton    = document.getElementById("messageSubmitButton");

function sendMessageViaHotkey(e){

    // [Ctrl] + [Enter] 또는 [⌘ Command] + [Enter] 단축 조합키 세트를 누르면 바로 전송
    if((e.ctrlKey || e.metaKey) && (e.keyCode == 13 || e.keyCode == 10)){
        submitButton.click();
    }

}