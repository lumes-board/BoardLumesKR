function getStringCharCount(string){

    return string.length;

}


let writeForm               = document.getElementById("messageContent");
let textLengthCounter       = document.getElementById("textLengthCounter");
let textlengthProgressBar   = document.getElementById("textLengthProgressBar");

writeForm.addEventListener("input", function (e){

    let textLength = getStringCharCount(writeForm.value);
    const textCounterMessage = "<i class='bi bi-speedometer'></i>&nbsp;" + textLength.toLocaleString('ko-KR') + " / 1,500 Chars";
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