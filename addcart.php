<?
    session_start();

    include "config.php";

    if(!isset($_SESSION['id']))
    {
        echo "<script>
        alert('로그인이 필요합니다!');
        window.close();
        </script>";
    }
    
    $arr = unserialize($_SESSION['ur']);
    
    $cd = new cartDAO();

    $cd->uid = $arr['uid'];
    $cd->item_name = $_GET['item_name'];
    $cd->order_cnt = $_GET['order_cnt'];

    $cd->add_Cart();
    
    echo "<script> alert('$cd->item_name $cd->order_cnt 개가 장바구니에 추가되었습니다.'); 
    window.close(); </script>";
    
?>