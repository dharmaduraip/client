/**
 * eClass - Learning Management System 
 *
 * This file contains all theme JS functions
 *
 * @package 
--------------------------------------------------------------
           Contents
--------------------------------------------------------------
* 01 - Protip
* 02 - Owl Caserol 
        - Student-view-slider-one
        - Student-view-slider
        - Testimonial-Slider
        - Patners-slider
        - Student-view-slider-two
        - Testimonial-Slider-one
        - Blog-slider
        - Business-Home-slider-two
        - Tab-Pane-Slider
        - Categories-tab-Slider
        - Home-Slider
        - Zoom-view-Slider
        - Bundle-view-Slider
        - My-courses-Slider
* 02 - Facts Count
* 03 - Navigation / Menu
* 04 - Smooth Scroll
* 05 - Filter
* 06 - Mailchimp Form
* 07 - Protip
* 08 - Video Play
* 08 - Preloader
* 09 - Read More
* 09 - Promo Bar

--------------------------------------------------------------*/

(function($) {
  "use strict";

/* ========================= */
  /*===== Protip =====*/
/* ========================= */
  $.protip();

  var $window = $( window )
 

/* ================================= */
  /*===== Owl Caserol =====*/
/* ================================= */
// Student-view-slider-one  
    var owl = $("#student-view-slider-one").owlCarousel({
      loop: true,
      items: 3,
      dots: false,
      nav: true,      
      autoplayTimeout: 10000,
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 10,
      autoplay: true,
      lazyLoad:true,
      slideSpeed: 600,
      navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        600: {
            items: 2,
            nav: false,
            dots: false,
        },
        768: {
            items: 3,
            nav: false,
            dots: false,
        },
        1100: {
            items: 3,
            nav: true,
            dots: false,
        }
      }
    });
    
// Student-view-slider  
    var fecnt = $("#student-view-slider").attr('data-featcor');
    if(fecnt > 4)
    {
        var fecorlo = true;
    }
    else
    {
        var fecorlo = false;
    }
    $("#student-view-slider").owlCarousel({
      loop: fecorlo,
      items: 5,
      dots: false,
      nav: false,      
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 10,
      autoplay: false,
      lazyLoad:true,
      slideSpeed: 600,
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        400: {
            items: 2,
            nav: false,
            dots: false,
        },
        600: {
            items: 2,
            nav: false,
            dots: false,
        },
        768: {
            items: 2,
            nav: false,
            dots: false,
        },
        1000: {
            items: 4,
            nav: false,
            dots: false,
        }
      }
    });

// Recommendations Slider  
    $("#recommendations-slider").owlCarousel({
      loop: true,
      items: 1,
      dots: true,
      nav: true,      
      autoplayTimeout: 5000,
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 30,
      autoplay: true,
      lazyLoad:true,
      slideSpeed: 600,
      navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        600: {
            items: 1,
            nav: false,
            dots: false,
        },
        768: {
            items: 1,
            nav: false,
            dots: false,
        },
        992: {
            items: 1,
            nav: true,
            dots: true,
        },
        1100: {
            items: 1,
            nav: true,
            dots: true,
        }
      }
    });

  // Featured Instructor
  var  lcntfein = $("#instructor-home-slider-two").attr('data-fein');
  if(lcntfein > 4)
  {
        var lcntfin = true;
  }
  else
  {
        var lcntfin = false;
  }
  $("#instructor-home-slider-two").owlCarousel({
    loop: lcntfin,
    items: 5,
    dots: false,
    nav: false,      
    autoplayTimeout: 10000,
    smartSpeed: 2000,
    autoHeight: false,
    touchDrag: true,
    mouseDrag: true,
    margin: 10,
    autoplay: true,
    lazyLoad:true,
    slideSpeed: 600,
    navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
    responsive: {
      0: {
          items: 1,
          nav: false,
          dots: false,
      },
      400: {
          items: 2,
          nav: false,
          dots: false,
      },
      600: {
          items: 2,
          nav: false,
          dots: false,
      },
      768: {
          items: 2,
          nav: false,
          dots: false,
      },
      1000: {
          items: 4,
          nav: false,
          dots: false,
      }
    }
  });
  
  // Testimonial-Slider  
    $("#testimonial-slider").owlCarousel({
      loop: true,
      items: 2,
      dots: true,
      nav: false,      
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 0,
      autoplay: false,
      lazyLoad:true,
      slideSpeed: 600,
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        600: {
            items: 1,
            nav: false,
            dots: false,
        },
        768: {
            items: 2,
            nav: false,
            dots: false,
        },
        1100: {
            items: 2,
            nav: false,
            dots: true,
        }
      }
    });

  // Instructor Home Slider  
    var lcntali = $("#instructor-home-slider").attr('data-ali');
    if(lcntali > 4)
    {
        var lcntalil =true;
    }
    else
    {
        var lcntalil =false;
    }

    $("#instructor-home-slider").owlCarousel({
      loop: lcntalil,
      items: 5,
      dots: true,
      nav: false,      
      autoplayTimeout: 10000,
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 30,
      autoplay: false,
      lazyLoad:true,
      slideSpeed: 600,
      navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        600: {
            items: 1,
            nav: false,
            dots: false,
        },
        768: {
            items: 2,
            nav: false,
            dots: false,
        },
        992: {
            items: 3,
            nav: false,
            dots: true,
        },
        1000: {
            items: 4,
            nav: false,
            dots: true,
        }
      }
    });

  // Institute Home Slider  
    var lcntinst = $("#institute-home-slider").attr('data-ins');
    if(lcntinst > 4)
    {
        var lcntins = true;
    }
    else
    {
        var lcntins = false;
    }

    $("#institute-home-slider").owlCarousel({
      loop: lcntins,
      items: 5,
      dots: true,
      nav: false,      
      autoplayTimeout: 10000,
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 30,
      autoplay: false,
      lazyLoad:true,
      slideSpeed: 600,
      navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        600: {
            items: 1,
            nav: false,
            dots: false,
        },
        768: {
            items: 2,
            nav: false,
            dots: false,
        },
        992: {
            items: 3,
            nav: false,
            dots: true,
        },
        1000: {
            items: 4,
            nav: false,
            dots: true,
        }
      }
    });

 // Patners-slider  
    var cotrusc = $("#patners-slider").attr('data-truscom');
    if(cotrusc > 5)
    {
        var trucom = true;
    }
    else
    {
        var trucom = false;
    }
    $("#patners-slider").owlCarousel({
      loop: trucom,
      items: 6,
      dots: false,
      nav: true,      
      autoplayTimeout: 10000,
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 20,
      autoplay: true,
      lazyLoad:true,
      slideSpeed: 600,
      navText: ['<i class="flaticon-back" aria-hidden="true"></i>', '<i class="flaticon-next-1" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 3,
            nav: false,
            dots: false,
        },
        600: {
            items: 3,
            nav: false,
            dots: false,
        },
        768: {
            items: 6,
            nav: false,
            dots: false,
        },
        1100: {
            items: 6,
            nav: false,
            dots: false,
        }
      }
    });

  // Student-view-slider-two 
    var owl = $("#student-view-slider-two").owlCarousel({
      loop: true,
      items: 3,
      dots: false,
      nav: true,      
      autoplayTimeout: 10000,
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 10,
      autoplay: true,
      lazyLoad:true,
      slideSpeed: 600,
      navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        600: {
            items: 2,
            nav: false,
            dots: false,
        },
        768: {
            items: 3,
            nav: false,
            dots: false,
        },
        1000: {
            items: 5,
            nav: true,
            dots: false,
        }
      }
    });

  // Testimonial-Slider-one 
    $("#testimonial-slider-one").owlCarousel({
      loop: true,
      items: 3,
      dots: false,
      nav: true,      
      autoplayTimeout: 10000,
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 10,
      autoplay: true,
      lazyLoad:true,
      slideSpeed: 600,
      navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        600: {
            items: 2,
            nav: false,
            dots: false,
        },
        768: {
            items: 3,
            nav: true,
            dots: false,
        },
        1100: {
            items: 5,
            nav: true,
            dots: false,
        }
      }
    });

  // Blog-slider 
    $("#blog-slider").owlCarousel({
      loop: true,
      items: 1,
      dots: false,
      nav: true,      
      autoplayTimeout: 10000,
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 40,
      autoplay: true,
      lazyLoad:true,
      slideSpeed: 600,
      navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        600: {
            items: 1,
            nav: false,
            dots: false,
        },
        768: {
            items: 1,
            nav: false,
            dots: false,
        },
        1000: {
            items: 1,
            nav: true,
            dots: false,
        }
      }
    });

  // Business-Home-slider-two  
    $("#business-home-slider-two").owlCarousel({
      loop: true,
      items: 5,
      dots: false,
      nav: true,      
      autoplayTimeout: 10000,
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 20,
      autoplay: true,
      lazyLoad:true,
      slideSpeed: 600,
      navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        600: {
            items: 1,
            nav: false,
            dots: false,
        },
        768: {
            items: 1,
            nav: true,
            dots: false,
        },
        1100: {
            items: 1,
            nav: true,
            dots: false,
        }
      }
    });

  // Tab-Pane-Slider
    $("#tab-pane-slider").owlCarousel({
      loop: true,
      items: 4,
      dots: false,
      nav: true,      
      autoplayTimeout: 10000,
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 20,
      autoplay: true,
      lazyLoad:true,
      slideSpeed: 600,
      navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        600: {
            items: 1,
            nav: false,
            dots: false,
        },
        768: {
            items: 1,
            nav: true,
            dots: false,
        },
        1100: {
            items: 4,
            nav: true,
            dots: false,
        }
      }
    });

  // Categories-tab-Slider
    $("#categories-tab-slider").owlCarousel({
      loop: true,
      items: 12,
      dots: false,
      nav: false,      
      autoplayTimeout: 10000,
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 20,
      autoplay: true,
      lazyLoad:true,
      slideSpeed: 600,
      navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 2,
            nav: false,
            dots: false,
        },
        600: {
            items: 3,
            nav: false,
            dots: false,
        },
        768: {
            items: 5,
            nav: false,
            dots: false,
        },
        1100: {
            items: 6,
            nav: false,
            dots: false,
        }
      }
    });

  // Home-Slider
    $("#home-background-slider").owlCarousel({
      loop: true,
      items: 12,
      dots: false,
      nav: true,      
      autoplayTimeout: 10000,
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 0,
      autoplay: true,
      lazyLoad:true,
      slideSpeed: 600,
      navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        600: {
            items: 1,
            nav: false,
            dots: false,
        },
        768: {
            items: 1,
            nav: false,
            dots: false,
        },
        1100: {
            items: 1,
            nav: false,
            dots: false,
        }
      }
    });

    // zoom-view-slider  
    var lcntzmvs = $("#zoom-view-slider").attr('data-lmc');
    if(lcntzmvs > 4)
    {
        var lzvs = true;
    }
    else
    {
        var lzvs = false;
    }

    $("#zoom-view-slider").owlCarousel({
      loop: lzvs,
      items: 5,
      dots: false,
      nav: false,      
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 10,
      autoplay: false,
      lazyLoad:true,
      slideSpeed: 600,
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        400: {
            items: 2,
            nav: false,
            dots: false,
        },
        600: {
            items: 2,
            nav: false,
            dots: false,
        },
        768: {
            items: 2,
            nav: false,
            dots: false,
        },
        1000: {
            items: 4,
            nav: false,
            dots: false,
        }
      }
    });


    // bundle-view-slider  
    var lcntbuv = $("#bundle-view-slider").attr('data-buco');
    if(lcntbuv > 4)
    {
        var lcntbuvc = true;
    }
    else
    {
        var lcntbuvc = false;
    }
    $("#bundle-view-slider").owlCarousel({
      loop: lcntbuvc,
      items: 5,
      dots: false,
      nav: false,      
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 10,
      autoplay: false,
      lazyLoad:true,
      slideSpeed: 600,
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        400: {
            items: 2,
            nav: false,
            dots: false,
        },
        600: {
            items: 2,
            nav: false,
            dots: false,
        },
        768: {
            items: 2,
            nav: false,
            dots: false,
        },
        1000: {
            items: 4,
            nav: false,
            dots: false,
        }
      }
    });

    // subscription-bundle-view-slider
    var lcntsubuco = $("#subscription-bundle-view-slider").attr('data-subucor');
    if(lcntsubuco > 4)
    {
        var lcntsubc = true;
    }
    else
    {
        var lcntsubc = false;
    }
    $("#subscription-bundle-view-slider").owlCarousel({
      loop: lcntsubc,
      items: 5,
      dots: false,
      nav: false,      
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 10,
      autoplay: false,
      lazyLoad:true,
      slideSpeed: 600,
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        400: {
            items: 2,
            nav: false,
            dots: false,
        },
        600: {
            items: 2,
            nav: false,
            dots: false,
        },
        768: {
            items: 2,
            nav: false,
            dots: false,
        },
        1000: {
            items: 4,
            nav: false,
            dots: false,
        }
      }
    });

    // big blue-view-slider  
    $("#bbl-view-slider").owlCarousel({
      loop: true,
      items: 5,
      dots: false,
      nav: true,      
      autoplayTimeout: 10000,
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 10,
      autoplay: true,
      lazyLoad:true,
      slideSpeed: 600,
      navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        400: {
            items: 2,
            nav: false,
            dots: false,
        },
        600: {
            items: 2,
            nav: false,
            dots: false,
        },
        768: {
            items: 2,
            nav: false,
            dots: false,
        },
        1100: {
            items: 4,
            nav: true,
            dots: false,
        }
      }
    });

    // my-courses-slider  
    var lcntmpurcor = $("#my-courses-slider").attr('data-purcor');

    if(lcntmpurcor > 4)
    {
        var lcntpurco = true;
    }
    else
    {
        var lcntpurco = false;
    }

    $("#my-courses-slider").owlCarousel({
      loop: lcntpurco,
      items: 5,
      dots: false,
      nav: false,      
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 10,
      autoplay: true,
      lazyLoad:true,
      slideSpeed: 600,
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        400: {
            items: 2,
            nav: false,
            dots: false,
        },
        600: {
            items: 2,
            nav: false,
            dots: false,
        },
        768: {
            items: 2,
            nav: false,
            dots: false,
        },
        1000: {
            items: 4,
            nav: false,
            dots: false,
        }
      }
    });

    // recent-courses-slider
    var lcntrevcor = $("#recent-courses-slider").attr('data-reviewcor');
    if(lcntrevcor > 4)
    {
        var lcntrevc = true;
    }
    else
    {
        var lcntrevc = false;   
    }
 
    $("#recent-courses-slider").owlCarousel({
      loop: lcntrevc,
      items: 5,
      dots: false,
      nav: false,      
      autoplayTimeout: 10000,
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 10,
      autoplay: true,
      lazyLoad:true,
      slideSpeed: 600,
      navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        400: {
            items: 2,
            nav: false,
            dots: false,
        },
        600: {
            items: 2,
            nav: false,
            dots: false,
        },
        768: {
            items: 3,
            nav: false,
            dots: false,
        },
        1100: {
            items: 4,
            nav: false,
            dots: false,
        }
      }
    });


    // blog-slider  
    var lcntbls = $("#blog-post-slider").attr('data-rbs');
    if(lcntbls > 4)
    {
        var lcntrb = true;
    }
    else
    {
         var lcntrb = false;
    }
    $("#blog-post-slider").owlCarousel({
      loop: lcntrb,
      items: 5,
      dots: false,
      nav: false,      
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 10,
      autoplay: false,
      lazyLoad:true,
      slideSpeed: 600,
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        400: {
            items: 2,
            nav: false,
            dots: false,
        },
        600: {
            items: 2,
            nav: false,
            dots: false,
        },
        768: {
            items: 2,
            nav: false,
            dots: false,
        },
        1000: {
            items: 4,
            nav: false,
            dots: false,
        }
      }
    });

    // blog-slider  
    $("#batch-view-slider").owlCarousel({
      loop: true,
      items: 5,
      dots: false,
      nav: true,      
      autoplayTimeout: 10000,
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 10,
      autoplay: true,
      lazyLoad:true,
      slideSpeed: 600,
      navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        400: {
            items: 2,
            nav: false,
            dots: false,
        },
        600: {
            items: 2,
            nav: false,
            dots: false,
        },
        768: {
            items: 2,
            nav: false,
            dots: false,
        },
        1000: {
            items: 4,
            nav: true,
            dots: false,
        }
      }
    });

    // google-view-slider  start
     $("#google-view-slider").owlCarousel({
      loop: true,
      items: 5,
      dots: false,
      nav: true,      
      autoplayTimeout: 10000,
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 10,
      autoplay: true,
      lazyLoad:true,
      slideSpeed: 600,
      navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        400: {
            items: 2,
            nav: false,
            dots: false,
        },
        600: {
            items: 2,
            nav: false,
            dots: false,
        },
        768: {
            items: 3,
            nav: false,
            dots: false,
        },
        1100: {
            items: 4,
            nav: true,
            dots: false,
        }
      }
    });
// google-view-slider end

// jitsi-view-slider  start
     $("#jitsi-view-slider").owlCarousel({
      loop: true,
      items: 5,
      dots: false,
      nav: true,      
      autoplayTimeout: 10000,
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 10,
      autoplay: true,
      lazyLoad:true,
      slideSpeed: 600,
      navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        400: {
            items: 2,
            nav: false,
            dots: false,
        },
        600: {
            items: 2,
            nav: false,
            dots: false,
        },
        768: {
            items: 3,
            nav: false,
            dots: false,
        },
        1100: {
            items: 4,
            nav: true,
            dots: false,
        }
      }
    });
// jitsi-view-slider end

// googleclassroom-view-slider  start
     $("#googleclassroom-view-slider").owlCarousel({
      loop: true,
      items: 5,
      dots: false,
      nav: true,      
      autoplayTimeout: 10000,
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 10,
      autoplay: true,
      lazyLoad:true,
      slideSpeed: 600,
      navText: ['<i class="fa fa-chevron-left" aria-hidden="true"></i>', '<i class="fa fa-chevron-right" aria-hidden="true"></i>'],
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        400: {
            items: 2,
            nav: false,
            dots: false,
        },
        600: {
            items: 2,
            nav: false,
            dots: false,
        },
        768: {
            items: 3,
            nav: false,
            dots: false,
        },
        1100: {
            items: 4,
            nav: true,
            dots: false,
        }
      }
    });



    // Student-view-slider  
    var lcntbsc = $("#bestseller-view-slider").attr('data-besse');
    if(lcntbsc > 4)
    {
        var lcntbs = true;
    }
    else
    {
        var lcntbs = false;
    }
    $("#bestseller-view-slider").owlCarousel({
      loop: lcntbs,
      items: 5,
      dots: false,
      nav: false,      
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 10,
      autoplay: false,
      lazyLoad:true,
      slideSpeed: 600,
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        400: {
            items: 2,
            nav: false,
            dots: false,
        },
        600: {
            items: 2,
            nav: false,
            dots: false,
        },
        768: {
            items: 2,
            nav: false,
            dots: false,
        },
        1000: {
            items: 4,
            nav: false,
            dots: false,
        }
      }
    });
    var ldiscour = $("#discounted-view-slider").attr('data-discour');
    if(ldiscour > 4)
    {
        var iocount = true;
    }
    else
    {
        iocount = false;
    }
   
    $("#discounted-view-slider").owlCarousel({
      loop: iocount,
      items: 5,
      dots: false,
      nav: false,      
      smartSpeed: 2000,
      autoHeight: false,
      touchDrag: true,
      mouseDrag: true,
      margin: 10,
      autoplay: false,
      lazyLoad:true,
      slideSpeed: 600,
      responsive: {
        0: {
            items: 1,
            nav: false,
            dots: false,
        },
        400: {
            items: 2,
            nav: false,
            dots: false,
        },
        600: {
            items: 2,
            nav: false,
            dots: false,
        },
        768: {
            items: 2,
            nav: false,
            dots: false,
        },
        1000: {
            items: 4,
            nav: false,
            dots: false,
        }
      }
    });
    
    // googleclassroom-view-slider end

/* ================================= */
    /*===== Facts Count  =====*/
/* ================================= */ 
    if ($('.counter').length) {   
      $('.counter').counterUp({
        delay: 20,
        time: 2000
      });
    }
    
/* ================================= */
    /*===== Navigation / Menu  =====*/
/* ================================= */ 
    $("#cssmenu").menumaker({
      title: "Menu",
      format: "multitoggle"
    });

/* ================================= */
    /*===== Smooth Scroll =====*/
/* ================================= */ 
    smoothScroll.init();


/* ================================= */
    /*===== Filter =====*/
/* ================================= */ 
// Animate Filter for Immigration Slider
    var owlAnimateFilter = function(even) {
      $(this)
      .addClass('__loading')
      .delay(70 * $(this).parent().index())
      .queue(function() {
        $(this).dequeue().removeClass('__loading')
      })
    }
    $('.btn-filter-wrap').on('click', '.btn-filter', function(e) {
      var filter_data = $(this).data('filter');
      /* return if current */
      if($(this).hasClass('btn-active')) return;
      /* active current */
      $(this).addClass('btn-active').siblings().removeClass('btn-active');
      /* Filter */
      owl.owlFilter(filter_data, function(_owl) { 
        $(_owl).find('.item').each(owlAnimateFilter); 
      });
    });

/* ================================= */
    /*===== Mailchimp Form =====*/
/* ================================= */   
    $('#subscribe-form').ajaxChimp({
        url: 'http://blahblah.us1.list-manage.com/subscribe/post?u=5afsdhfuhdsiufdba6f8802&id=4djhfdsh9'
    });

/* ========================= */
  /*===== Protip =====*/
/* ========================= */
    $.protip();
    $("#aBtn").on('click',function(){
      console.log($(window).height());
      $("#popupBox").height($(window).height());
      $(".overlay").height($(window).height())
      $("#popupBox").addClass("show");
      $("body").addClass("hide_sb");
    });
    $(".overlay").on('click',function(){
      $("#popupBox").removeClass("show");
      $("body").removeClass("hide_sb")
    });
    $(".close").on('click',function(){
      $("#popupBox").removeClass("show");
      $("body").removeClass("hide_sb")
    });

/* ================================= */
      /*===== Video Play =====*/
/* ================================= */    
  $('.btn-video-play').on('click',function() {
    if(video_url != ''){
      $('.video-item .video-preview').append(video_url);
      $(this).hide();
    }
    
  }); 
    
/* ================================= */
  /*===== Preloader =====*/
/* ================================= */ 
  $window.on('load', function()  { 
    $('.status').fadeOut();
    $('.preloader').fadeOut('slow'); 
  }); 


/* ================================= */
  /*===== Payment Radio Button =====*/
/* ================================= */
  $('#r11').on('click', function () {
    $(this).parent().find('a').trigger('click')
  })
  $('#r12').on('click', function () {
    $(this).parent().find('a').trigger('click')
  })
  $('#r13').on('click', function () {
    $(this).parent().find('a').trigger('click')
  })
  $('#rpesapal').on('click', function () {
    $(this).parent().find('a').trigger('click')
  })
  $('#r14').on('click', function () {
    $(this).parent().find('a').trigger('click')
  })
  $('#r15').on('click', function () {
    $(this).parent().find('a').trigger('click')
  })
  $('#r16').on('click', function () {
    $(this).parent().find('a').trigger('click')
  })
  $('#r17').on('click', function () {
    $(this).parent().find('a').trigger('click')
  })
  $('#r18').on('click', function () {
    $(this).parent().find('a').trigger('click')
  })

  $('#ppay').on('click', function () {
    $(this).parent().find('a').trigger('click')
  })

  $('#cpay').on('click', function () {
    $(this).parent().find('a').trigger('click')
  })

  $('#mpay').on('click', function () {
    $(this).parent().find('a').trigger('click')
  })

  $('#skpay').on('click', function () {
    $(this).parent().find('a').trigger('click')
  })

  $('#rpay').on('click', function () {
    $(this).parent().find('a').trigger('click')
  })

  $('#omise').on('click', function(){
    $(this).parent().find('a').trigger('click')
  })

  $('#payhere').on('click', function(){
    $(this).parent().find('a').trigger('click')
  })

  $('#izyy').on('click', function(){
    $(this).parent().find('a').trigger('click')
  })

  $('#ssl').on('click', function(){
    $(this).parent().find('a').trigger('click')
  })

  $('#aamar').on('click', function(){
    $(this).parent().find('a').trigger('click')
  })

  $('#twocheck').on('click', function(){
    $(this).parent().find('a').trigger('click')
  })

  $('#wallet').on('click', function(){
    $(this).parent().find('a').trigger('click')
  })

  $('#mpesalabel').on('click', function(){
    $(this).parent().find('a').trigger('click')
  })

  $('#smanagerlabel').on('click', function(){
    $(this).parent().find('a').trigger('click')
  })

  $('#payflexi').on('click', function(){
    $(this).parent().find('a').trigger('click')
  })

  $('#esewa').on('click', function(){
    $(this).parent().find('a').trigger('click')
  })

  $('#paytab').on('click', function(){
    $(this).parent().find('a').trigger('click')
  })

  $('#dpopay').on('click', function(){
    $(this).parent().find('a').trigger('click')
  })

  $('#authorize').on('click', function(){
    $(this).parent().find('a').trigger('click')
  })

  $('#bkash').on('click', function(){
    $(this).parent().find('a').trigger('click')
  })

  $('#midtrains').on('click', function(){
    $(this).parent().find('a').trigger('click')
  })

  $('#worldpay').on('click', function(){
    $(this).parent().find('a').trigger('click')
  })

  $('#squarepay').on('click', function(){
    $(this).parent().find('a').trigger('click')
  })



/* ================================= */
  /*===== Notification Icon =====*/
/* ================================= */
  $(document).ready(function()
  {
  $("#notificationLink").on('click',function()
  {
  $("#notificationContainer").fadeToggle(300);
  $("#notification_count").fadeOut("slow");
  return false;
  });

  //Document Click hiding the popup 
  $(document).on('click',function()
  {
  $("#notificationContainer").hide();
  });
 

  });

  $(document).ready(function()
  {
  $("#notificationLinkk").on('click',function()
  {
  $("#notificationContainerr").fadeToggle(300);
  $("#notification_countt").fadeOut("slow");
  return false;
  });

  //Document Click hiding the popup 
  $(document).on('click',function()
  {
  $("#notificationContainerr").hide();
  });
 

  });

/* ========================= */
  /*===== Tooltip =====*/
/* ========================= */
  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })

/* ========================= */
  /*===== Select 2 =====*/
/* ========================= */
$(document).ready(function() 
{  $('.js-example-basic-single').select2();
});


/* ================================ */
  /*===== Navbar name show/hide=====*/
/* ================================ */
 // navbar user name show 
$( ".dropdown" ).on('hover',function() {
    $( "#name" ).addClass('name-shown');
  }, function() {
    $( "#name" ).removeClass('name-shown');
  }
);


/* ================================ */
  /*===== Read More =====*/
/* ================================ */
$('.moreless-button').click(function() {
  $('.moretext').slideToggle();
  if ($('.moreless-button').text() == "Read more") {
    $(this).text("Read less")
  } else {
    $(this).text("Read more")
  }
});


/* ================================ */
    /*===== Promo Bar =====*/
/* ================================ */
$("#promo-tab").hide();
$("#close").on("click", function(){
  $("#promo-outer").slideUp();
  $("#promo-tab").hide();
});
$("#promo-outer").on("click", function(){
  $("#promo-outer").slideUp();
  $("#promo-tab").hide();
});
$("#promo-tab").on("click", function(){
  $(this).slideUp();
  $("#promo-outer").slideDown();
});

/* ================================ */
    /*===== Screen Search =====*/
/* ================================ */
$(function () {
    $('a[href="#find"]').on('click', function(event) {
        event.preventDefault();
        $('#find').addClass('open');
        $('#find > form > input[type="find"]').focus();
    });
    $('#find, #find button.close').on('click keyup', function(event) {
        if (event.target == this || event.target.className == 'close' || event.keyCode == 27) {
            $(this).removeClass('open');
        }
    });
});

/* ================================ */
    /*===== Side Humburger =====*/
/* ================================ */
$(document).ready(function () {
  var trigger = $('.hamburger'),
      overlay = $('.overlay'),
     isClosed = false;
    trigger.click(function () {
      hamburger_cross();
    });
    function hamburger_cross() {
      if (isClosed == true) {
        overlay.hide();
        trigger.removeClass('is-open');
        trigger.addClass('is-closed');
        isClosed = false;
      } else {
        overlay.show();
        trigger.removeClass('is-closed');
        trigger.addClass('is-open');
        isClosed = true;
      }
  }
  $('[data-toggle="offcanvas"]').click(function () {
        $('#wrapper').toggleClass('toggled');
  });
});

/* ================================ */
    /*===== New Search =====*/
/* ================================ */

var $search = $( '#search' ),
  $searchinput = $search.find('input.search-input'),
  $body = $('html,body'),
  openSearch = function() {
    $search.data('open',true).addClass('search-open');
    $searchinput.focus();
    return false;
  },
  closeSearch = function() {
    $search.data('open',false).removeClass('search-open');
  };

$searchinput.on('click',function(e) { e.stopPropagation(); $search.data('open',true); });

$search.on('click',function(e) {
  e.stopPropagation();
  if( !$search.data('open') ) {

    openSearch();

    $body.off( 'click' ).on( 'click', function(e) {
      closeSearch();
    } );

  }
  else {
    if( $searchinput.val() === '' ) {
      closeSearch();
      return false;
    }
  }
});


})(jQuery);