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
require_once(__DIR__."/../db/channel_db.php");
require_once(__DIR__."/../db/data_db.php");

header('Content-Type: application/json');

$_GET['channel_token'] = @trim($_GET['channel_token']);
$_GET['values'] = @trim($_GET['values']);
$_GET['types'] = @trim($_GET['types']);

$_GET['time'] = @trim($_GET['time']);


if(!val_req($_GET['channel_token']) ||
   !isset($_GET['values']) || //value1,value2
   !val_req($_GET['types']))//type1,type2
   respond($R['missing-variables']);

$channel_token = $_GET['channel_token'];

$channel_token_data = check_channel_token($channel_token);


if(isset($_GET['time'])) $time = (int)$_GET['time'];


if($channel_token_data){
  $channel_id = $channel_token_data['channel_id'];
  $writalbe = $channel_token_data['writable'];

  if($writalbe){
    $channel_data = get_channel_data_id($channel_id);

    $values = explode(',', $_GET['values']);
    $types = explode(',', $_GET['types']);

    $type_saved = explode(',', $channel_data['type_data']);

    if(sizeof($values) != sizeof($types)) respond($R['wrong-data']);

    foreach ($values as $key => $value) {
      $bool_data_format = false;

      foreach ($type_saved as $type_key => $type_value) {

        $type = filter_var($types[$key], FILTER_SANITIZE_STRING);
        $type_value = filter_var($type_value, FILTER_SANITIZE_STRING);

        if($type == $type_value && is_numeric($value)){
          if(!$time) $time = time();

          insert_data($channel_id, $value, $type, $time);
          $bool_data_format = true;
        }
      }

      if(!$bool_data_format) respond($R['wrong-data']);
    }

    respond(R::ok());

  } else respond($R['wrong-channel-token']);
} else respond($R['wrong-channel-token']);



?>
