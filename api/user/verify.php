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
require_once(__DIR__."/../db/user_db.php");

header('Content-Type: application/json');
//$_post["email"];
$_GET["key"] = @trim($_GET["key"]);
$_GET["username"] = @trim($_GET["username"]);


if(!val_req($_GET["key"]) ||
   !val_req($_GET["username"]))
  respond($R['missing-variables']);
else {

  $key = $_GET["key"];
  $username = $_GET["username"];

  if(exist_user($username) && !is_verified($username)){
    $salt = get_user_data($username, "salt");
    $hashed_salt = hash('sha512', $salt);

    if(hash_equals($hashed_salt, $key)){
      verify($username);
      header("location: /login/");
    } respond($R['wrong-key']);
  } respond($R['user-no-exist']);
}


?>
