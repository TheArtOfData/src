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

/*
* /API/send_verification.php
*
*  -- SEND VIRIFCATION EMAIL --
* POST: USERNAME
*
*/

require_once(__DIR__.'/../db/user_db.php');

header('Content-Type: application/json');

$_POST["username"] = @trim($_POST["username"]);

if(!@val_req($_POST["username"]))
  respond($R['missing-variables']);

$username = $_POST["username"];
if(exist_user($username) && !is_verified($username)){
  $email = get_user_data($username, "email");
  $salt_key = get_user_data($username, "salt");

  $hashed_salt = hash('sha512', $salt_key);


  $file_welcome = file_get_contents(__DIR__."/welcome.html");
  $trigger = ["{{username}}", "{{action_url}}", "[Product Name]", "{{login_url}}", "[Company Name, LLC]"];


  $url_welcome = ADDR . 'api/user/verify.php?key=' . $hashed_salt . "&username=" . $username;

  $url_login = ADDR . 'login/';


  $to = "".$email."";
  $subject = "Benvenuto nel Portale #alloraspengo";



  $message = str_replace($trigger, [$username, $url_welcome, "#alloraspengo", $url_login, "Energy Way srl"],  $file_welcome);


  send_mail($to, $subject, $message);

  respond(R::ok());
} respond($R['user-no-exist']);

?>
