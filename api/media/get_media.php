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

require_once(__DIR__."/../db/media_db.php");


//header('Content-Type: application/json');


if(!isset($_GET['token']))
 respond($R['missing-variables']);

$token = $_GET['token'];

$file_base64 = get_media_by_token($token);

if(is_null($file_base64)) return;



$pos = strpos($file_base64, ";");
$file_type = substr($file_base64, 6, $pos - 5);



switch ($file_type) {
  case 'image/png':
    header('Content-Type: image/png');
    break;
  case 'image/jpg':
    header('Content-Type: image/jpg');
    break;
  case 'image/jpeg':
    header('Content-Type: image/jpeg');
    break;
  default:
    header('Content-Type: image/jpeg');
}


$file_decode = base64_decode(explode("base64,", $file_base64)[1]);

echo $file_decode;
?>
