<?php
    require ("conn.php");
    function json_to_array($data){
        $arr = array();
        if(is_array($data) || is_object($data)){
            foreach($data as $key => $value){
                if(is_object($value)){
                    $arr[$key] = json_to_array($value);
                }else{
                    $arr[$key] = $value;
                }
            }
        }
        return $arr;
    }
    //dispatcher
    if($_POST["method"] == "get"){
        $roomId = $_POST["roomId"];
        echo(get_room_info($roomId));
    }else if($_POST["method"] == "set"){
        $roomId = $_POST["roomId"];
        $points = $_POST["points"];
        $name = $_POST["name"];
        set_room_info($roomId, $name, $points);
    }else if($_POST["method"] == "reset"){

    }else if($_POST["method"] == "clear"){

    }
?>