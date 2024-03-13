<?php
    session_start();

    $flag = isset($_SESSION['ur']);
    if($flag)
    {
        $arr = unserialize($_SESSION['ur']);
        $s_uid = $arr['uid'];
        $s_id = $arr['id'];
        $s_name = $arr['name'];
        $s_email = $arr['email'];
        $s_phone_num = $arr['phone_num'];
    }
?>