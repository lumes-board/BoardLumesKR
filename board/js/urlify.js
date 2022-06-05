// replace URL


function urlify(message) {

    let urlRegex = /(www|http:|https:)+[^\s]+[\w]/g;
    let torrentMagnetRegex = /magnet:\?xt=urn:btih:[a-zA-Z0-9]*/g;

    // urlify URL
        // URL (HTTP/HTTPS/FTP/SFTP)
        // TORRENT MAGNET
    let urlified = message.replace(urlRegex, function (url) {
                            return '<span class="bi-link-45deg" style="color: blue;"></span>'
                                    + '<a href="' + url + '" target="_blank">' + url + '</a>';
                        }).replace(torrentMagnetRegex, function (url) {
                            return '<span class="bi-link-45deg" style="color: green;"></span>'
                                    + '<a href="' + url + '" target="_blank" class="link-success">' + url + '</a>';
                        });

    return urlified;

}

window.onload = function(){

    // URL은 바로 접속 가능하게 직접 링크로 바꿔줌
    const boardMessageList = document.getElementsByClassName("boardMessages");
    const boardMessageQty  = boardMessageList.length;

    for(let _seq = 0; _seq < boardMessageQty; _seq++) {

        let targetElementID = "boardMessageColumn" + _seq;
        let targetHTML      = document.getElementById(targetElementID).innerHTML;

        boardMessageList[_seq].innerHTML = urlify(targetHTML);

    }

}