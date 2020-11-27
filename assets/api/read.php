<?php
try{
        // Is very importan not connect to DB unless we have all prepare. 
    require_once(__DIR__.'/db.php');
    $q = $db->prepare('SELECT * FROM users');
    $q->execute();
    $aRows = $q->fetchAll();
    header('content-Type: application/json');
    echo $aRows[0]['name']; // FETCH_ASSOC
    // echo $aRows[0]->name; //  FETCH_OBJ
    // echo json_encode($aRows);
    exit();


}catch(PDOException $ex){
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


//##########################################################
//##########################################################
//##########################################################
//##########################################################
//##########################################################