/**
 *
 * 0. Generic
 *
 * 0.1 Variables
 *
 * 0.2 Functions
 *
 *
 *
 * 1. document.ready
 *
 * 1.1 Function calls
 * 1.2 Quote price calculator
 * 1.3 Quote fieldset animation
 * 1.4 Quote fieldset tabs
 * 1.5 Add link to view button for templates
 *
 *
 * 2. window.load
 *
 *
 *
 * 3. Event listenners
 *
 * 4. window.load
 *
 *
 */


 // 1. document.ready
jQuery(document).ready(function() {

    // 1.2 Quote price calculator
    jQuery('.calc').change(function() {
        var itemNames = jQuery(".calc:checked").map(function() {
            return jQuery(this).attr("number")
            }).get();    
            var total = 0;
            for (var i = 0; i < itemNames.length; i++) {
            total += itemNames[i] << 0;
        }                         
        jQuery("#quote-items").html('Your Price Is <span>&euro;' + total + '</span>');
        });

    // 1.3 Quote fieldset animation
    jQuery('.quote-sec').on("click", '.next' ,function() {

        jQuery(this)
        .parent()
        .addClass('prev-field ')
        .next()
        .addClass('active')
        .prev()
        .fadeOut(1000 ,function(){
            jQuery(this).removeClass('active')
        })

    });
    jQuery('.quote-sec').on("click", '.prev' ,function() {

      if (jQuery(this).parent().prev().hasClass('prev-field') ) {
        jQuery(this)
        .parent()
        .prev()
        .removeClass('prev-field')
      }

      jQuery(this)
      .parent()
      .addClass('prev-field ')
      .prev()
      .addClass('active')
      .next()
      .fadeOut(1000 ,function(){
          jQuery(this).removeClass('active')
      })

  });

    // 1.4 Quote fieldset tabs
    jQuery('div.tablinks').on("click", function() {
        // Declare all variables
        var i, tabcontent, tablinks , clickedbutton;

        clickedbutton = jQuery(this).attr('name');
      
        // Get all elements with class="tabcontent" and hide them
        tabcontent = jQuery('div.tabcontent');
        for (i = 0; i < tabcontent.length; i++) {
          tabcontent[i].style.display = "none";
        }
      
        // Get all elements with class="tablinks" and remove the class "active"
        tablinks = jQuery('div.tablinks');
        for (i = 0; i < tablinks.length; i++) {
          tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
      
        // Show the current tab, and add an "active" class to the button that opened the tab
        jQuery('#' + clickedbutton).css({
            'display': 'block'
        }).display = "block";
        jQuery(this).addClass('active');
      });
      jQuery('div.tabcontent').first().css({
        'display': 'block'
      });


      // 1.5 Add link to view button for templates
      // jQuery('.options').change(function() {
      //   var viewLink = jQuery(this).find(":selected").attr('url');
      //   console.log(viewLink);
      //   jQuery(this).siblings('.view-option').find('.view-button').attr('href' , viewLink).attr('target', '_blank');
      // });

      jQuery('.view-button').on('click' , function() {
        var pageLink = jQuery(this).attr('url');
        jQuery('#preview-frame').attr('src' , pageLink).fadeIn();
        jQuery('#iframe-close').fadeIn();
      });
      jQuery('#iframe-close span').on('click' , function() {
        jQuery('#preview-frame').fadeOut(function(){
          jQuery(this).attr('src' , '');
        })
        jQuery(this).parent().fadeOut();
      })


});