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

header('Content-Type: application/json');


// typedata -> type1,type2,type3


$_POST["name"] = @trim($_POST["name"]);
$_POST["description"] = @trim($_POST["description"]);
$_POST["location"] = @trim($_POST["location"]);
$_POST["JWT_token"] = @trim($_POST["JWT_token"]);
$_POST["type_data"] = @trim($_POST["type_data"]);

if(!@val_req($_POST["name"]) ||
   !val_req($_POST["JWT_token"]) ||
   !val_req($_POST["type_data"]) ||
   !isset($_POST["channel_type"])){
     respond(["result" => "error", "type" => "Missing variables" ]);
}

$JWT_token = $_POST["JWT_token"];

$name = $_POST["name"];
$description = $_POST["description"];
$location = $_POST["location"];
$type_data = $_POST["type_data"];
$channel_type = $_POST["channel_type"];

if(JWT::checkJWT($JWT_token)){
  $user_email = JWT::get_user_email($JWT_token);
  if(exist_user($user_email)){
    $user_id = get_user_data($user_email, "user_id");
    if(!exist_channel($name, $user_id)){
      if($channel_type == PRIV_CHANNEL || $channel_type == PUBL_CHANNEL){
        $account_type = get_user_data($user_email, "account_type");

        if($channel_type == PUBL_CHANNEL || ($channel_type == PRIV_CHANNEL && $account_type == PRO_USER)){
          insert_channel($user_id, $channel_type, $name, $description, $location, $type_data);

          $channel_id = get_channel_data($user_id, $name)['channel_id'];

          $user_token = JWT::salt_md5($user_id);

          insert_channel_token($channel_id, $user_id, $user_token, CAN_WRITE);

          respond(R::ok());
        } else respond($R['wrong-data']);


      } else respond($R['wrong-data']);



    } else respond($R['channel-exist']);

  } else
    respond($R['user-no-exist']);
} else
  respond($R['wrong-token']);


?>
