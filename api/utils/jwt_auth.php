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
class JWT{


  static private function base64url_encode($string){
    return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($string));
  }

  static private function base64url_decode($string){
    $temp = str_replace( ['-', '_', ''], ['+', '/', '='], $string);
    return base64_decode($temp);
  }

  static public function salt_512(){
    return hash('sha512', uniqid(mt_rand(1, mt_getrandmax()), true));
  }

  static public function salt_md5($name){
    return hash('md5', $name.uniqid(mt_rand(1, mt_getrandmax()), true));
  }

  static public function getJWT($user_email, $key){
    // Header.Payload.Signature

    $header    = JWT::base64url_encode(JSON_encode(['typ' => 'JWT', 'alg' => 'HS256']));
    $payload   = JWT::base64url_encode(JSON_encode(['user_email' => $user_email]));
    $signature = JWT::base64url_encode(hash_hmac('sha256', $header . "." . $payload, $key . base64_encode($user_email) . getenv("JWT_T"), true));

    $JWT = $header . "." . $payload . "." . $signature;
    //echo $JWT;
    return $JWT;
  }

  static public function get_user_email($JWT_TOKEN){
    $JWT = explode(".", $JWT_TOKEN);
    return json_decode(JWT::base64url_decode($JWT[1]), true)['user_email'];
  }

  static private function token_validation($JWT_TOKEN){
    $JWT = explode(".", $JWT_TOKEN);
    if($JWT[0] == $JWT_TOKEN) return false;

    return true;
  }

  static public function checkJWT($JWT_TOKEN){
    require_once(__DIR__.'/../db/user_db.php');
    $JWT = explode(".", $JWT_TOKEN);

    if(!JWT::token_validation($JWT_TOKEN)) return false;

    $header = $JWT[0];
    $payload = $JWT[1];


    $user_email = JWT::get_user_email($JWT_TOKEN);

    $salt = get_user_data($user_email, "salt");

    $signature_correct = JWT::base64url_encode(hash_hmac('sha256', $header . "." . $payload, $salt . base64_encode($user_email) . getenv("JWT_T"), true));

    return $signature_correct == $JWT[2];
  }

}

?>
