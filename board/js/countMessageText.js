// 글자 수 길이 측정 (향상된 For문을 이용한 성능 대폭 향상 버전)
// https://programmingsummaries.tistory.com/239
function getByteLengthOfUtf8String(s) {
    if (s != undefined && s != "") {
        for (b = i = 0; c = s.charCodeAt(i++); b += c >> 11 ? 3 : c >> 7 ? 2 : 1);
        return b;
    } else {
        return 0;
    }
}


let writeForm               = document.getElementById("messageContent");
let textLengthCounter       = document.getElementById("textLengthCounter");
let textlengthProgressBar   = document.getElementById("textLengthProgressBar");

writeForm.addEventListener("input", function (e){

    let textLength = getByteLengthOfUtf8String(writeForm.value);
    const textCounterMessage = textLength.toLocaleString('ko-KR') + " / 1,500 Bytes";
    const progressBarWidth   = (textLength / 1500) * 100;

    textLengthCounter.innerHTML = textCounterMessage;
    textlengthProgressBar.style.width = progressBarWidth + "%";

    if(progressBarWidth < 75) {
        textlengthProgressBar.className = "progress-bar progress-bar-striped";
    } else if(progressBarWidth >= 75 && progressBarWidth < 100) {
        textlengthProgressBar.className = "progress-bar progress-bar-striped bg-warning";
    } else if (progressBarWidth >= 100) {
        textlengthProgressBar.className = "progress-bar progress-bar-striped bg-danger";
    }

})