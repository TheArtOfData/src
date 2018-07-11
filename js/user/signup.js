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

  isLogged(function(result){
    if(result) window.location = "../home/";
    else $("#preload").hide();
  });



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

    $("#username").removeClass('error-input');
    $("#email").removeClass('error-input');
    $("#psw").removeClass('error-input');
    $("#psw2").removeClass('error-input');

    $("#username").removeClass('ok-input');
    $("#email").removeClass('ok-input');
    $("#psw").removeClass('ok-input');
    $("#psw2").removeClass('ok-input');
  }

  $("#user_signup").submit(function(event){
    event.preventDefault();
    let res = $("#form-result");

    reset();


    let username = $("#username").val().trim();
    let email = $("#email").val().trim();
    let psw = $("#psw").val().trim();
    let psw2 = $("#psw2").val().trim();

    if(username.indexOf(" ") > -1){
      $("#username").addClass('error-input');
      error(res, "L'username non può contenere spazi!");
      return;
    }

    if(username == "") $("#username").addClass('error-input');
    if(email == "") $("#email").addClass('error-input');
    if(psw == "") $("#psw").addClass('error-input');
    if(psw2 == "") $("#psw2").addClass('error-input');

    if(username == "" || email == "" || psw == "" || psw2 == "") return;

    if(psw !== psw2) {
      $("#psw").addClass('error-input');
      $("#psw2").addClass('error-input');
      error(res, "Le password non coincidono!");
      return;
    }

    if(!validateEmail(email)){
      $("#email").addClass('error-input');
      error(res, "Inserire un email valida");
      return;
    }

    if(psw.length < 8){
      error(res, "La password deve contenere almeno 8 caratteri!");
      $("#psw").addClass('error-input');
      return;
    }

    $.post("../api/user/user_signup.php",
      {
        username: username,
        email: email,
        psw: psw
      },
      function(data, status){
        reset();
        //console.log(data);
        if(data.code !== 200){
          switch (data.code) {

            case 402:
              error(res, data.Type);
              $("#email").addClass('error-input');
              $("#username").addClass('error-input');
            break;
            default:
            error(res, data.Type);
          }
          return;
        } else {
          res.removeClass('red-color');
          res.html('&nbsp;');
          $("#psw").addClass('ok-input');
          $("#email").addClass('ok-input');
          $("#psw2").addClass('ok-input');
          $("#username").addClass('ok-input');

          res.html("Email di conferma inviata!. Non l'hai ricevuta? Clicca <a href='verify.html'>qui</a>!");

          // setTimeout(function(){
          //   window.location = "../login/?name="+username;
          // }, 500);
        }
      }
    );
  });
});
