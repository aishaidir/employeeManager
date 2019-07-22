$(document).ready(function() {
	
	"use strict"
	
	/*
	 * ----------------------------------------------------------------------------------------
	 * has menu
	 * ----------------------------------------------------------------------------------------
	 */
	$('body').on("mouseover", ".photo_previewer", function(e) {
		var id = $(this).attr("id"), photoOverlay = $(this).children('.photo_overlay');
		var menu = $(this).children('.menu');
		photoOverlay.show();
	});
	$('body').on("mouseout", ".photo_previewer", function(e) {
		var id = $(this).attr("id"), menu = $(this).children('.menu'), photoOverlay = $(this).children('.photo_overlay');
		if(id != 1) {
			photoOverlay.hide();	
		}
	});
	
	
});

$(document).mouseup(function(){
	$('.photo_overlay').hide();
});

function validatePhoto() {
    var img = document.getElementById('file'), photoPreview = document.getElementById('photo_preview');
        var file = img.files[0];
        var type = file.type;
        var imagename = file.name;
        var size = file.size;
        var match = ["image/jpeg", "image/png", "image/jng"];
        
        // var match = ["image/jpeg", "image/jpg", "image/png", "video/mp4"];
        
	// if(!((type==match[0]) || (type==match[1]) || (type==match[2]) || (type==match[3]))) {

		if(!((type==match[0]) || (type==match[1]) || (type==match[2]) )) {

            alert('Invalid file format');
            photoPreview.src = baseURL()+'imgs/blank.png';
            return false;
	}
    if(size > 1000024) {
    	alert('File too large. 1MB max.');
        return false;
    } 
	else {
    	var reader = new FileReader();
        var uploadButton = $('#upload_photo');
        reader.addEventListener("load", function() {
        	photoPreview.src = reader.result;
        }, false);
        reader.readAsDataURL(file);
    }
}