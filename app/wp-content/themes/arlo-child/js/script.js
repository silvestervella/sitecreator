jQuery(document).ready(function(){var s;jQuery(".calc").change(function(){for(var e=jQuery(".calc:checked").map(function(){return jQuery(this).attr("number")}).get(),t=0,s=0;s<e.length;s++)t+=e[s]<<0;jQuery("#quote-items").html("Your Price Is <span>&euro;"+t+"</span>")}),jQuery(".quote-sec").on("click",".next",function(){event.preventDefault(),jQuery(this).parent().addClass("prev-field ").nextAll(".quote-sec").first().addClass("active").prevAll(".quote-sec").first().removeClass("active")}),jQuery(".quote-sec").on("click",".prev",function(){event.preventDefault(),jQuery(this).parent().prevAll(".quote-sec").first().addClass("active").nextAll(".quote-sec").first().removeClass("active"),jQuery(this).parent().prevAll(".quote-sec").first().removeClass("prev-field")}),jQuery("div.tablinks").on("click",function(){var e,t,s,r;for(r=jQuery(this).attr("name"),t=jQuery("div.tabcontent"),e=0;e<t.length;e++)t[e].style.display="none";for(s=jQuery("div.tablinks"),e=0;e<s.length;e++)s[e].className=s[e].className.replace(" active","");jQuery("#"+r).css({display:"block"}).display="block",jQuery(this).addClass("active")}),jQuery("div.tabcontent").first().css({display:"block"}),jQuery(".view-button").on("click",function(){var e=jQuery(this).attr("url"),t=window.open(e,"_blank");t?t.focus():alert("Browser blocked the preview popup. Please copy the following URL to a new tab: "+e),window.open(e,"_blank")}),(s=jQuery).fn.classes=function(e){var n=[];if(s.each(this,function(e,t){for(var s=t.className.split(/\s+/),r=0;r<s.length;r++){var a=s[r];-1===n.indexOf(a)&&n.push(a)}}),"function"==typeof e)for(var t in n)e(n[t]);return n},jQuery('input:radio[name="templates"]').change(function(){if(this.checked){var e=jQuery(this).classes(),t=e[e.length-1];jQuery("fieldset.specs").filter("."+t).addClass("quote-sec").siblings(".specs").removeClass("quote-sec")}})});