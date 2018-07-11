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

function insert_comment($project_id, $user_id, $content){
  $db = $GLOBALS['db'];

  // escape string for insert

  $content = filter_var($db->real_escape_string($content), FILTER_SANITIZE_STRING);


  // query
  $query = "INSERT INTO comments (`project_id`, `user_id`, `content`, `date`) VALUES (?, ?, ?, ?)";


  $db->db_query($query, "iiss", [$project_id, $user_id, $content, time()]);
}

function get_project_comments($project_id){
  $db = $GLOBALS['db'];


  // query
  $query = "SELECT * FROM comments WHERE project_id = ? ORDER BY date DESC";


  return $db->get_query_result($query, "i", [$project_id]);
}

?>
