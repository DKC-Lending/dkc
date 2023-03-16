<?php
include 'connect.php';
class LoginHistory{
 
    function addLoginHistory($conn, $user){
       
        $device = mysqli_real_escape_string($conn, $_SERVER['HTTP_USER_AGENT'] );
        $qry = "INSERT INTO `loginhistory` (`username`, `device`) VALUES ('$user', '$device')";
        mysqli_query($conn,$qry);
    }

    function getLoginHistory($conn){
        $qry = "SELECT * FROM loginhistory order by id desc";
        $rslt= mysqli_query($conn,$qry);
        $res = [];
        while($data = mysqli_fetch_array($rslt,MYSQLI_ASSOC)){
            array_push($res,$data);
        }
        return $res;
    }

    function getLoginHistoryByUser($conn, $user){
        $qry = "SELECT * FROM loginhistory WHERE user = '$user'";
        $rslt= mysqli_query($conn,$qry);
        $res = [];
        while($data = mysqli_fetch_array($rslt,MYSQLI_ASSOC)){
            array_push($res,$data);
        }
        return $res;
    }

    function getLoginHistoryByGroup($conn){
        $output = [];
        $qry = "SELECT * FROM loginhistory ORDER by id desc";
        $rslt= mysqli_query($conn,$qry);
        while ($data = mysqli_fetch_array($rslt)) {
            $user = $data['username'];
            if(!isset($output[$user])){
                $output[$user] = [];
            }
            array_push($output[$user],$data);
        }

        return $output;

    }


}


?>