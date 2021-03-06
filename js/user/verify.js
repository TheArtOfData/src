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
$(function(){
  isLogged(function(result){
    if(result) window.location = "../home/";
    else $("#preload").hide();
  });


  $("#user_verify").submit(function(event){
    event.preventDefault();

    let log = $('#form-result');

    let username = $('#username').val();
    if(!username) return;

    $.post('../api/user/send_verification.php',
    {
      username: username
    },
    function(data, status){
      console.log(data);
      if(data){
        if(data.code == 200)
          log.addClass("green-color").text("Email inviata!");
        else log.addClass("red-color").text(data.Type);
      }
    });
  });
})
