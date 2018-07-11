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
* /API/RESPOND.PHP
*
*  -- Definition errors --
*
*
* ERRORS:
* -------------------------
* 200 -> SUCCESS
* -------------------------
* 400 -> MISSING VARIABLES
* 401 -> WRONG EMAIL
* 402 -> USER ALREADY EXIST
* 403 -> USER DOESN'T EXIST
* -------------------------
* 300 -> ERROR DB CONNECTION
* 301 -> ERROR QUERY
*/

class R{
  static function ok(){
    return [
      "Result" => "ok", "code" => 200
    ];
  }
  static function error($name, $code){
    return [
      "result" => "Error", "Type" => $name, "code" => $code
    ];
  }
}

$R = [
  "wrong-email" => [
    "result" => "Error", "Type" => "Wrong Email", "code" => 401
  ],
  "missing-variables" => [
    "result" => "Error", "Type" => "Missing variables", "code" => 400
  ],
  "user-exist" => [
    "Result" => "Error", "Type" => "User already exists", "code" => 402
  ],
  "channel-exist" => [
    "Result" => "Error", "Type" => "channel already exists", "code" => 409
  ],
  "user-no-exist" => [
    "Result" => "Error", "Type" => "User-email o password errati!", "code" => 403
  ],
  "wrong-psw" => [
    "Result" => "Error", "Type" => "Wrong Password", "code" => 404
  ],
  "user-sus" => [
    "Result" => "Error", "Type" => "User suspended", "code" => 405
  ],
  "wrong-token" => [
    "Result" => "Error", "Type" => "User Unindentified", "code" => 406
  ],
  "wrong-channel-token" => [
    "Result" => "Error", "Type" => "Wrong Channel Token", "code" => 407
  ],
  "wrong-data" => [
    "Result" => "Error", "Type" => "Wrong data format", "code" => 408
  ],
  "no-perm" => [
    "Result" => "Error", "Type" => "Entrambi gli account devono essere PRO", "code" => 410
  ],
  "wrong-key" => [
    "Result" => "Error", "Type" => "Wrong Key", "code" => 409
  ],
  "not-verified" => [
    "Result" => "Error", "Type" => "User not verified", "code" => 411
  ],
  "existing-project" => [
    "Result" => "Error", "Type" => "Project name already existing on this account ", "code" => 412
  ],
  "db-conn" => [
    "Result" => "Error", "Type" => "Cannot access to the DB", "code" => 300
  ],
  "ok" => [
    "Result" => "ok", "code" => 200
  ]
];




?>
