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

function insert_graph($channel_id, $name_graph, $type_data, $type_graph, $from_time, $to_time){
  $db = $GLOBALS['db'];

  // escape string for insert

  $channel_id = filter_var($db->real_escape_string($channel_id), FILTER_SANITIZE_STRING);
  $type_data = filter_var($db->real_escape_string($type_data), FILTER_SANITIZE_STRING);
  $type_graph = filter_var($db->real_escape_string($type_graph), FILTER_SANITIZE_STRING);
  $name_graph = filter_var($db->real_escape_string($name_graph), FILTER_SANITIZE_STRING);

  // query
  $query = "INSERT INTO graphs (`channel_id`, `graph_name`, `type_data`, `type_graph`, `from_time`, `to_time`) VALUES (?, ?, ?, ?, ?, ?)";


  $db->db_query($query, "isssss", [$channel_id, $name_graph, $type_data, $type_graph, $from_time, $to_time]);
}

function get_graphs($channel_id){
  $db = $GLOBALS['db'];

  $query_temp = "SELECT graph_id, graph_name, type_data, type_graph FROM graphs WHERE channel_id = ?";


  return $db->get_query_result($query_temp, "i", [$channel_id]);
}

function delete_all_graphs($channel_id){
  $db = $GLOBALS['db'];

  $query = "DELETE FROM graphs WHERE channel_id = ?";

  $db->db_query($query, "i", [$channel_id]);
}


?>
