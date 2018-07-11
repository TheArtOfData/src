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




if(!@val_req($_POST['JWT_token']) ||
   !@val_req($_POST['project_name']) ||
   !@val_req($_POST['project_username']) ||
   !@val_req($_POST['content']))
respond($R['missing-variables']);

$jwt = $_POST['JWT_token'];
$project_name = $_POST['project_name'];
$project_username = $_POST['project_username'];
$content = $_POST['content'];

if(JWT::checkJWT($jwt)){
  $user_email = JWT::get_user_email($jwt);
  if(exist_user($user_email) && exist_user($project_username)){
    $user_id = get_user_data($user_email, "user_id");
    $project_user_id = get_user_data($project_username, "user_id");

    if(exist_project($project_user_id, $project_name)){
      $project_data = get_project_data($project_user_id, $project_name);
      $project_id = $project_data['project_id'];

      insert_comment($project_id, $user_id, $content);
      respond(R::ok());
    } else respond(false);




  } else respond($R['wrong-token']);
} else respond($R['wrong-token']);

?>
