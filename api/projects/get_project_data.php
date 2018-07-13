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



  if(!@val_req($_POST['url']))
   respond($R['missing-variables']);

  $url = trim($_POST['url']);




  if(exist_project_by_url($url)){
    $project_data = get_project_data_by_url($url);

    $can_see = false;

    if(isset($_POST['JWT_token'])){
      $jwt = $_POST['JWT_token'];

      if(JWT::checkJWT($jwt)){
        $user_email = JWT::get_user_email($jwt);
        if(exist_user($user_email)){
          $user_id = get_user_data($user_email,'user_id');

          if($project_data['published'] == 0 && $project_data['user_id'] == $user_id) $can_see = true;
        } else respond($R['wrong-token']);
      } else respond($R['wrong-token']);
    }

    if($project_data['published'] == 1 || $can_see){
      $token_img = get_media_token_by_id($project_data['img']);
      $project_data['img'] = $token_img;

      $user_id = $project_data['user_id'];
      $project_data['user_id'] = -1;


      $project_data['username'] = get_user_data_id($user_id, "username");

      $project_data['project_id'] = -1;

      respond($project_data);
    }else respond(false);



  } else respond(false);

?>
