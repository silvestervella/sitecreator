(function($) {


    // OPEN CLOSE MENU

    $('#open-menu-button').on('click', function() {
        $('#off-canvas-menu').css('display','block').animate({
            top:'0vh'
        },700);
        $('body').delay(50).animate({paddingTop:'30%'},700);
        return false
    });

    $('#close-menu-button').on('click', function() {
        $('#off-canvas-menu').animate({
            top:'-100vh'
        },700, function() {
            $(this).css('display','hidden');
        });
        $('body').animate({paddingTop:'0'},600);
        return false
    });



    // SCROLL TO TOP

    $(window).on('scroll', function() {
        $(window).height();
        if($(this).scrollTop() >= $(this).height()/10) {
            $('.index-title').removeClass('top-1').addClass('top-0');
            $('header, .all-projects-title h1, .index-title h1').slideUp(500);
        }
        if($(this).scrollTop() < $(this).height()/10) {
            $('.all-projects-title, .index-title').removeClass('top-0').addClass('top-1');
            $('header, .all-projects-title h1, .index-title h1').slideDown(100);
        }
        if($(this).scrollTop() >= $(this).height()/2) {
            $('.back-to-top-button').slideDown();
        }
        if($(this).scrollTop() < $(this).height()/2) {
            $('.back-to-top-button').slideUp();
        }
    })

    $('.back-to-top-button').on('click', function() {
        $('html, body').animate({scrollTop:'0'},500);
    })



    // COMMENTS INPUTS PLACEHOLDERS

    $('.comment-form-comment textarea').attr('placeholder','Your Comment');
    $('.comment-form-author input').attr('placeholder','Name');
    $('.comment-form-email input').attr('placeholder','Email');
    $('.comment-form-url input').attr('placeholder','Website');



    // PARALLAX

    $window = $(window);
    $('.parallax').each(function() {
        var $scroll = $(this);
        $(window).scroll(function() {
            var yPos = -($window.scrollTop() / 6);
            var coords = '50% ' + yPos + 'px';
            $scroll.css({ backgroundPosition: coords });
        });
    });



    // LINK NAV EFFECTS

    // On Load
    $('body').children().not('.load-bar').css('opacity','0');
    $(window).on('load', function() {
        setTimeout(function() {
            $('.load-bar').fadeOut();
            $('body').children().not('.load-bar').animate({opacity:'1'},300);
        }, 700)
    })

    // On Click
    $('a').not('.comments a').click(function(e) {
        e.preventDefault();
        newLocation = this.href;
        newpage();
    });

    function newpage() {
        window.location = newLocation;
    }



    // FULL PAGE NAV EFFECTS

    $('#fullpage').fullpage({

		scrollingSpeed: 1000,
		sectionSelector: '.section',
		onLeave: function(index, nextIndex, direction){
            var $home_underline_width = $('.home-underline').width();
            var $home_excerpt_text_height = $('.home-excerpt-text').height();
            if(direction == 'down') {
                $(this).find('.home-excerpt-background').animate({height:'0'},600);
                $(this).next().find('.home-excerpt-background').css('bottom','25vh').delay(300).animate({bottom:'0'},600);
                $('.home-title').slideUp(400).slideDown(600);
                $('.home-underline').animate({left:'-'+$home_underline_width},200);
                $('.home-excerpt-text').animate({opacity:'0'},200);
            } else {
                $(this).find('.home-excerpt-background').animate({bottom:'25vh'},600,function() {
                    $(this).delay(400).animate({bottom:'0'},0);
                })
                $(this).prev().find('.home-excerpt-background').delay(300).animate({height:'75vh'},600);
                $('.home-title').slideUp(400).slideDown(600);
                $('.home-underline').animate({left:'-'+$home_underline_width},200);
                $('.home-excerpt-text').animate({opacity:'0'},200);
            }
        },
		afterLoad: function(anchorLink, index) {
            $('.home-underline').delay(100).animate({left:'0'},300);
            $('.home-excerpt-text').animate({opacity:'1'},300);
        },

	});


}(jQuery));
