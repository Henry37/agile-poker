<?php
    require("config/database.php");
    function get_room_info($roomId, $SERVER, $USER, $PASSWORD, $DATABASE, $TABLE){
        $conn = mysqli_connect($SERVER, $USER, $PASSWORD, $DATABASE);
        if (!$conn) {
            die('Could not connect: ' . mysqli_error());
        }
        $sql = "SELECT * FROM " . $TABLE ." WHERE id =" . $roomId;
        $result = mysqli_query($conn, $sql);
        echo(json_encode(mysqli_fetch_assoc($result)));
        mysqli_close($conn);
    }
?>