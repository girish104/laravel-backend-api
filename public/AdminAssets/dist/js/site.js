//fullscreen
$("#fullscreen-button").on("click", function toggleFullScreen() {
    if ((document.fullScreenElement !== undefined && document.fullScreenElement === null) || (document.msFullscreenElement !== undefined && document.msFullscreenElement === null) || (document.mozFullScreen !== undefined && !document.mozFullScreen) || (document.webkitIsFullScreen !== undefined && !document.webkitIsFullScreen)) {
        if (document.documentElement.requestFullScreen) {
            document.documentElement.requestFullScreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullScreen) {
            document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
        } else if (document.documentElement.msRequestFullscreen) {
            document.documentElement.msRequestFullscreen();
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }
})


function modelopenPreview_(className) {
    $("#image_previewer").show().css('opacity', '1');
        var output = document.getElementById('image_previewer_iframe');
        output.src = URL.createObjectURL(document.querySelector(className).files[0]);
        console.log(output);
        output.onload = function() {
            URL.revokeObjectURL(output.src) // free memory
        }
}


function preview_by_link_(className) {
    $("#image_previewer").show().css('opacity', '1');
        var output = document.getElementById('image_previewer_iframe');
        output.src = className;
}

function modelClosePreview_(modelid) {
    $("#image_previewer").hide().css('opacity', '0');
    var output = document.getElementById('image_previewer_iframe');
        output.src ='';
}