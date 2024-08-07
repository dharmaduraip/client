$(document).ready(function () {
    var sections = $(".property_list"),
        nav = $("#navmenu"),
        nav_height = nav.outerHeight(),
        filter_header = $(".navbartwo");
    $(window).on("scroll", function () {
        var cur_pos = $(this).scrollTop();
        sections.each(function () {
            var top = $(this).offset().top - nav_height,
                bottom = top + $(this).outerHeight();
            if (cur_pos >= top && cur_pos <= bottom) {
                $(".spy-menu").find("a").removeClass("active");
                sections.removeClass("active");
                $(this).addClass("active");
                $(".spy-menu")
                    .find('a[href="#' + $(this).attr("id") + '"]')
                    .addClass("active");
            }
        });
        var filter_top = $(".search-left-menu").outerHeight() + $(".slider").outerHeight() + $("header").outerHeight() + $(".filter_header").outerHeight();
        if (cur_pos >= filter_top) {
            filter_header.addClass("fixedtop");
            nav.addClass("topfixedhide");
        } else {
            filter_header.removeClass("fixedtop");
            nav.removeClass("topfixedhide");
        }
    });
   
    // $(".right_search").on("click", function () {
    //     $(".left-menu").toggleClass("left-active");
    //     $(".overlay").toggle();
    // });
    $(".rigt_search").on("click", function () {
        $(".right-menu").addClass("rightsign-active");
        $(".overlay").show();
    });
    $(".overlay, .closefilter").on("click", function () {
        $(".left-menu").removeClass("left-active");
        $(".right-menu").removeClass("right-active");
        $("div").removeClass("rightsign-active");
        $("div").removeClass("rightsignup-active");
        $(".overlay").hide();
        $("body").removeClass("select-short");
    });
    $(" .signup-show").on("click", function () {
        $(".rightsignup").addClass("rightsignup-active");
        $(".overlay").show();
    });
    $(".clicksignin, .loginhomeslide").on("click", function () {
        $(".rightsignin").addClass("rightsign-active");
        $(".rightsignup").removeClass("rightsignup-active");
        $(".overlay").show();
    });
    $(".clickshow, .signup-show").on("click", function () {
        $(".rightsignup").addClass("rightsignup-active");
        $(".rightsignin").removeClass("rightsign-active");
        $(".overlay").show();
    });
    $(".clickimg").on("click", function () {
        $(".hidesearch").css("display", "block");
    });
    $(window).scrollTop(function () {
        $(".filter-div").addClass("shadowbox");
    });
    $(".rigt_search, .signup-show, .loginhomeslide").click(function () {
        $("body").addClass("select-short");
    });
    $(".closebtn").click(function () {
        $("body").removeClass("select-short");
    });
});
$("#check").change(function () {
    if ($("#check:checked").length > 0) {
        $(".showbottmpopup").animate({ bottom: "90px" });
        $(".showbottmpopup").delay(4600).animate({ bottom: "-90px" });
    } else {
        $(".showbottmpopup").animate({ bottom: "-100px" });
    }
});
var counter = 0;
$("#pluss,#plusss").click(function () {
    $("#display,#display1").html(++counter);
});
$("#minuss,#minusss").click(function () {
    $("#display,#display1").html(counter - 1 < 0 ? counter : --counter);
});



  (function($) {
    $.fn.shorten = function (settings) {

      var config = {
        showChars: 100,
        ellipsesText: "...",
        moreText: "more",
        lessText: "less"
      };

      if (settings) {
        $.extend(config, settings);
      }

      $(document).off("click", '.morelink');

      $(document).on({click: function () {

        var $this = $(this);
        if ($this.hasClass('less')) {
          $this.removeClass('less');
          $this.html(config.moreText);
        } else {
          $this.addClass('less');
          $this.html(config.lessText);
        }
        $this.parent().prev().toggle(500);
        $this.prev().toggle(500);
        return false;
      }
    }, '.morelink');

      return this.each(function () {
        var $this = $(this);
        if($this.hasClass("shortened")) return;

        $this.addClass("shortened");
        var content = $this.html();
        if (content.length > config.showChars) {
          var c = content.substr(0, config.showChars);
          var h = content.substr(config.showChars, content.length - config.showChars);
          var html = c + '<span class="moreellipses">' + config.ellipsesText + ' </span><span class="morecontent"><span>' + h + '</span> <a href="#" class="morelink">' + config.moreText + '</a></span>';
          $this.html(html);
          $(".morecontent span").hide();
        }
      });

    };

  })(jQuery);
  $(".showMoreContent").shorten({
    moreText: "Show More",
    lessText: "Show Less",
    showChars : 5
  });

  function AbserveModal( url , title)
{
    $('#abserve-modal-content').html(' ....Loading content , please wait ...');
    $('.abserve-modal-title').html(title);
    $('#abserve-modal-content').load(url,function(){
    });
    $('#abserve-modal').modal('show');  
}


