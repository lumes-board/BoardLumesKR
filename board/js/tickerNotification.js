let rolling = document.getElementById("tickerNotificationRoller");
 
window.setInterval( function () {
 
	rolling.style.transitionDuration = "1200ms";
	rolling.style.marginTop = "-2em";
 
	window.setTimeout( function () {
                  
		rolling.removeAttribute("style");         
		rolling.appendChild(rolling.firstElementChild);
        
	}, 400);
}, 2000);