jQuery(document).ready(function(e){function i(){var i=e(window).scrollTop();n(i),o=i,t=!1}function n(e){o-e>r?s.removeClass("hide"):e-o>r&&e>d&&s.addClass("hide")}var s=e("header .nav"),a=s.height(),t=!1,o=0,r=10,d=150;s.on("click",".nav-trigger",function(e){e.preventDefault(),s.toggleClass("nav-open")}),e(window).on("scroll",function(){t||(t=!0,window.requestAnimationFrame?requestAnimationFrame(i):setTimeout(i,250))}),e(window).on("resize",function(){a=s.height()});var t=!1;e(window).on("scroll",function(){t||(t=!0,window.requestAnimationFrame?requestAnimationFrame(i):setTimeout(i,250))}),e("header .nav-item > a").click(function(i){e(this).parent(".nav-item").find("aside.menu").hasClass("is-visible")?(i.preventDefault(),e(this).find("aside.menu").removeClass("is-visible"),e(this).parents(".nav-center").find("aside.menu").removeClass("is-visible")):e(this).parent(".nav-item").find("aside.menu").length&&(i.preventDefault(),e(this).parents(".nav-center").find("aside.menu").removeClass("is-visible"),e(this).parent(".nav-item").find("aside.menu").addClass("is-visible"))})});