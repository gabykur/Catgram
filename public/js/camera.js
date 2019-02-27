var canvas = document.getElementById('canvas');
var context = canvas.getContext('2d');
var video = document.getElementById('video');
var snap = document.getElementById('snap');
var overlay_image = document.getElementById("overlay");


// Changes class of selected tree
var stickerDisplay = document.getElementById("sticker_div");
var stickerImg = stickerDisplay.getElementsByClassName("stickerImg");
for (var i = 0; i < stickerImg.length; i++) {
    stickerImg[i].addEventListener("click", function() {
        active_photo = document.getElementsByClassName("active");
        active_photo[0].className = active_photo[0].className.replace(" active", "");
        this.className += " active";
        overlay_image.src = this.src;
    });
}

// Return currently selected tree
function stickerSelector() {
    var header = document.getElementById("sticker_div");
    var selectedSticker = header.getElementsByClassName("active");
    return selectedSticker[0];
}

// Put event listeners into place
window.addEventListener("DOMContentLoaded", function() {
    var mediaConfig =  { video: true, audio: false };
    var errBack = function(e) {
        console.log('An error has occurred!', e)
    };

    if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia(mediaConfig)
        .then(function(stream) {
            video.srcObject = stream;
            video.play();
        });
    }

    snap.addEventListener('click', function() {
        context.drawImage(video, 0, 0, 240, 180);
        var currentSticker = stickerSelector();
        document.getElementById('sticker_div').value = currentSticker.src;
        context.drawImage(currentSticker, 0, 0, 90, 80); 
    });
}, false);