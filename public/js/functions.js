$(function() {
	$('.field, textarea').focus(function() {
        if(this.title==this.value) {
            this.value = '';
        }
    }).blur(function(){
        if(this.value=='') {
            this.value = this.title;
        }
    });

    $('#slider ul').jcarousel({
    	scroll: 1,
		auto: 7,
		itemFirstInCallback : mycarousel_firstCallback,
        wrap: 'both'
    });
   function mycarousel_firstCallback(carousel, item, idx) {
        $('#slider .nav a').bind('click', function() {
            carousel.scroll(jQuery.jcarousel.intval($(this).text()));
            $('#slider .nav a').removeClass('active');
            $(this).addClass('active');
            return false;
        });
        $('#slider .nav a').removeClass('active');
        $('#slider .nav a').eq(idx-1).addClass('active');
    }
	
    $('#best-sellers ul').jcarousel({
        auto: 5,
        scroll: 1,
        wrap: 'circular'
    });
	
     if ($.browser.msie && $.browser.version.substr(0,1)<7) {
        DD_belatedPNG.fix('#logo h1 a, .read-more-btn, #slider .image img, #best-sellers .jcarousel-prev, #best-sellers .jcarousel-next, #slider .jcarousel-container, #best-sellers .price, .shell, #footer, .products ul li a:hover');
    }
});

// tabed navigation 
document.addEventListener('DOMContentLoaded', function() {
	document.getElementById('tab-group').className = 'ready';
	
	var headerClass = 'tab-header',
		contentClass = 'tab-content';
	
	document.getElementById('tab-group').addEventListener('click', function(event) {
		
		var myHeader = event.target;
		
		if (myHeader.className !== headerClass) return;
		
		var myID = myHeader.id, // e.g. tab-header-1
			contentID = myID.replace('header', 'content'); // result: tab-content-1
		
		deactivateAllTabs();
		
		myHeader.className = headerClass + ' active';
		document.getElementById(contentID).className = contentClass + ' active';
	});
	
	function deactivateAllTabs() {
		var tabHeaders = document.getElementsByClassName(headerClass),
			tabContents = document.getElementsByClassName(contentClass);
		
		for (var i = 0; i < tabHeaders.length; i++) {
			tabHeaders[i].className = headerClass;
			tabContents[i].className = contentClass;
		}
	}
});
// rating system
$(document).ready(function(){
//  Check Radio-box
    $(".rating input:radio").attr("checked", false);
    $('.rating input').click(function () {
        $(".rating span").removeClass('checked');
        $(this).parent().addClass('checked');
    });

    /*$('input:radio').change(
    function(){
        var userRating = this.value;
        alert(userRating);
    }); */
});
$.fn.stars = function() {
    return $(this).each(function() {
       var val = parseFloat($(this).html());
       //val = Math.round(val * 2) / 4;
       var size = Math.max(0, (Math.min(5, val))) * 16;
       var $span = $('<span />').width(size);
       $(this).html($span);
    });
};
$(function() {
   $('span.stars').stars(); 
});

