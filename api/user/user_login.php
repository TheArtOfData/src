<?php
// TheArtOfData
//    Copyright (C) 2018  by Anceschi Giovanni, Belmonte Luca, Boschini Matteo, Mechetti Luca, Monari Pietro, Scarfone Salvatore, Tardini Giovanni
//
//    Mail : theartofdat@gmail.com
//
//    This program is free software: you can redistribute it and/or modify
//    it under the terms of the GNU Affero General Public License as published
//    by the Free Software Foundation, either version 3 of the License, or
//    (at your option) any later version.
//
//    This program is distributed in the hope that it will be useful,
//    but WITHOUT ANY WARRANTY; without even the implied warranty of
//    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//    GNU Affero General Public License for more details.
//
//    You should have received a copy of the GNU Affero General Public License
//    along with this program.  If not, see <http://www.gnu.org/licenses/>.
require_once(__DIR__.'/../db/user_db.php');

header('Content-Type: application/json');

// trimm dei dati per eliminare gli spazi prima e dopo la stringa
$_POST["user_email"] = @trim($_POST["user_email"]);
$_POST["psw"] = @trim($_POST["psw"]);

// verifica che i dati siano veramente inseriti e non siano vuoti
if(!@val_req($_POST["psw"]) || !val_req($_POST["user_email"]) )
  respond($R['missing-variables']);
else {
  // elimino caratteri speciali
  $user_email = filter_var($_POST["user_email"], FILTER_SANITIZE_STRING);
  $psw = $_POST["psw"];


  // se l'utente esiste realmente continuo
  if(exist_user($user_email)){
    if(is_verified($user_email)){
      // verifico che non ci siano stati piu di 10 tentati login
      if(is_suspended($user_email))
        respond($R['user-sus']);
      // recupero psw e salt
      $correct_psw = get_user_data($user_email, "psw");
      $salt_key = get_user_data($user_email, "salt");
      // genero la psw inserita dall'utente
      $actual_psw = hash_hmac('sha512', $psw, $salt_key);
      // verifico che le psw coincidino
      if(hash_equals($correct_psw, $actual_psw)){
        $new_salt = JWT::salt_512();
        $new_psw = hash_hmac('sha512', $psw, $new_salt);
        $token = JWT::getJWT($user_email, $new_salt);
        $temp_array = ["Result" => "ok", "code" => 200, "JWT_token" => $token];

        $ip = $_SERVER['REMOTE_ADDR'];
        $time = time();
        // aggiorno last_ip e last_login_time
        set_user_data($user_email, "last_ip", $ip);
        set_user_data($user_email, "salt", $new_salt);
        set_user_data($user_email, "psw", $new_psw);


        set_user_data($user_email, "last_login_time", $time);
        // invio il token JWT del login
        //setcookie("JWT_LOGIN", $token, time() + 3600);
        respond($temp_array);
      } else {
        // inserisco sul DB che e stata inviata un tentato login errato
        insert_wrong_login($user_email);
        respond($R['user-no-exist']);
      }
    }else respond($R['not-verified']);
  } else respond($R['user-no-exist']);
}



?>
