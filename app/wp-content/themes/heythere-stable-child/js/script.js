jQuery(document).ready(function(){jQuery(".calc").change(function(){for(var e=jQuery(".calc:checked").map(function(){return jQuery(this).attr("number")}).get(),t=0,n=0;n<e.length;n++)t+=e[n]<<0;jQuery("#quote-items").html("Your Price Is <span>&euro;"+t+"</span>")}),jQuery(".quote-sec").on("click",".next",function(){jQuery(this).parent().addClass("prev-field ").next().addClass("active").prev().fadeOut(1e3,function(){jQuery(this).removeClass("active")})}),jQuery("div.tablinks").on("click",function(){var e,t,n,a;for(a=jQuery(this).attr("name"),t=jQuery("div.tabcontent"),e=0;e<t.length;e++)t[e].style.display="none";for(n=jQuery("div.tablinks"),e=0;e<n.length;e++)n[e].className=n[e].className.replace(" active","");jQuery("#"+a).css({display:"block"}).display="block",jQuery(this).addClass("active")}),jQuery("div.tabcontent").first().css({display:"block"}),jQuery(".options").change(function(){var e=jQuery(this).find(":selected").attr("url");console.log(e),jQuery(this).siblings(".view-option").find(".view-button").attr("href",e).attr("target","_blank")})});