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
require_once(__DIR__.'/../db/user_db.php');
require_once(__DIR__.'/../db/graph_db.php');
require_once(__DIR__.'/../db/channel_db.php');

header('Content-Type: application/json');




if(!@val_req($_POST['JWT_token']) ||
   !@val_req($_POST['channel_name']) ||
   !@val_req($_POST['username']) ||
   !@val_req($_POST['type_data']) ||
   !@val_req($_POST['name_graph']) ||
   !@val_req($_POST['type_graph']) ||
   !@val_req($_POST['from_time']) ||
   !@val_req($_POST['to_time']))
respond($R['missing-variables']);

$jwt = $_POST['JWT_token'];
$channel_name = $_POST['channel_name'];
$channel_username = $_POST['username'];
$name_graph = $_POST['name_graph'];
$type_data = $_POST['type_data'];
$type_graph = $_POST['type_graph'];
$to_time = $_POST['to_time'];
$from_time = $_POST['from_time'];

if(JWT::checkJWT($jwt)){
  $user_email = JWT::get_user_email($jwt);
  if(exist_user($user_email)){
    $user_id = get_user_data($user_email, "user_id");
    $channel_user_id = get_user_data($channel_username, "user_id");

    if(exist_channel($channel_name, $channel_user_id)){
      $channel_data = get_channel_data($channel_user_id, $channel_name);

      $channel_id = $channel_data['channel_id'];

      if(canWriteToChannel($channel_id, $user_id)){
        insert_graph($channel_id, $name_graph, $type_data, $type_graph, $from_time, $to_time);
        respond(R::ok());
      } else respond(false);
    } else respond(false);

  } else respond($R['wrong-token']);
} else respond($R['wrong-token']);

?>
