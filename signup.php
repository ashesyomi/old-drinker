<?
    include "config.php";
    $flag = -1;
    $ud = new userDAO();

    $ud->id = $_POST['id'];
    $ud->pwd = $_POST['password'];
    $ud->name = $_POST['name'];
    $ud->email = $_POST['email'];
    $ud->phone_num = $_POST['p_num'];

    $flag = $ud->signUpData();

    if($flag == 0) 
    {
        echo "<script>
        alert('회원가입 성공!');
        window.location.href='login.html'; 
        </script>";
    }

    else
    {
        echo "<script>
        alert('오류 발생, 다시 시도해주세요.'); 
        window.location.href='sign.html'; 
        </script>";
    }
?>