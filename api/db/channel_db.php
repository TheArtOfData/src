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
* /api/db/channel_db.php
* definizione gestione canali con DB
*/

require_once(__DIR__.'/main.php');

// OK
function insert_channel($user_id, $private, $name, $description, $location, $type_data){
  $db = $GLOBALS['db'];

  $name = filter_var($db->real_escape_string($name), FILTER_SANITIZE_STRING);
  $description = filter_var($db->real_escape_string($description), FILTER_SANITIZE_STRING);
  $location = filter_var($db->real_escape_string($location), FILTER_SANITIZE_STRING);
  $type_data = filter_var($db->real_escape_string($type_data), FILTER_SANITIZE_STRING);

  $actual_ip = $_SERVER['REMOTE_ADDR'];
  $actual_time = time();

  $query = "INSERT INTO channels (`user_id`, `private`, `name`, `description`, `location`, `type_data`) VALUES (?, ?, ?, ?, ?, ?)";

  $db->db_query($query, "iissss", array($user_id, $private, $name, $description, $location, $type_data));
}

// OK
function insert_channel_token($channel_id, $user_id, $channel_token, $writable){
  $db = $GLOBALS['db'];

  $query = "INSERT INTO channel_token (`channel_id`, `user_id`, `channel_token`, `writable`) VALUES (?, ?, ?, ?)";

  $db->db_query($query, "iisi", [$channel_id, $user_id, $channel_token, $writable]);
}

// OK
function get_channel_token($user_id, $channel_id){
  $db = $GLOBALS['db'];

  $result = $db->get_single_query_result("SELECT channel_token, writable FROM channel_token WHERE user_id = ? AND channel_id = ? LIMIT 1", "ii", array($user_id, $channel_id));
  return $result;
}

// MOD
function get_channels_user($user_id){
  $db = $GLOBALS['db'];

  $query_temp = "SELECT private, name, type_data, location, description FROM channels WHERE user_id = ?";

  return $db->get_query_result($query_temp, "i", [$user_id]);
}

// OK
function get_shared_channel($user_id){
  $db = $GLOBALS['db'];

  $query = "SELECT channel_id FROM channel_token WHERE user_id = ?";

  return $db->get_query_result($query, "i", [$user_id]);
}

// OK
function check_channel_token($token){
  $db = $GLOBALS['db'];
  $query = "SELECT channel_id, writable FROM channel_token WHERE channel_token = ? LIMIT 1";

  $result = $db->get_query_result($query, "s", [$token]);

  if(sizeof($result) > 0) return $result[0];
  return false;
}

// OK !!
function get_channel_data_id($channel_id){
  $db = $GLOBALS['db'];
  $query = "SELECT channel_id, user_id, name, description, location, type_data, private  FROM channels WHERE channel_id = ?  LIMIT 1";
  return $db->get_single_query_result($query, "i", [$channel_id]);
}

// OK
function get_channel_data($user_id, $channel_name){
  $db = $GLOBALS['db'];
  $query = "SELECT channel_id, name, description, location, type_data, private  FROM channels WHERE user_id = ? AND name = ? LIMIT 1";
  return $db->get_single_query_result($query, "is", [$user_id, $channel_name]);
}

// OK
function exist_channel($channel_name, $user_id){
  $db = $GLOBALS['db'];

  $channel_name = $db->real_escape_string($channel_name);
  $user_id = $db->real_escape_string($user_id);

  $query = "SELECT 1 FROM channels WHERE name = ? AND user_id = ?";

  $result = $db->get_query_result($query, "si", [$channel_name, $user_id]);

  if(sizeof($result) > 0) return true;
  return false;
}

// OK
function delete_channel($channel_id){
  $db = $GLOBALS['db'];

  $channel_id = $db->real_escape_string($channel_id);

  $query = "DELETE FROM channels WHERE channel_id = ?";

  $db->db_query($query, "i", [$channel_id]);

}

// ELIMINA TUTTI I TOKEN DI UN CANALE
function delete_channel_tokens($channel_id){
  $db = $GLOBALS['db'];
  $query = 'DELETE FROM channel_token WHERE channel_id = ?';
  $db->db_query($query, "i", [$channel_id]);
}

// ELIMINA IL TOKEN DI UN UTENTE DI UN SPECIFICO CANALE
function delete_single_channel_token($channel_id, $user_id){
  $db = $GLOBALS['db'];
  $query = 'DELETE FROM channel_token WHERE channel_id = ? AND user_id = ?';
  $db->db_query($query, "ii", [$channel_id, $user_id]);
}


// CONDIVISIONE DEI canali

// OK
function canReadToChannel($channel_id, $user_id){
  $db = $GLOBALS['db'];

  $query = "SELECT 1 FROM channel_token WHERE channel_id = ? AND user_id = ?";

  $result = $db->get_query_result($query, "ii", [$channel_id, $user_id]);

  if(sizeof($result) > 0) return true;
  else return false;
}

// OK
function canWriteToChannel($channel_id, $user_id){
  $db = $GLOBALS['db'];

  $query = "SELECT 1 FROM channel_token WHERE channel_id = ? AND user_id = ? AND writable = 1";

  $result = $db->get_query_result($query, "ii", [$channel_id, $user_id]);

  if(sizeof($result) > 0) return true;
  else return false;
}

//----------------//

function get_channel_data_by_name($user_id, $channel_name){
  $db = $GLOBALS['db'];
  $query = "SELECT * FROM channels WHERE user_id = ? AND name = ?";
  return $db->get_single_query_result($query, "is", [$user_id, $channel_name]);
}

function get_user_channel_token($user_id, $channel_id){
  $db = $GLOBALS['db'];
  $query = 'SELECT channel_token, writable FROM channel_token WHERE user_id = ? AND channel_id = ?';
  return $db->get_single_query_result($query, "ii", [$user_id, $channel_id]);
}



function get_channel_id_($token){
  $db = $GLOBALS['db'];
  $query = "SELECT channel_id FROM channel_token WHERE channel_token = ?";

  return $db->get_single_query_result($query, "s", [$token])['channel_id'];
}

function check_channel_token_writable($token){
  $db = $GLOBALS['db'];
  $query = "SELECT 1 FROM channel_token WHERE channel_token = ? AND writable = 1";

  $result = $db->get_query_result($query, "s", [$token]);

  if(sizeof($result) > 0) return true;
  return false;
}



?>
