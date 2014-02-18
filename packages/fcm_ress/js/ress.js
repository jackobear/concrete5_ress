
// This extension is part of a core override to implement RESS as detailed here:
// http://www.netmagazine.com/tutorials/getting-started-ress

RESS = {};

RESS.writeCookie = function (name, value) {
	document.cookie = name + "=" + value + "; expires=Sat, 1 Jan 2033 01:01:01 UTC; path=/";
}

//Store width in a cookie
RESS.storeSizes = function () {

	$(document).ready(function() {
    //Get screen width
    var width = 0;
    if (self.innerHeight){
      width = self.innerWidth;
    }else if (document.documentElement && document.documentElement.clientHeight){
      width = document.documentElement.clientWidth;
    }else if (document.body){
      width = document.body.clientWidth;
    }

    // Set a cookie with the client side capabilities.
    RESS.writeCookie("RESS", "width." + width);
   });
}

RESS.storeSizes();

RESS.isResizeActive = false;

window.onresize = function (event) {
    if (!RESS.isResizeActive) {
        RESS.isResizeActive = true;

        //make sure we do not do this too often, wait 1 second...
        window.setTimeout(function () {
            RESS.storeSizes();
            RESS.isResizeActive = false;
        }, 1000);
    }
}
