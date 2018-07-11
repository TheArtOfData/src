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



  function add_media($user_id, $content, $step_id){
    $db = $GLOBALS['db'];

    $random_token = (string)JWT::salt_md5($user_id.$step_id);

    $query = "INSERT INTO `media` (`user_id`, `content`, `step_id`, `token`) VALUES (?,?,?,?)";

    $db->db_query($query, "isis", [$user_id, $content, $step_id, $random_token]);

    $query2 = "SELECT media_id FROM media WHERE token = ? LIMIT 1";
    return $db->get_single_query_result($query2, "s", [$random_token])["media_id"];
  }

  function get_media_by_token($token){
    $db = $GLOBALS['db'];
    $query = "SELECT content FROM media WHERE token = ? LIMIT 1";


    return $db->get_single_query_result($query, "s", [$token])["content"];
  }

  function get_media_by_id($media_id){
    $db = $GLOBALS['db'];
    $query = "SELECT content FROM media WHERE media_id = ? LIMIT 1";


    return $db->get_single_query_result($query, "i", [$media_id])["content"];
  }

  function get_media_token_by_id($media_id){
    $db = $GLOBALS['db'];
    $query = "SELECT token FROM media WHERE media_id = ? LIMIT 1";


    return $db->get_single_query_result($query, "i", [$media_id])["token"];
  }

  function get_media_by_step_id($step_id){
    $db = $GLOBALS['db'];
    $query = "SELECT content, token FROM media WHERE step_id = ?";


    return $db->get_query_result($query, "i", [$step_id]);
  }

  function get_media_token_by_step_id($step_id){
    $db = $GLOBALS['db'];
    $query = "SELECT token FROM media WHERE step_id = ?";


    return $db->get_query_result($query, "i", [$step_id]);
  }

  function delete_media_by_token($token){
    $db = $GLOBALS['db'];
    $query = "DELETE FROM media WHERE token = ?";

    $db->db_query($query, "s", [$token]);
  }
?>
