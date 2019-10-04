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
    jQuery("#quote-items").text(total);
    });

});