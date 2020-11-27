<?php

$id = settype($_POST['id'], "intenger");

try{
        // Is very importan not connect to DB unless we have all prepare. 
    require_once(__DIR__.'/db.php');
    $query = $db->prepare('UPDATE users SET name="FULANITO HERROU" WHERE id=$id');
    $query->execute();
    if( $query->rowCount() == 0 ){
        sendError(500, 'user cannot be updated', __LINE__);
    }
   
        header('content-Type: application/json');
        echo '{"message":"user updated"}';

}catch(PDOException $ex){
    echo $ex;
    sendError(500, 'contact the system admin about error', __LINE__);
}

//##########################################################
//##########################################################
//##########################################################
//##########################################################
//##########################################################


    function sendError($iErrorCode, $sMessage, $iLine){
        http_response_code($iErrorCode);
        header('content-Type: application/json');
        echo '{"message":"'.$sMessage.'", "error":"'.$iLine.'"}';
        exit();
    }