$(document).ready(function() {
	
	"use strict"
	
	/*
	 * ----------------------------------------------------------------------------------------
	 * has menu
	 * ----------------------------------------------------------------------------------------
	 */
	$('body').on("click", ".has_menu", function(e) {
		var id = $(this).attr('id'), menu = $(this).children('.menu');
		$('.menu').hide();
		$('.has_menu').attr('id', 0);
		
		if(id == 1)
		{
			menu.hide();
			$(this).attr('id', 0).removeClass('active');
		} else
		{
			menu.show();
			$(this).attr('id', 1).addClass('active');
		}
	});


	// Mouse click on has_menu
	$("body").on('mouseup', '.has_menu',function() {
		return false
	});

	// Mouse click on menu
	$("body").on('mouseup', '.menu',function() {
		return false 
	});
	
	/*
	 * ----------------------------------------------------------------------------------------
	 * show aside
	 * ----------------------------------------------------------------------------------------
	 */
	
	$("body").on("click", ".mobile_navicon", function() {
		var aside = $(".aside"), id = $(this).attr("id");
		var lightOverlay = $(".light_overlay");
		if(id == 1) {
			aside.removeClass("expanded");
			lightOverlay.css({"visibility":"hidden"});
			$(this).attr('id', 0);
			
		}
		else {
			aside.addClass("expanded");
			lightOverlay.css({"visibility":"visible"});
			$(this).attr("id", 1);
		}
	});
	
	// Mouse click on has_menu
	$("body").on('mouseup', '.mobile_navicon',function() {
		return false
	});

	// Mouse click on menu
	$("body").on('mouseup', '.aside',function() {
		return false
	});

	
});

$(document).mouseup(function(){
	// Hide active dropdown menu
	$(".menu").hide();
	$(".has_menu").attr("id", "").removeClass("active");
	// Hide aside
	$(".mobile_navicon").attr("id", "");
	$(".aside").removeClass("expanded");
	$(".light_overlay").css({"visibility":"hidden"});
});