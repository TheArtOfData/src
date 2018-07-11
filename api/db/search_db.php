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

function search_users($data_query){
  $db = $GLOBALS['db'];

  $query = "SELECT username, email FROM users WHERE username LIKE ? OR email LIKE ?";

  $data_to_search = '%' . $data_query . '%';

  return $db->get_query_result($query, "ss", [$data_to_search, $data_to_search]);
}

function search_channels($data_query){
  $db = $GLOBALS['db'];

  $query = "SELECT channel_id, name, description, location, type_data FROM channels WHERE private = 0 AND (name LIKE ? OR description LIKE ? OR location LIKE ? OR type_data LIKE ?)";

  $data_to_search = '%' . $data_query . '%';

  return $db->get_query_result($query, "ssss", [$data_to_search, $data_to_search, $data_to_search, $data_to_search]);
}
?>
