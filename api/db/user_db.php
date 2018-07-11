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
* /api/db/user_db.php
* definizione gestione utente con DB
*/

require_once(__DIR__.'/main.php');


function exist_user($user_email){
  $db = $GLOBALS['db'];
  $user_email = $db->real_escape_string($user_email);

  $query = "SELECT 1 FROM users WHERE username = ? OR email = ?";


  $result = $db->get_query_result($query, "ss", [$user_email, $user_email]);

  if(sizeof($result) > 0) return true;
  return false;
}

function get_user_data_id($user_id, $data){
  $db = $GLOBALS['db'];
  $query = "SELECT {$data} FROM users WHERE user_id = ? LIMIT 1";


  return $db->get_single_query_result($query, "i", [$user_id])[$data];
}

function get_user_data($user_email, $data){
  $db = $GLOBALS['db'];
  $query = "SELECT {$data} FROM users WHERE email = ? OR username = ? LIMIT 1";


  return $db->get_single_query_result($query, "ss", [$user_email, $user_email])[$data];
}

function get_all_user_data($username){
  $db = $GLOBALS['db'];
  $query = "SELECT username, email, account_type, registration_time, last_login_time FROM users WHERE username = ? LIMIT 1";

  return $db->get_single_query_result($query, "s", [$username]);
}

function set_user_data($user_email, $col, $value){
  $db = $GLOBALS['db'];

  $query_temp = "UPDATE users SET {$col} = '{$value}' WHERE email = ? OR username = ?";

  $db->db_query($query_temp, "ss", [$user_email, $user_email]);
}
// SIGNUP
function insert_user($username, $email, $psw, $salt){
  $db = $GLOBALS['db'];

  // escape string for insert
  $username = filter_var($db->real_escape_string($username), FILTER_SANITIZE_STRING);
  $email = filter_var($db->real_escape_string($email), FILTER_SANITIZE_STRING);
  $psw = $db->real_escape_string($psw);

  $actual_ip = $_SERVER['REMOTE_ADDR'];
  $actual_time = time();

  // query
  $query = "INSERT INTO users (`username`, `email`, `psw`, `salt`, `account_type`, `last_ip`, `registration_time`, `last_login_time`) VALUES (?, ?, ?, '{$salt}', '0', '{$actual_ip}', '{$actual_time}', '{$actual_time}')";


  $db->db_query($query, "sss", [$username, $email, $psw]);
}
// LOGIN
function is_suspended($user_email){
  $db = $GLOBALS['db'];

  $id = get_user_data($user_email, "user_id");

  $time_back = time() - 60;

  $query_temp = "SELECT * FROM login_attempts WHERE user_id = ? AND login_time > '{$time_back}'";


  $result = $db->get_query_result($query_temp, "i", [$id]);

  if(sizeof($result) > 10) return true;
  return false;
}
// WRONG LOGIN
function insert_wrong_login($user_email){
  $db = $GLOBALS['db'];

  $id = get_user_data($user_email, "user_id");

  $ip = $_SERVER['REMOTE_ADDR'];
  $time = time();

  $query_temp = "INSERT INTO `login_attempts` (`user_id`, `login_time`, `ip`) VALUES (?, '{$time}', '{$ip}')";


  $db->db_query($query_temp, "s", [$id]);
}

//is verified



function is_verified($user_email){
  return get_user_data($user_email, 'verified');
}


function send_verification_email($email){
  //// TODO: swag
}

function verify($username){
  $db = $GLOBALS['db'];

  $query_temp = "UPDATE users SET verified = 1 WHERE  username = ?";

  $db->db_query($query_temp, "s", [$username]);
}

//REST psw , funzioni


function reset_id_exist($id){  //controllo se l'utente ha già richiesto un reset
  $db = $GLOBALS['db'];


  $query_temp = "SELECT 1 FROM psw_reset WHERE user_id = ?";
  $result = $db->get_query_result($query_temp, "s", [$id]);

  if(sizeof($result) > 0) return true;
    return false;
  }

function reset_key_exist($key){ //contollo se è presnte un chiave valida
  $db = $GLOBALS['db'];


  $query_temp = "SELECT 1 FROM `psw_reset` WHERE `key`= ? ";
  $result = $db->get_query_result($query_temp, "s", [$key]);

  if(sizeof($result) > 0) return true;
  return false;
}

function reset_psw($key,$value){ //eseguo il reset dell'utente identificato dll'id della chiave di reset
    $db = $GLOBALS['db'];



   $time=time();

   $query_temp = "SELECT * FROM `psw_reset` WHERE `key`= ?";
   $result = $db->get_query_result($query_temp, "s", [$key]);

   $time_r=$result[0]['reset_time'];
   $id = $result[0]['user_id'];

   if($time<$time_r+1800){   //il reset deve avvenire entro mezz'ora dalla avvenuta richiesta del link

     $salt_key = JWT::salt_512(); //generazione nuovo salt e criptaione della nuova psw
     $psw_hashed = hash_hmac('sha512', $value, $salt_key);


     $query_temp = "UPDATE users SET psw = ? , salt=  ? WHERE  user_id= ?"; //aggiornamento db dell'utente
     $result = $db->db_query($query_temp, "ssi", [$psw_hashed,$salt_key,$id]);


   }else
     respond([
       "Result" => "Time_expired", "Type" => "Time expired" . $sql->error, "code" => 777
     ]);
}


?>
