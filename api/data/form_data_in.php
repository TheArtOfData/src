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
require_once(__DIR__."/../db/user_db.php");

header('Content-Type: application/json');

$_POST['JWT_token'] = @trim($_POST['JWT_token']);
$_POST['data'] = @trim($_POST['data']);
$_POST['type_data'] = @trim($_POST['type_data']);
$_POST['username'] = @trim($_POST['username']);
$_POST['channel_name'] = @trim($_POST['channel_name']);
$_POST['time'] = @trim($_POST['time']);

if(!val_req($_POST['JWT_token']) ||
   !val_req($_POST['data']) ||
	 !val_req($_POST['type_data'])||
	 !val_req($_POST['username'])||
	 !val_req($_POST['channel_name']))
	 respond($R['missing-variables']);

$JWT_token = $_POST['JWT_token'];
$data = $_POST['data'];
$type_data = $_POST['type_data'];
$username = $_POST['username'];
$channel_name = $_POST['channel_name'];
$time = $_POST['time'];

if(JWT::checkJWT($JWT_token)){
  $user_email = JWT::get_user_email($JWT_token);
  if(exist_user($user_email)){
		$user_id = get_user_data($user_email, "user_id");
    if(exist_channel($channel_name, $user_id)){
			$userx_id = get_all_user_data($username);
			$channel_data = get_channel_data($userx_id,$channel_name);
			$channel_id = $channel_data['channel_id'];

			$channel_token = get_channel_token($userx_id, $channel_id);
			$channel_token_data = check_channel_token($channel_token);

			$writable = $channel_token_data['writable'];

			if($writable){
				if(!$time)
					$time = time();
				insert_data($channel_id, $data, $type_data, $time);

			}

		} else respond($R["wrong-channel-token"]);
	} else respond($R["user-no-exist"]);
}else respond($R["wrong-token"]);
?>
