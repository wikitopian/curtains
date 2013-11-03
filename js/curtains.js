jQuery(document).ready(function( $ ){

	$('img.curtain').css('width', curtains.width / 2);
	$('img.curtain').css('height', curtains.height);

	$('div.curtain_content').css('width', curtains.width);

	$('div.curtain_wrapper').css('width', curtains.width);
	$('div.curtain_wrapper').css('height', curtains.height);
	$('div.curtain_wrapper').css('visibility', 'visible');

	$('div.curtain_content > a > img').css('width', Math.floor(100 / curtains.count) + '%');

	// when user clicks inside the container...
	$('.curtain_wrapper').click(function(){
		// animate the description div by changing it's left position to it's width (but as negative number)...
		$(this).children('.curtain_description').animate({'left': -1*$(this).width()});
		$(this).children('.curtain_description').fadeOut(2000);

		// animate the 2 curtain images to width of 0px with duration of 2 seconds...
		$(this).children('img.curtain').animate({ width: 0 },{duration: 2000});

		// show the content behind the curtains with fadeIn function (2 seconds)
		$(this).children('.curtain_content').fadeIn(2000);
	});
});
