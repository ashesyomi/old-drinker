<?
    
    include "config.php";
    
    $cid = $_GET['username'];

    $ud = new userDAO();

    $ud->id = $cid;
    
    $flag = $ud->idCheck();
    
    if($flag != 0)
    {
        echo "<span style='color:red;'>$cid</span> 는 사용 가능한 아이디입니다.";
        /*echo "<script>
        parent.cflag = true;
        </script>";*/
    }

    else{
        echo "<span style='color:red;'>$cid</span> 는 중복된 아이디입니다.";
    }           
?>