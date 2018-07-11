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
  require_once(__DIR__."/../db/media_db.php");

  header('Content-Type: application/json');


  if(!@val_req($_POST['JWT_token'])||
     !@val_req($_POST['url']) ||
     !@isset($_POST['step_num']) ||
     !@val_req($_POST['title']) ||
     !@val_req($_POST['content']))
   respond($R['missing-variables']);

  $jwt = $_POST['JWT_token'];
  $url = trim($_POST['url']);
  $step_num = trim($_POST['step_num']);
  $title = trim($_POST['title']);
  $content = trim($_POST['content']);

  if(JWT::checkJWT($jwt)){
    $user_email = JWT::get_user_email($jwt);
    if(exist_user($user_email)){
      $user_id = get_user_data($user_email,'user_id');

      if(exist_project_by_url($url)){
        $project_data = get_project_data_by_url($url);
        if($project_data['user_id'] == $user_id){
          $project_id = $project_data['project_id'];

          update_step($project_id, $step_num, $title, $content);

          respond(R::ok());
        } else respond(false);
      } else respond(false);

    } else respond($R['wrong-token']);
  } else respond($R['wrong-token']);

?>
