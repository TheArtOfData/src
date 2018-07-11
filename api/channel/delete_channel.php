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
require_once(__DIR__.'/../db/channel_db.php');
require_once(__DIR__.'/../db/user_db.php');
require_once(__DIR__.'/../db/data_db.php');
require_once(__DIR__.'/../db/graph_db.php');


header('Content-Type: application/json');


if(!val_req($_POST['channel_name']) ||
   !val_req($_POST['username']) ||
   !val_req($_POST['JWT_token']))
respond($R['missing-variables']);

$username = $_POST['username'];
$channel_name = $_POST['channel_name'];
$jwt = $_POST['JWT_token'];


if(JWT::checkJWT($jwt)){
  $user_email = JWT::get_user_email($jwt);
  if(exist_user($user_email) && exist_user($username)){
    $user_id_channel_creato = get_user_data($user_email, 'user_id');
    $user_id = get_user_data($username, 'user_id');

    if($user_id == $user_id_channel_creato){
      if(exist_channel($channel_name, $user_id)){
        $channel_data = get_channel_data($user_id, $channel_name);
        $channel_id = $channel_data['channel_id'];

        delete_channel($channel_id);
        delete_all_graphs($channel_id);
        delete_channel_tokens($channel_id);

        respond(R::ok());
      } else respond(false);
    } else respond($R['wrong-token']);
  } else respond($R['wrong-token']);
} else respond($R['wrong-token']);



?>
