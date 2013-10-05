jQuery(document).ready(function(){
    // when user clicks inside the container...
    jQuery('.curtain_wrapper').click(function(){
        // animate the description div by changing it's left position to it's width (but as negative number)...
        jQuery(this).children('.description').animate({'left': -1*jQuery(this).width()});

        // animate the 2 curtain images to width of 50px with duration of 2 seconds...
        jQuery(this).children('img.curtain').animate({ width: 50 },{duration: 2000});

        // show the content behind the curtains with fadeIn function (2 seconds)
        jQuery(this).children('.content').fadeIn(2000);
    });
});