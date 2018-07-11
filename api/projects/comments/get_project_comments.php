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
require_once(__DIR__.'/../../db/user_db.php');
require_once(__DIR__.'/../../db/projects_db.php');
require_once(__DIR__.'/../../db/comments_db.php');


header('Content-Type: application/json');


if(!@val_req($_POST['project_name']) ||
   !@val_req($_POST['project_username']))
respond($R['missing-variables']);


$project_name = $_POST['project_name'];
$project_username = $_POST['project_username'];



if(exist_user($project_username)){
  $project_user_id = get_user_data($project_username, "user_id");

  if(exist_project($project_user_id, $project_name)){
    $project_data = get_project_data($project_user_id, $project_name);
    $project_id = $project_data['project_id'];

    $array = get_project_comments($project_id);

    $new_array = [];

    foreach ($array as $key => $value)
      array_push($new_array, ["username" => get_user_data_id($value["user_id"], "username"), "content" => $value['content'], "date" => $value['date']]);


    respond($new_array);
  } else respond(false);




} else respond($R['wrong-token']);


?>
