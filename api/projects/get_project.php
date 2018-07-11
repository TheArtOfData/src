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
require_once(__DIR__."/../db/projects_db.php");
require_once(__DIR__."/../db/user_db.php");


header('Content-Type: application/json');


if(!@val_req($_POST['username'])||
 !@val_req($_POST['title']))
 respond($R['missing-variables']);

$username = $_POST['username'];
$title = trim($_POST['title']);



if(exist_user($username)){
  $user_id = get_user_data($username,'user_id');
  if(exist_project($user_id, $title)){
    $data = get_project_data($user_id, $title);

    if($data['published'] === 1) {
      respond($data);
    }
  } else respond(false);
} else respond($R['wrong-token']);




?>
