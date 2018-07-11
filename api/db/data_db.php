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
require_once(__DIR__."/main.php");

function insert_data($channel_id, $value, $type, $time){
  $db = $GLOBALS['db'];

  $query_temp = "INSERT INTO `data` (`channel_id`, `value`, `type`, `time`) VALUES (?, ?, ?, ?)";

  $db->db_query($query_temp, "isss", [$channel_id, $value, $type, $time]);
}

function get_data($channel_id, $type, $from, $to){
  $db = $GLOBALS['db'];

  $query_temp = "SELECT data_id, value, time FROM data WHERE channel_id = ? AND type = ? AND time BETWEEN {$from} AND {$to} ORDER BY time ASC";

  return $db->get_query_result($query_temp, "is", [$channel_id, $type]);
}

function delete_data($channel_id){
  $db = $GLOBALS['db'];
  $channel_id = $db->real_escape_string($channel_id);

  $db->db_query($query, "i", [$channel_id]);
}

function get_data_types(){
  $db = $GLOBALS['db'];
  $query = "SELECT * FROM data_types";

  return @$db->get_query_result($query,"",[]);
}


function set_data_type($dt){
  $db = $GLOBALS['db'];
  $query = "INSERT INTO `data_types` (`data_type`) VALUES ('{$dt}')";

  if(!$db->query($query))
    respond("set-data-type-error");
}
?>
