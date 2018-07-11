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
/*
* GET CHANNELS
*/

require_once(__DIR__.'/../db/channel_db.php');
require_once(__DIR__.'/../db/user_db.php');


header('Content-Type: application/json');


if(!val_req($_POST['JWT_token']) ||
   !val_req($_POST['channel_name']) ||
   !val_req($_POST['channel_username']) ||
   !val_req($_POST['username']) ||
   !isset($_POST['writable']))
   respond($R['missing-variables']);


$jwt = $_POST['JWT_token'];
$channel_name = $_POST['channel_name'];
$channel_username = $_POST['channel_username'];

$username = $_POST['username'];
$writable = $_POST['writable'];

if(JWT::checkJWT($jwt)){
  $user_email = JWT::get_user_email($jwt);
  if(exist_user($user_email) && exist_user($channel_username) && exist_user($username)){
    $user_id = get_user_data($user_email, "user_id");
    $new_user_id = get_user_data($username, "user_id");
    $channel_user_id = get_user_data($channel_username, "user_id");

    if(exist_channel($channel_name, $channel_user_id)){
      $channel_data = get_channel_data($channel_user_id, $channel_name);

      $channel_id = $channel_data['channel_id'];

      $new_account_type = get_user_data_id($new_user_id, "account_type");
      $user_account_type = get_user_data_id($user_id, "account_type");

      if($new_account_type == PRO_USER && $user_account_type == PRO_USER){
        //if($channel_data['private'] == PRIV_CHANNEL){


          if(canWriteToChannel($channel_id, $user_id) && !canWriteToChannel($channel_id, $new_user_id) && !canReadToChannel($channel_id, $new_user_id)){


            $writable = $writable == ONLY_READ ? ONLY_READ : CAN_WRITE;
            $token = JWT::salt_md5($username);

            insert_channel_token($channel_id, $new_user_id, $token, $writable);
            respond(R::ok());
          } else respond(["Type" => "User can alreay read/write to the channel!", "code" => 412]);

        //} else respond(false);
      } else respond($R['no-perm']);


    } else respond(["Type" => "Channel doesn't exist", "code" => 411]);

  } else respond($R['wrong-token']);
} else respond($R['wrong-token']);


?>
