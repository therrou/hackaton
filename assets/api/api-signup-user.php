<?php

if( ! isset($_POST['name']) ){ sendError(400, 'missing name', __LINE__); }
if( ! isset($_POST['lastName']) ){ sendError(400, 'missing lastname', __LINE__);}
if( ! isset($_POST['username']) ){ sendError(400, 'missing username', __LINE__);}
if( ! isset($_POST['email']) ){ sendError(400, 'missing email', __LINE__);}
if( ! isset($_POST['password']) ){ sendError(400, 'missing password', __LINE__);}
if( ! isset($_POST['confirmedPassword']) ){ sendError(400, 'missing confirmPassword', __LINE__);}


if( strlen($_POST['name']) < 2 ){ sendError(400, 'name must be at least 2 characters', __LINE__);}
if( strlen($_POST['name']) > 20 ){ sendError(400, 'name cannot be longer than 5 characters', __LINE__);}
if( strlen($_POST['lastName']) < 2 ){sendError(400, 'lastName must be at least 2 characters', __LINE__);}
if( strlen($_POST['lastName']) > 20 ){ sendError(400, 'lastName cannot be longer than 5 characters', __LINE__);}
if( strlen($_POST['username']) < 2 ){ sendError(400, 'username must be at least 2 characters', __LINE__);}
if( strlen($_POST['username']) > 50 ){ sendError(400, 'username cannot be longer than 5 characters', __LINE__);}
if( ! filter_var( $_POST['email'], FILTER_VALIDATE_EMAIL ) ){ sendError(400, 'email is not valid', __LINE__);}
if( strlen($_POST['password']) < 6 ){ sendError(400, 'password must be at least 2 characters', __LINE__);}
if( strlen($_POST['password']) > 50 ){sendError(400, 'password cannot be longer than 5 characters', __LINE__);}
if( $_POST['password'] !=  $_POST['confirmedPassword'] ){  sendError(400, 'passwords do not match', __LINE__);
}



require_once( __DIR__.'db.php' );

try{
  $query = $db->prepare('SELECT * FROM users 
  WHERE sEmail = :email LIMIT 1');
  $query->bindValue(':email', $_POST['email']);
  $query->execute();
  $aRow = $query->fetch();
  if( $aRow ){ sendError(500, 'email already registered', __LINE__); }

  INSERT INTO users 
  VALUES ('NULL, :sName, :sLastName, :sEmail, :sPassword, :iUserType, :sVerificationCode, :iCreated, :bActive, :sUserName');
  $query->bindValue(':sName', $_POST['name']);
  $query->bindValue(':sLastName', $_POST['lastname']);
  $query->bindValue(':sEmail', $_POST['email']);
  $query->bindValue(':sPassword', password_hash($_POST['password'], PASSWORD_DEFAULT) );
  $query->bindValue(':iUserType', $_POST['user_type']);
  $query->bindValue(':sVerificationCode', uniqid());
  $query->bindValue(':iCreated', time() );
  $query->bindValue(':bActive', 0);
  $query->bindValue(':sUserName', $_POST['username']);

  $query->execute();
  
//   session_start();
//   $_SESSION['name'] = $_POST['name'];
//   $_SESSION['lastname'] = $_POST['lastname'];
//   $_SESSION['username'] = $_POST['username'];
//   $_SESSION['email'] = $_POST['email'];
  // http_response_code(200); // 201 created
  header('Content-Type: application/json');
  echo '{"id":'.$db->lastInsertId().'}';

}catch(Exception $ex){
//   echo $ex;
  sendError(500, 'system under maintainance', __LINE__);
}






// #############################################
function sendError($iResponseCode, $sMessage, $iLine){
  http_response_code($iResponseCode);
  header('Content-Type: application/json');
  echo '{"message":"'.$sMessage.'", "error":'.$iLine.'}';
  exit();
}




