jQuery(document).ready(function(){jQuery(".calc").change(function(){for(var e=jQuery(".calc:checked").map(function(){return jQuery(this).attr("number")}).get(),t=0,a=0;a<e.length;a++)t+=e[a]<<0;jQuery("#quote-items").html("Your Price Is <span>&euro;"+t+"</span>")}),jQuery(".quote-sec").on("click",".next",function(){jQuery(this).parent().addClass("prev-field ").next().addClass("active").prev().fadeOut(1e3,function(){jQuery(this).removeClass("active")})}),jQuery("div.tablinks").on("click",function(){var e,t,a,n;for(n=jQuery(this).attr("name"),t=jQuery("div.tabcontent"),e=0;e<t.length;e++)t[e].style.display="none";for(a=jQuery("div.tablinks"),e=0;e<a.length;e++)a[e].className=a[e].className.replace(" active","");jQuery("#"+n).css({display:"block"}).display="block",jQuery(this).addClass("active")}),jQuery("div.tabcontent").first().css({display:"block"})});