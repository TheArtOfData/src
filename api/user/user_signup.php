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
* /API/USER_SIGNUP.php
*
*  -- SIGNUP USERS --
* POST: USERNAME, EMAIL, PSW
*
*/

require_once(__DIR__.'/../db/user_db.php');

header('Content-Type: application/json');

$_POST["username"] = @trim($_POST["username"]);
$_POST["email"] = @trim($_POST["email"]);
$_POST["psw"] = @trim($_POST["psw"]);

if(!val_req($_POST["username"]) ||
   !val_req($_POST["psw"]) ||
   !val_req($_POST["email"]) )
  respond($R['missing-variables']);
else {
  $username = $_POST["username"];
  $email = $_POST["email"];
  $psw = $_POST["psw"];


  if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    respond($R['wrong-email']);
  if(exist_user($username) || exist_user($email))
    respond($R['user-exist']);

  $salt_key = JWT::salt_512();
  $psw_hashed = hash_hmac('sha512', $psw, $salt_key);

  insert_user($username, $email, $psw_hashed, $salt_key);

  $hashed_salt = hash('sha512', $salt_key);


  $file_welcome = file_get_contents(__DIR__."/welcome.html");
  $trigger = ["{{username}}", "{{action_url}}", "[Product Name]", "{{login_url}}", "[Company Name, LLC]"];

  $username = get_user_data($email, "username");

  $url_welcome = ADDR . 'api/user/verify.php?key=' . $hashed_salt . "&username=" . $username;

  $url_login = ADDR . 'login/';


  $to = "".$email."";
  $subject = "Benvenuto nel Portale #alloraspengo";



  $message = str_replace($trigger, [$username, $url_welcome, "#alloraspengo", $url_login, "Energy Way srl"],  $file_welcome);



  send_mail($to, $subject, $message);

  respond(R::ok());
}
?>
