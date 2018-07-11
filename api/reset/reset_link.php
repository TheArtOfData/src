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
require_once(__DIR__."/../db/user_db.php");

header('Content-Type: application/json');


$_POST["email"] = @trim($_POST["email"]);

if(!val_req($_POST["email"]) )
  respond($R['missing-variables']);
else {
  // elimino caratteri speciali
  $email = $_POST["email"];  // se l'utente esiste realmente continuo
  if(exist_user($email)){
    $db = $GLOBALS['db'];
    $time = time();
    $key = JWT::salt_512();

    $id = get_user_data($email, "user_id");

    if(!reset_id_exist($id)){

      $query_temp = "INSERT INTO `psw_reset` (`user_id`, `reset_time`, `key`) VALUES (?, ?, ?)";

      $db->db_query($query_temp, "iss", [$id,$time,$key]);

    } else {
      $query_temp = "UPDATE `psw_reset` SET `reset_time`=?,`key`=? WHERE `user_id`=?";

      $db->db_query($query_temp, "ssi", [$time,$key,$id]);
    }


    $file_reset = file_get_contents(__DIR__."/password_reset_it.html");
    $trigger = ["{{name}}", "{{action_url}}", "[Product Name]"];

    $url_reset = ADDR . 'reset/reset_page.php?key=' . $key;




    $to = "".$email."";
    $subject = "Portale #alloraspengo reset Password";

    $username = get_user_data($email, "username");

    $message = str_replace($trigger, [$username, $url_reset, "#alloraspengo"], $file_reset);


    send_mail($to, $subject, $message);

    respond($R['ok']);
  } else respond($R['wrong-email']);
}

?>
