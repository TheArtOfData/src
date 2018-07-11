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

  require_once(__DIR__."/main.php");

  // da rifare
  function create_project($user_id, $title, $img){
    $db = $GLOBALS['db'];

    $published = 0;
    $publish_time = "";
    $tags = "";

    $query = "INSERT INTO projects (`user_id`, `title`, `img`, `published`, `publish_time`, `tags`, `url`) VALUES (?,?,?,?,?,?,?)";
    $db->db_query($query, "isiisss", [$user_id, $title, $img, $published, $publish_time, $tags, ""]);


    $query = "SELECT project_id FROM projects WHERE user_id = ? AND title = ? LIMIT 1";
    $project_id = $db->get_single_query_result($query, "is", [$user_id, $title])['project_id'];

    $url = hash("crc32b", $project_id);
    $query = "UPDATE projects SET url = ? WHERE project_id = ?";
    $db->db_query($query, "si", [$url, $project_id]);

    return ["Url" => $url];
  }

  function delete_project($project_id){
    $db = $GLOBALS['db'];

    $query = "DELETE FROM projects WHERE project_id = ?";

    $db->db_query($query, "i", [$project_id]);
  }

  function get_user_projects($user_id){
    $db = $GLOBALS['db'];

    $query = "SELECT * FROM projects WHERE user_id = ?" ;

    return $db->get_query_result($query, "i", [$user_id]);
  }

  // da rifare
  function update_project($user_id,$title,$content,$tags,$img,$published){

    if($published==1)$time = time();
    else $time = "";

    $params = array($user_id,$title,$content,$tags,$img,$published,$time);
    $query = "UPDATE projects SET title=?, content=?, tags = ?, img = ?, published = ?, publish_time = ?  WHERE title = ? AND user_id = ?";
    $db->db_query($query,"ssssissi",$params);
  }

  function update_title($project_id, $title){
    $db = $GLOBALS['db'];

    $query = "UPDATE projects SET title = ? WHERE project_id = ?";
    $db->db_query($query, "si", [$title, $project_id]);
  }

  function update_front_image($project_id, $image_id){
    $db = $GLOBALS['db'];

    $query = "UPDATE projects SET img = ? WHERE project_id = ?";

    $db->db_query($query, "ii", [$image_id, $project_id]);
  }


  function exist_project($user_id, $title){
    $db = $GLOBALS['db'];

    $query = "SELECT 1 FROM projects WHERE title = ? AND user_id = ?";


    $result = $db->get_query_result($query, "si", [$title, $user_id]);

    if(sizeof($result) > 0) return true;
    return false;
  }

  function exist_project_by_url($url){
    $db = $GLOBALS['db'];

    $query = "SELECT 1 FROM projects WHERE url = ?";


    $result = $db->get_query_result($query, "s", [$url]);

    if(sizeof($result) > 0) return true;
    return false;
  }

  function get_project_data($user_id, $title){
    $db = $GLOBALS['db'];
    $query = "SELECT *  FROM projects WHERE user_id = ? AND title = ? LIMIT 1";
    return $db->get_single_query_result($query, "is", [$user_id, $title]);
  }

  function get_project_data_by_url($url){
    $db = $GLOBALS['db'];
    $query = "SELECT *  FROM projects WHERE url = ? LIMIT 1";
    return $db->get_single_query_result($query, "s", [$url]);
  }

  function get_last_n_projects($num){
    $db = $GLOBALS['db'];
    $query = "SELECT * FROM projects WHERE published = 1 ORDER BY project_id DESC LIMIT ?" ;
    return $db->get_query_result($query, "i", [$num]);
  }

  // ------
  // STEP FUNCTION
  // ------

  function add_step($project_id, $step_num){
    $db = $GLOBALS['db'];

    $query = "INSERT INTO `projects_steps` (`project_id`, `step_num`, `title`, `content`) VALUES (?, ?, '', '')";
    $db->db_query($query, "ii", [$project_id, $step_num]);
  }

  function exist_step($project_id, $step_num){
    $db = $GLOBALS['db'];

    $query = "SELECT 1 FROM projects_steps WHERE project_id = ? AND step_num = ?";


    $result = $db->get_query_result($query, "ii", [$project_id, $step_num]);

    if(sizeof($result) > 0) return true;
    return false;
  }

  function update_step($project_id, $step_num, $title, $content){
    $db = $GLOBALS['db'];

    $query = "UPDATE projects_steps SET title = ?, content = ? WHERE project_id = ? AND step_num = ?";
    $db->db_query($query, "ssii", [$title, $content, $project_id, $step_num]);
  }

  function get_project_steps($project_id){
    $db = $GLOBALS['db'];

    $query = "SELECT * FROM projects_steps WHERE project_id = ?";
    return $db->get_query_result($query, "i", [$project_id]);
  }

  function get_step_id($project_id, $step_num){
    $db = $GLOBALS['db'];

    $query = "SELECT step_id FROM projects_steps WHERE project_id = ? AND step_num = ?";
    return $db->get_single_query_result($query, "ii", [$project_id, $step_num])['step_id'];
  }

  function delete_step($step_id){
    $db = $GLOBALS['db'];

    $query = "DELETE FROM projects_steps WHERE step_id = ?";
    return $db->db_query($query, "i", [$step_id]);
  }

?>
