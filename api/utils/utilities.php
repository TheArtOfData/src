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
require_once(__DIR__.'/respond.php');

define("ADDR", "https://theartofdata.tech/");

function respond($array){
  echo JSON_encode($array);
  die();
}

function val_req($x){
  if(isset($x) && !empty($x)) return true;
  return false;
}

// EMAIL ---------------------

function send_mail($to, $subject, $message){
  // Always set content-type when sending HTML email
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

  // More headers
  $headers .= 'From: <reset.service.ew@gmail.com>' . "\r\n";

  mail($to,$subject,$message,$headers);
}


// IMAGES ---------------------

function convertImage($originalImage, $outputImage, $quality)
{
    //s
    // // jpg, png, gif or bmp?
    // $exploded = explode('.',$originalImage);
    // $ext = $exploded[count($exploded) - 1];

    // if (preg_match('/jpg|jpeg/i',$ext))
    //     $imageTmp=imagecreatefromjpeg($originalImage);
    // else if (preg_match('/png/i',$ext))
    //     $imageTmp=imagecreatefrompng($originalImage);
    // else if (preg_match('/gif/i',$ext))
    //     $imageTmp=imagecreatefromgif($originalImage);
    // else if (preg_match('/bmp/i',$ext))
    //     $imageTmp=imagecreatefrombmp($originalImage);
    // else
    //     return 0;

    $imageTmp=imagecreatefrompng($originalImage);

    // quality is a value from 0 (worst) to 100 (best)
    imagejpeg($imageTmp, $outputImage, $quality);
    imagedestroy($imageTmp);

    return 1;
}


function get_file_base64($file){
  $imagetmp = file_get_contents($file['tmp_name']);

  $imgData = base64_encode($imagetmp);


  $src = 'data: '. $file["type"] . ';base64,' . $imgData;

  return $src;
}
?>
