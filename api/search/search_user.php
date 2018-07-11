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
require_once(__DIR__."/../db/search_db.php");
require_once(__DIR__."/../db/channel_db.php");
require_once(__DIR__."/../db/user_db.php");

header('Content-Type: application/json');


$_POST['data_query'] = @trim($_POST['data_query']);

if(!val_req($_POST['data_query']))
  respond($R['missing-variables']);

$data_query = $_POST['data_query'];

$users_result = search_users($data_query);

$array = [];

foreach ($users_result as $key => $value){
  $temp = array("name" => $value['username'], "type" => "user", "url" => $value['username']);
  array_push($array, $temp);
}


respond($array);


?>
