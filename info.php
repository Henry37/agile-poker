<?php
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
    //init data
    $fileName = "points.json";
    $file = fopen($fileName, "r") or die("Unable to read such file");
    $jsonStr = fread($file, filesize($fileName));
    $jsonObj = json_decode($jsonStr);
    $jsonArr = json_to_array($jsonObj);
    fclose($file);

    //dispatcher
    if($_POST["method"] == "get"){

    }else if($_POST["method"] == "set"){
        $existName = FALSE;
        foreach($jsonArr["points"] as $name => $points){
            if($name == $_POST["name"]){
                $jsonArr["points"][$name] = $_POST["points"];
                $existName = TRUE;
            }
        }
        if(!$existName){
            if($jsonArr["online"] < 8){
                $jsonArr["points"][$_POST["name"]] = $_POST["points"];
                $jsonArr["online"] ++;
            }
        }
        $file = fopen($fileName, "w+") or die("Unable to read such file");
        $jsonStr = json_encode($jsonArr);
        fwrite($file, $jsonStr);
        fclose($file);
    }else if($_POST["method"] == "reset"){
        foreach($jsonArr as $key => $value){
            if($key == "points"){
                foreach($jsonArr["points"] as $name => $points){
                    $jsonArr["points"][$name] = "?";
                }
            }
        }
        $file = fopen($fileName, "w+") or die("Unable to read such file");
        $jsonStr = json_encode($jsonArr);
        fwrite($file, $jsonStr);
        fclose($file);
    }else if($_POST["method"] == "clear"){
        $jsonArr["points"] = [];
        $jsonArr["online"] = 0;
        $file = fopen($fileName, "w+") or die("Unable to read such file");
        $jsonStr = json_encode($jsonArr);
        fwrite($file, $jsonStr);
        fclose($file);
    }

    echo $jsonStr;

?>
