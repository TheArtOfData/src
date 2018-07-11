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
* /api/db/main.php
* definizione base DB
*/


require_once(__DIR__.'/../utils/jwt_auth.php');
require_once(__DIR__.'/../utils/utilities.php');

define('PRIV_CHANNEL', 1);
define('PUBL_CHANNEL', 0);

define('FREE_USER', 0);
define('PRO_USER', 1);

define('CAN_WRITE', 1);
define('ONLY_READ', 0);

class DB {
  //to fill
  private const SERVER_ADDR = '';
  private const DB_USER = '';
  private const DB_PSW = '';
  private const DB_NAME = '';

  protected $sql;
  private $stmt;

  public $tables = array(
    'users',
    'login_attempts',
    'channels',
    'data',
    'graphs',
    'channel_token',
    'data_types',
    'psw_reset',
    'projects',
    'comments',
    'media',
    'projects_steps'
  );

  public $tables_query = array(
    "`user_id` INT(8) UNSIGNED NOT NULL AUTO_INCREMENT, `username` VARCHAR(255) NOT NULL , `email` VARCHAR(255) NOT NULL , `psw` VARCHAR(255) NOT NULL , `salt` VARCHAR(255) NOT NULL , `account_type` INT(2) DEFAULT '0', `last_ip` VARCHAR(255) NOT NULL , `registration_time` VARCHAR(255) NOT NULL , `last_login_time` VARCHAR(255) NOT NULL ,`verified` tinyint(1) DEFAULT '0', PRIMARY KEY (`user_id`)",
    '`user_id` INT(8) NOT NULL , `login_time` INT(20) UNSIGNED NOT NULL , `ip` VARCHAR(255) NOT NULL',
    '`channel_id` INT(8) NOT NULL AUTO_INCREMENT , `private` tinyint(1) NOT NULL , `user_id` INT(8) NOT NULL , `name` VARCHAR(255) NOT NULL , `description` VARCHAR(1024) NOT NULL , `location` VARCHAR(255) NOT NULL , `type_data` VARCHAR(255) NOT NULL, PRIMARY KEY (`channel_id`)',
    '`data_id` INT(10) NOT NULL AUTO_INCREMENT , `channel_id` INT(10) NOT NULL , `value` FLOAT(10) NOT NULL , `type` VARCHAR(255) NOT NULL , `time` VARCHAR(255) NOT NULL , PRIMARY KEY (`data_id`)',
    '`graph_id` INT(10) NOT NULL AUTO_INCREMENT , `graph_name` VARCHAR(255) NOT NULL, `channel_id` INT(8) NOT NULL , `type_data` VARCHAR(255) NOT NULL , `type_graph` VARCHAR(255) NOT NULL , `from_time` VARCHAR(255) NOT NULL , `to_time` VARCHAR(255) NOT NULL , PRIMARY KEY (`graph_id`)',
    '`token_id` INT(15) NOT NULL AUTO_INCREMENT, `channel_id` int(8) NOT NULL, `user_id` int(8) NOT NULL, `channel_token` varchar(255) NOT NULL, `writable` tinyint(1) NOT NULL , PRIMARY KEY (`token_id`)',
    '`data_type_id` INT(10) NOT NULL AUTO_INCREMENT , `data_type` VARCHAR(255) NOT NULL , PRIMARY KEY (`data_type_id`)',
    '`user_id` INT(8) NOT NULL , `reset_time` VARCHAR(255) NOT NULL , `key` VARCHAR(255) NOT NULL',
    '`project_id` INT(10) NOT NULL AUTO_INCREMENT , `user_id` INT(10) NOT NULL , `title` VARCHAR(255) NOT NULL , `tags` VARCHAR(255) NOT NULL , `img` INT(10) NOT NULL , `published` TINYINT(1) NOT NULL  DEFAULT "0" ,`publish_time` VARCHAR(255) NOT NULL, `url` VARCHAR(255) NOT NULL, PRIMARY KEY (`project_id`)',
    '`comment_id` INT(10) NOT NULL AUTO_INCREMENT , `project_id` INT(10) NOT NULL , `user_id` INT(10) NOT NULL , `content` MEDIUMTEXT NOT NULL , `date` VARCHAR(255) NOT NULL , PRIMARY KEY (`comment_id`)',
    '`media_id` INT(10) NOT NULL AUTO_INCREMENT , `user_id` INT(10) NOT NULL , `content` MEDIUMTEXT NOT NULL , `step_id` INT(10) NOT NULL , `token` VARCHAR(255) NOT NULL, PRIMARY KEY (`media_id`)',
    '`step_id` INT(10) NOT NULL AUTO_INCREMENT , `project_id` INT(10) NOT NULL , `step_num` INT(5) NOT NULL , `title` VARCHAR(255) NOT NULL , `content` MEDIUMTEXT NOT NULL , PRIMARY KEY (`step_id`)'
  );


  function __construct(){
    $this->sql = @new mysqli(self::SERVER_ADDR, self::DB_USER, self::DB_PSW, self::DB_NAME); // connessione al DB
    if($this->sql->connect_error)
      respond([
        "Result" => "Error_db", "Type" => "Cannot access to the DB", "code" => 300
      ]);

    $this->__ini__();

  }

  private function get_sql(){
    return $this->sql;
  }

  private function __ini__(){
    foreach ($this->tables as $key => $value)
      if(!$this->exist_table($value)) $this->create_table($value, $this->tables_query[$key]);
  }

  public function query($q){
    $stmt = $this->sql->prepare($q);
    if($stmt === false)
      respond([
        "Result" => "Error_db", "Type" => "Error query: {$this->sql->error}", "code" => 301
      ]);
    $stmt->execute();

    return true;
  }

  public function create_table($name, $row){
    $name = $this->sql->real_escape_string($name);
    $query_temp = "CREATE TABLE {$name} ( {$row} )";

    $this->query($query_temp);
  }

  public function exist_table($name){
    $query_temp = "SELECT 1 FROM {$name}";
    if($this->sql->query($query_temp)) return true;
    return false;
  }

  public function real_escape_string($x){
    return $this->sql->real_escape_string($x);
  }

  private function prepare($query){
    $this->stmt = $this->sql->prepare($query);
    if($this->stmt === false)
      respond([
        "Result" => "Error_db", "Type" => "Error query: {$this->sql->error}, query: {$query}", "code" => 301
      ]);
  }

  private function bind_param($type, $params){
    $a_params = array();

    foreach ($params as $key => $value)
      $a_params[$key] = &$params[$key];

    call_user_func_array(array($this->stmt, 'bind_param'), array_merge(array($type), $a_params));
  }

  private function execute(){
    $this->stmt->execute();
  }

  public function db_query($query, $type, $params){
    $this->prepare($query);
    if($this->stmt === false)
      respond([
        "Result" => "Error_db", "Type" => "Error query: {$this->sql->error}, query: {$query}", "code" => 301
      ]);
    $this->bind_param($type, $params);
    $this->execute();
  }

  public function get_error(){
    return $this->sql->error;
  }

  public function get_query_result($query, $type, $params){
    $this->prepare($query);
    $this->bind_param($type, $params);
    $this->execute();

    $result_array = array();

    $res = $this->stmt->get_result();

    while($row = $res->fetch_array(MYSQLI_ASSOC))
      array_push($result_array, $row);


    return $result_array;

  }

  public function get_single_query_result($query, $type, $params){
    $temp = @$this->get_query_result($query, $type, $params)[0];
    if($temp) return $temp;
    return false;
  }


}

$GLOBALS['db'] = new DB();

?>
