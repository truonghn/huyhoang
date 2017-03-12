jQuery( document ).ready(function($) {
    console.log( "ready!" );
    $(window).load(function() {
    	console.log( "ready!" );
		$('.flexslider').flexslider({
		    animation: "slide",
		    controlNav: "thumbnails",
		    directionNav : false,
		    direction: "vertical",
		    animationLoop: true
		  });
    });
});