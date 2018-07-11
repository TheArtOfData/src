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



  $("#preload").hide();


  function error(p, text){
    p.text(text).addClass('red-color');
  }

  function addBackgroundError(ele){
    ele.css('background', 'red');
  }

  function validateEmail(email) {
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
  }

  function reset(){
    $("#form-result").removeClass('red-color');
    $("#form-result").removeClass('green-color');
    $("#form-result").html('&nbsp;');

    $("#user_email").removeClass('error-input');
    $("#user_email").removeClass('ok-input');

  }

  $("#user_reset").submit(function(event){
    event.preventDefault();
    let res = $("#form-result");

    reset();


    let user_email = $("#user_email").val().trim();


    if(user_email == "") $("#user_email").addClass('error-input');
    if(!validateEmail(user_email)){
    $("#user_email").addClass('error-input');
    return;
}

    $.post("../api/reset/reset_link.php",
      {
        email: user_email
      },
      function(data, status){
        reset();
        console.log(data);
        if(data.code !== 200){
          switch (data.code) {
            case 401:
              $("#user_email").addClass('error-input');
            case 403:
              $("#user_email").addClass('error-input');
            break;
          }

          error(res, data.Type);

          return;
        }else {
          $("#user_email").addClass('ok-input');
          $("#form-result").removeClass('red-color');
          $("#form-result").addClass('green-color');
          $("#form-result").html('Reset link valido per 30 minuti creato . Controllare la casella di posta.');
          // setTimeout(function(){
          //   reset();
          // }, 2000);
        }

      }
    );
  });
});
