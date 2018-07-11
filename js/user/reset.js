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
    $("#form-result").html('&nbsp;');


    $("#psw").removeClass('error-input');
    $("#psw2").removeClass('error-input');


    $("#psw").removeClass('ok-input');
    $("#psw2").removeClass('ok-input');
  }

  $("#user_reset").submit(function(event){
    event.preventDefault();
    let res = $("#form-result");

    reset();


    let psw = $("#psw").val().trim();
    let psw2 = $("#psw2").val().trim();




    if(psw == "") $("#psw").addClass('error-input');
    if(psw2 == "") $("#psw2").addClass('error-input');


    if(psw !== psw2) {
      $("#psw").addClass('error-input');
      $("#psw2").addClass('error-input');
      error(res, "Le password non coincidono!");
      return;
    }


    if(psw.length < 8){
      error(res, "La password deve contenere almeno 8 caratteri!");
      $("#psw").addClass('error-input');
      $("#psw2").addClass('error-input');
      return;
    }

    $.post("../api/reset/reset.php",
      {
        key: KEY,
        new_psw: psw
      },
      function(data, status){
        if(data.code !== 200){
          switch (data.code) {

            case 409:
              $("#psw").addClass('error-input');
              $("#psw2").addClass('error-input');
            case 777:
                $("#psw").addClass('error-input');
                $("#psw2").addClass('error-input');
            break;
          }

          error(res, data.Type);

          return;
        }else{
        reset();

        $("#psw").addClass('ok-input');

        $("#psw2").addClass('ok-input');

          setTimeout(function(){
            window.location = "../login/";
          }, 500);
}
      }
    );
  });
});
