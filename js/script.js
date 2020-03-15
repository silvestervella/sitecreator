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
      event.preventDefault();

        jQuery(this)
        .parent()
        .addClass('prev-field ')
        .nextAll('.quote-sec').first()
        .addClass('active')
        .prevAll('.quote-sec').first()
        .removeClass('active')

    });
    jQuery('.quote-sec').on("click", '.prev' ,function() {
      event.preventDefault();


    

      jQuery(this)
      .parent()
      .prevAll('.quote-sec').first()
      .addClass('active')
      .nextAll('.quote-sec').first()
      .removeClass('active')

        
      jQuery(this)
      .parent()
      .prevAll('.quote-sec').first()
      .removeClass('prev-field')
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

        var win = window.open(pageLink, '_blank');
        if (win) {
            //Browser has allowed it to be opened
            win.focus();
        } else {
            //Browser has blocked it
            alert('Browser blocked the preview popup. Please copy the following URL to a new tab: ' + pageLink);
        }

        window.open(pageLink,'_blank');
      });
      

      // 1.6 Choose specs div depending on category

      //Function to get classes
      ;!(function ($) {
        $.fn.classes = function (callback) {
            var classes = [];
            $.each(this, function (i, v) {
                var splitClassName = v.className.split(/\s+/);
                for (var j = 0; j < splitClassName.length; j++) {
                    var className = splitClassName[j];
                    if (-1 === classes.indexOf(className)) {
                        classes.push(className);
                    }
                }
            });
            if ('function' === typeof callback) {
                for (var i in classes) {
                    callback(classes[i]);
                }
            }
            return classes;
        };
    })(jQuery);


      jQuery('input:radio[name="templates"]').change(
        function(){
            if (this.checked) {
              //get classes of checked radio
              var raio_classes = jQuery(this).classes();
              var last_class = raio_classes[raio_classes.length - 1];

              jQuery('fieldset.specs').filter('.' + last_class).addClass('quote-sec').siblings('.specs').removeClass('quote-sec');            
            }
        });



});