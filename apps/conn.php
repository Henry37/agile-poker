<?php
    require("config/database.php");
    function get_room_info($roomId){
        $conn = mysqli_connect($GLOBALS['SERVER'], $GLOBALS['USER'], $GLOBALS['PASSWORD'], $GLOBALS['DATABASE']);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }

        $sql = "SELECT * FROM room WHERE id = " . $roomId;

        $result = mysqli_query($conn, $sql);

        mysqli_close($conn);
        $output = array();
        while ($row = mysqli_fetch_assoc($result)){
            array_push($output, $row);
        }
        return json_encode($output);
    }
    function set_room_info($roomId, $member, $point){
        $conn = mysqli_connect($GLOBALS['SERVER'], $GLOBALS['USER'], $GLOBALS['PASSWORD'], $GLOBALS['DATABASE']);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $sql = "SELECT * FROM room WHERE id = " . $roomId . " AND member = '" . $member ."'";

        $result = mysqli_query($conn, $sql);
        if(mysqli_num_rows($result) == 0){
            $sql = "INSERT INTO `room` (`id`, `member`, `point`) VALUES (" . $roomId . ",'". $member ."','" . $point ."')";
        }else{
            $sql = "UPDATE `room` SET `point`= '" . $point . "' WHERE id = " . $roomId ." AND member = '" . $member ."'";
        }
        echo $sql;
        mysqli_query($conn, $sql);
        mysqli_close($conn);
    }

    function reset_room($roomId){

    }

?>