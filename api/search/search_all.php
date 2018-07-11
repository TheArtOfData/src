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
$channels_result = search_channels($data_query);

//$result = array("users" => $users_result, "channels" => $channels_result);

$array = [];


foreach ($users_result as $key => $value){
  $temp = array("name" => $value['username'], "type" => "user", "url" => $value['username']);
  array_push($array, $temp);
}

foreach ($channels_result as $key => $value){
  $user_id = get_channel_data_id($value['channel_id'])['user_id'];

  $channel_username = get_user_data_id($user_id, 'username');

  $temp = array("name" => $value['name'], "type" => "channel", "url" => $channel_username . '/' . $value['name'], "type_data" => $value['type_data'], "location" => $value['location'], "description" => $value["description"]);
  array_push($array, $temp);
}

$result = array_merge($users_result, $channels_result);

respond($array);


?>
