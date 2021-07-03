<?php
require_once './db_model.php';
$theDBA = new DatabaseAdaptor();
$arr = array();
$limit = 20;


if (isset($_GET['state']) && $_GET ['state'] == 'setup'){
    $logo = "    _______                 
  /\       \        _____  _   _  _____ _______    _  
 /()\   ()  \      |  __ \| \ | |/ ____|__   __|  | |
/    \_______\     | |__) |  \| | |  __   | |_   _| |__   ___  
\    /()     /     |  _  /| . ` | | |_ |  | | | | | '_ \ / _ \  
 \()/   ()  /      | | \ \| |\  | |__| |  | | |_| | |_) |  __/    
  \/_____()/       |_|  \_\_| \_|\_____|  |_|\__,_|_.__/ \___| ";
    $cnt = 9;
    $arr = $theDBA->getVideos($_GET['filter'],$limit);
    $cats = $theDBA->getVideoCategories();
    unset($_GET ['state']);
    echo  json_encode(array('categories'=>$cats, 'videoID'=>$arr[0]['videoID'], 'logo'=>$logo));

}

if (isset($_GET['state']) && $_GET['state'] == 'rolling'){

    if (empty($arr)){
        $arr = $theDBA->getVideos($_GET['filter'], $limit);
    
    }

    if (!empty($arr)){
        $record = $arr[0];
        $videoID = $record['videoID'];
        echo json_encode(array('videoID'=>$videoID, 'cnt'=>$cnt, 'arr'=>$arr));
       
    }
    unset($_GET['state']);
         
}


?>