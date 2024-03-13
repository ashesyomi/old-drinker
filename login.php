
<?
    session_start();
    
    include 'config.php';

    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    $_SESSION['id'] = $_POST['id']; 
    $_SESSION['pwd'] = $_POST['password'];
    $_SESSION['type'] = $_POST['role'];
    
    $flag = -1;
    $_SESSION['typeId'] = 1; // typeId를 1로 초기화
    
    if(strcmp($_SESSION['type'], 'seller') == 0){ // 로그인 시 판매자로 체크했을 때
        $_SESSION['typeId'] = 0;
    }
    
    $ud = new userDAO();

    $ud->id = $_SESSION['id']; 
    $ud->pwd = $_SESSION['pwd'];

   
    //$ud->obTest();

    $flag = $ud->checkLogin();

    if($flag == 0) //로그인 성공
    {
        $arr = $ud->user_info();

        $_SESSION['ur'] = serialize($arr);
        $_SESSION['id'] = $ud->id;
         
        echo "<script>
        alert('로그인 성공!');
         window.location.href='home.html'; 
        </script>";
        
    }

    else //로그인 실패
    {
        echo "<script>
        alert('로그인 실패! 아이디와 비밀번호를 확인하세요.');
        window.location.href='login.html'; 
        </script>";

        session_unset();
        session_destroy();
    } 

?>