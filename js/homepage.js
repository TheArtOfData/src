// TheArtOfData
//   Copyright (C) 2018  by Anceschi Giovanni, Belmonte Luca, Boschini Matteo, Mechetti Luca, Monari Pietro, Scarfone Salvatore, Tardini Giovanni
//
//   Mail : theartofdat@gmail.com
//
//   This program is free software: you can redistribute it and/or modify
//   it under the terms of the GNU Affero General Public License as published
//   by the Free Software Foundation, either version 3 of the License, or
//   (at your option) any later version.
//
//   This program is distributed in the hope that it will be useful,
//   but WITHOUT ANY WARRANTY; without even the implied warranty of
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//   GNU Affero General Public License for more details.
//
//   You should have received a copy of the GNU Affero General Public License
//   along with this program.  If not, see <http://www.gnu.org/licenses/>.
(function($) {
  "use strict"; // Start of use strict

  // Smooth scrolling using jQuery easing
  $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
    if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
      var target = $(this.hash);
      target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
      if (target.length) {
        $('html, body').animate({
          scrollTop: (target.offset().top - 57)
        }, 1000, "easeInOutExpo");
        return false;
      }
    }
  });

  // Closes responsive menu when a scroll trigger link is clicked
  $('.js-scroll-trigger').click(function() {
    $('.navbar-collapse').collapse('hide');
  });

  // Activate scrollspy to add active class to navbar items on scroll
  $('body').scrollspy({
    target: '#mainNav',
    offset: 57
  });

  // Collapse Navbar
  var navbarCollapse = function() {
    if ($("#mainNav").offset().top > 100) {
      $("#mainNav").addClass("navbar-shrink");
    } else {
      $("#mainNav").removeClass("navbar-shrink");
    }
  };
  // Collapse now if page is not at top
  navbarCollapse();
  // Collapse the navbar when page is scrolled
  $(window).scroll(navbarCollapse);

  // Scroll reveal calls
  window.sr = ScrollReveal();
  sr.reveal('.sr-icons', {
    duration: 600,
    scale: 0.3,
    distance: '0px'
  }, 200);

  sr.reveal('.sr-img', {
    duration: 700,
    scale: 0.5
  });

  sr.reveal('.sr-button', {
    duration: 1000,
    delay: 200
  });
  sr.reveal('.sr-contact', {
    duration: 600,
    scale: 0.3,
    distance: '0px'
  }, 300);

  // Magnific popup calls
  $('.popup-gallery').magnificPopup({
    delegate: 'a',
    type: 'image',
    tLoading: 'Loading image #%curr%...',
    mainClass: 'mfp-img-mobile',
    gallery: {
      enabled: true,
      navigateByImgClick: true,
      preload: [0, 1]
    },
    image: {
      tError: '<a href="%url%">The image #%curr%</a> could not be loaded.'
    }
  });


  $.getJSON("/language/" + LANG + ".json", function(data){


    let app = data.landing_page;

    let keys = Object.keys(app);

    for (let i in keys) {
      let key = keys[i];
      $('.' + key).html(app[key]);
    }
  });


  var Messenger = function(el){
        'use strict';
        var m = this;

        m.init = function(){
            m.codeletters = "jfew6732";
            m.message = 0;
            m.current_length = 10;
            m.fadeBuffer = false;
            m.duration = 80;
            m.messages = [
                'Scopri la potenza dei dati'
            ];

            setTimeout(m.animateIn, 100);
        };

        m.generateRandomString = function(length){
            var random_text = '';
            while(random_text.length < length){
                random_text += m.codeletters.charAt(Math.floor(Math.random()*m.codeletters.length));
            }

            return random_text;
        };

        m.animateIn = function(){
            if(m.current_length < m.messages[m.message].length){
                m.current_length = m.current_length + 2;
                if(m.current_length > m.messages[m.message].length) {
                    m.current_length = m.messages[m.message].length;
                }

                var message = m.generateRandomString(m.current_length);

                $(el).html(message);

                setTimeout(m.animateIn, 20);
            } else {
                setTimeout(m.animateFadeBuffer, 20);
            }
        };

        m.animateFadeBuffer = function(){
            if(m.fadeBuffer === false){
                m.fadeBuffer = [];
                for(var i = 0; i < m.messages[m.message].length; i++){
                    m.fadeBuffer.push({c: (Math.floor(Math.random()*12))+1, l: m.messages[m.message].charAt(i)});
                }
            }

            var do_cycles = false;
            var message = '';

            for(var i = 0; i < m.fadeBuffer.length; i++){
                var fader = m.fadeBuffer[i];
                if(fader.c > 0){
                    do_cycles = true;
                    fader.c--;
                    message += m.codeletters.charAt(Math.floor(Math.random()*m.codeletters.length));
                } else {
                    message += fader.l;
                }
            }

            $(el).html(message);

            if(do_cycles === true){
                setTimeout(m.animateFadeBuffer, m.duration);
            } else {
                setTimeout(m.cycleText, 2000);
            }
        };

        m.cycleText = function(){
            m.message = m.message + 1;
            if(m.message >= m.messages.length){
                m.message = 0;
            }

            m.current_length = 0;
            m.fadeBuffer = false;

        };

        m.init();
    }

    
    var messenger = new Messenger($('#messenger'));

})(jQuery); // End of use strict
