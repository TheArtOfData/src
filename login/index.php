<!--  TheArtOfData
   Copyright (C) 2018  by Anceschi Giovanni, Belmonte Luca, Boschini Matteo, Mechetti Luca, Monari Pietro, Scarfone Salvatore, Tardini Giovanni

   Mail : theartofdat@gmail.com

   This program is free software: you can redistribute it and/or modify
   it under the terms of the GNU Affero General Public License as published
   by the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details.

   You should have received a copy of the GNU Affero General Public License
   along with this program.  If not, see <http://www.gnu.org/licenses/>. -->
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
  

    <meta charset="utf-8">
    <title></title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="../css/master.css">
    <link rel="stylesheet" href="../css/user_login_signup.css">


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  </head>

  <body>
    <div id="preload">
      <img src="../img/energy-way.png" alt="">
    </div>


    <div class="containe" style="">
      <div class="wrapper-login">
        <div class="login100-pic login-100-img" >
          <a href="/" target="_blank"><img class="js-tilt" src="../img/energy-way.png" alt="" data-tilt></a>
          <h3>The Art of Data</h3>
        </div>
        <div class="login100-pic">
          <h1>Login</h1>
          <form class="" id="user_login"><br>
            <input type="text" autocomplete="username" class="login-100-text" placeholder="Username o Email" id="user_email" value="<?php if(isset($_GET['name'])) echo $_GET['name']; ?>"><br>
            <input type="password" autocomplete="current-password" class="login-100-text"  placeholder="Password" id="psw" <?php if(isset($_GET['name'])) echo 'autofocus' ?>><br>
            <p id="form-result" class="text-center">&nbsp;</p>
            <input type="submit" class="form-control login-100-button center-block"  value="Invia"><br>
            <p class="text-center">oppure <a href="../signup">Registrati <span class="glyphicon glyphicon-chevron-right"></span></a></p>
            <a href="../reset" class="text-center">Password dimenticata? <span class="glyphicon glyphicon-chevron-right"></span></a>
            <a href="../signup/verify.html" class="text-center">Verifica il tuo account! <span class="glyphicon glyphicon-chevron-right"></span></a>

          </form>
        </div>
      </div>
    </div>


    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <script src="../js/tilt.jquery.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <script src="../js/main.js" charset="utf-8"></script>

    <script src="../js/user/login.js" charset="utf-8"></script>
    <script>
    $('.js-tilt').tilt({
      scale: 1.1
    })
    </script>
  </body>
</html>
