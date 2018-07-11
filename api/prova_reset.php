<?php
require_once(__DIR__."/db/user_db.php");

header('Content-Type: application/json');

//$_post["email"];
$_GET["email"] = @trim($_GET["email"]);

if(!val_req($_GET["email"]) )
  respond($R['missing-variables']);
else {
  // elimino caratteri speciali
  $email = $_POST["email"];  // se l'utente esiste realmente continuo
  if(exist_user($email)){
      $salt_key = get_user_data($email, "salt");
      respond($R['user-no-exist']);
  } else respond($R['user-no-exist']);
}


?>
