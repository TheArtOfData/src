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
$(document).ready(function(){


$(window).scroll(function(){
	var scroll = $(window).scrollTop();
	var nav = $("#navbar");
	if(scroll>275){
		nav.fadeIn(500, function(){
			nav.removeClass("navbar navbar-fixed-top navbar-default");
			nav.addClass(" navbar navbar-fixed-top navbar-default scrollednav");
		})
	}
	else{
		nav.fadeIn(500,function(){
			nav.removeClass(" navbar navbar-fixed-top navbar-default scrollednav");
			nav.addClass("navbar navbar-fixed-top navbar-default");
		})
	}
});

	//$('.parallax-window').parallax({imageSrc: 'images/img2.jpg'});


	var Messenger = function(el){
		'use strict';
		var m = this;

		m.init = function(){
			m.codeletters = "dhsdsi2333h428reu3ue83242hufkfdsjdsalwoqouryrdcxbx3838492";
			m.message = 0;
			m.current_length = 0;
			m.fadeBuffer = false;
			m.duration = 100;
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

	setTimeout(() => {
		$("a i.arrow").attr( "style", "display: block !important;" );
	},2000);



});

$(function(){
	$('#preload').hide();
});
