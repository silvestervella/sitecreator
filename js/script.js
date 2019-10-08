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


    // 1.5 check if ecommerce to add html
    jQuery('.templates').change(function() {

      //if (jQuery(this).hasClass('e-commerce').is(':checked')) {

          jQuery('#specs').load( "/ecommerce.html" );
   
     // }

    });

});