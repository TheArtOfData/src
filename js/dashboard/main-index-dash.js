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
$(function() {


  function startIntro(){
    var intro = introJs();
    intro.setOptions({
      steps: [
        {
          intro: "Benvenuto nel portale allora spengo!"
        },
        {
          element: document.querySelector('#sidebar'),
          intro: "Questa è la barra di navigazione"
        },
        {
          element: document.querySelector('#new-channel-ul a'),
          intro: "Qui potrai creare tutti i tuoi canali!"
        },
        {
          element: document.querySelector('#your-channel-ul'),
          intro: "Qui vedrai tutti i canali che hai creato!"
        },
        {
          element: document.querySelector('#shared-channel-ul'),
          intro: "Qui, invece, vedrai tutti i canali che hai iniziato a seguire o che altri utenti ti hanno condiviso!"
        },
        {
          intro: "Inizia subito!"
        }
      ]
    });

    intro.setOption('showBullets', false);
    intro.start();
  }

  if(!Cookies.get("tutorial")){
    setTimeout(function(){
    startIntro();
  }, 500);

    Cookies.set("tutorial", true);
  }

});
