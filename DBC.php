<?
    class DBC
    {
        function DBConn()
        {
            //PDO API를 사용해 데이터베이스에 접속
            $servername = "localhost";

            $dbname = "rage0501";

            $user = "rage0501";

            $password = "ask970501!";

            try

            {

                $connect = new PDO("mysql:host=$servername;dbname=$dbname", $user, $password);

                $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            }

            catch(PDOException $ex)

            {

                echo "서버와의 연결 실패! : ".$ex->getMessage()."<br>";

            }
            
            return $connect;
        }

        
    }
?>
