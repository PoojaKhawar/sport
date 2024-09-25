function match_height(){
    $('.match_height_col').matchHeight();
    $('.match_height_div').matchHeight();
    $('.match_height_heading').matchHeight();
    $('.match_height_txt').matchHeight();
}
match_height();


// $(window).on('load', function() {
//     setTimeout(function() {
//         $('#loading-image').hide();
//     }, 1000);
// });

$(window).on('load', function() {
    setTimeout(function() {
        $('#loading-image').hide();

const tl = gsap.timeline();
tl.from('.banner_section .parent_area h3', {
    x: -100,
    opacity: 0,
    duration: 0.3
});
tl.from('.banner_section .parent_area h4', {
    x: -100,
    opacity: 0,
    duration: 0.3
});
tl.from('.banner_section .parent_area p', {
    x: -100,
    opacity: 0,
    duration: 0.3
});

tl.from('.banner_section .image_area', {
    y: -300,
    opacity: 0,
    duration: 0.5,
});
gsap.from('.header_2 .parent_area .lower_header ul li ', {
    opacity: 0,
    duration: 0.3,
    stagger: {
        each: 0.5,
        from: 'start', 
    },
});

matchMedia.add("(min-width: 361px) and (max-width: 575px) , (max-width: 360px)", ()=>{
    let timelineService = gsap.timeline();
    timelineService.from('.services_section .parent_area .title_area h3', {
        x: -100,
        opacity: 0,
        duration: 0.3,
        delay:1,
    });
    timelineService.from('.services_section .parent_area .title_area p', {
        x: -100,
        opacity: 0,
        duration: 0.3
    });
})
       
    }, 1000);
});

if($('#trust_sec_slider').length)
{
    $('#trust_sec_slider').owlCarousel({
        loop: true,
        autoplay: true,
        autoplayTimeout: 4000,
        autoplaySpeed: 2000,
        margin: 0,
        nav: true,
        dots: false,
        navText: ["<i class='fas fa-long-arrow-left'></i>","<i class='fas fa-long-arrow-right'></i>"],
        responsive:{
            0:{
                items:1
            },
            567:{
                items:1
            },
            768:{
                items:1
            },
            1000:{
                items:1
            }
        }
    });
}



//COUNTER JS
function animateValue(id, start, end, duration) {
  var obj = $("#" + id);
  var startValue = start;
  var diff = end - start;
  var stepSize = diff / (duration / 16.67); 
  var lastFrameValue = 0;

  var interval = setInterval(function() {
    if (startValue >= end) {
      obj.text(end.toLocaleString());
      clearInterval(interval);
      return;
    }

    startValue += stepSize;
    var currentValue = Math.ceil(startValue);
    if (currentValue > end) {
      currentValue = end;
    }
    var increase = currentValue - lastFrameValue;
    obj.text((lastFrameValue + increase).toLocaleString());
    lastFrameValue = currentValue;
  }, 16.67); 
}

$(document).ready(function() {
  var aimSection = document.querySelector('.aim_section');

  var observer = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
      if (entry.isIntersecting) {
        animateValue("counter1", 0, 700, 3000);
        animateValue("counter2", 0, 5000, 3000);
        animateValue("counter3", 0, 10, 3000);
        observer.unobserve(aimSection);
      }
    });
  }, {
    threshold: 0.2 
  });

  observer.observe(aimSection);
});



//HEADER MENU
if ($('.open_menu').length) {
    let menu = document.querySelector('.open_menu');
    let resHeader = document.querySelector('.responsive_header');
    let body = document.querySelector('body');
    menu.addEventListener('click',()=>{
        menu.classList.toggle("active");
        resHeader.classList.toggle("show");
        body.classList.toggle("scroll_off");
    })
}


//FIXED HEADER
let lastScrollTop = 0;

window.addEventListener('scroll', () => {
  const header = document.getElementById('myHeader');
  const currentScroll = window.pageYOffset;

  if (currentScroll === 0) {
    // At the top of the screen
    header.classList.remove('fixed', 'hide');
  } else if (currentScroll > lastScrollTop) {
    // Scrolling down
    header.classList.add('hide');
    header.classList.remove('fixed');
  } else {
    // Scrolling up
    header.classList.remove('hide');
    header.classList.add('fixed');
  }

  lastScrollTop = currentScroll <= 0 ? 0 : currentScroll; 
});




let matchMedia = gsap.matchMedia();

matchMedia.add("(min-width: 1920px) , (min-width: 576px) and (max-width: 767px) ,(min-width: 1680px) and (max-width: 1919px),(min-width: 1600px) and (max-width: 1679px) , (min-width: 1400px) and (max-width: 1599px),(min-width: 1300px) and (max-width: 1399px),(min-width: 1200px) and (max-width: 1299px),(min-width: 992px) and (max-width: 1199px),(min-width: 768px) and (max-width: 991px)",  ()=>{
    let timelineService = gsap.timeline({
        scrollTrigger:{
            trigger:'.services_section',
            start: 'top 60%',
        }
    })
    timelineService.from('.services_section .parent_area .title_area h3', {
        x: -100,
        opacity: 0,
        duration: 0.3
    });
    timelineService.from('.services_section .parent_area .title_area p', {
        x: -100,
        opacity: 0,
        duration: 0.3
    });
})



let timelineGetTouch = gsap.timeline({
    scrollTrigger:{
        trigger:'.get_touch_section',
        start: 'top 60%',
    }
})

timelineGetTouch.from('.get_touch_section .inner_area .content_main .left_area', {
    x: -300,
    opacity: 0,
    duration: 0.5
});
timelineGetTouch.from('.get_touch_section .inner_area .content_main .right_area .form_area', {
    y: 100,
    opacity: 0,
    duration: 0.5
});


let timeline = gsap.timeline({
    scrollTrigger:{
        trigger:'.aim_section .parent_area .our_value_area .cards_area',
        start: 'top 60%',
    }
})

timeline.from('.aim_section .parent_area .our_value_area .cards_area .my_card', {
    y: -100,
    opacity: 0,
    duration: .5,
    overwrite: true, 
    stagger: {
        each: 0.5,
        from: 'start', 
    },
    onComplete: () => {
    gsap.set('.my_card', { 
      css: { transition: 'all .5s ease-in-out' }
    });
  },
});

let timelineAim = gsap.timeline({
    scrollTrigger:{
        trigger:'.aim_section',
        start: 'top 60%',
    }
})

timelineAim.from('.aim_section .parent_area h3', {
    x: -100,
    opacity: 0,
    duration: 0.5
});



let timelineFaq = gsap.timeline({
    scrollTrigger:{
        trigger:'.faqs_section',
        start: 'top 60%',
    }
})

timelineFaq.from('.faqs_section .inner_faqs .faqs_head h3', {
    x: -100,
    opacity: 0,
    duration: 0.5
});
timelineFaq.from('.faqs_section .inner_faqs .accordion_main .accordion .accordion-item', {
    opacity: 0,
    duration: 0.3,
    stagger: {
        each: 0.5,
        from: 'start', 
    },
});

