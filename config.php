<?
    include "DBC.php";

    class userDAO extends DBC
    {
        public $id;
        public $pwd;
        public $name;
        public $email;
        public $phone_num;
        public $join_date;

        function obTest() 
        {
            echo "인스턴스 생성 성공! <br>";
            echo "입력 id = ".$this->id."<br>";
            echo "입력 pwd = ".$this->pwd."<br>";
        }

        function user_info()
        {
            $id = $this->id;

            $connect = $this->DBConn();
            
            try
            {
                $stmt = $connect->prepare("SELECT * from USERDATA where id = :id");
                $stmt->bindParam(":id",$id);
                $stmt->execute();
            }

            catch(PDOException $ex)
            {
                echo "오류 발생! : ".$ex->getMessage()."<br>";
                return 1;
            }

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            

            $connect = null;

            return $row;

        }

        function checkLogin()
        {
            $id = $this->id;
            
            $connect = $this->DBConn();

            try
            {
                $stmt = $connect->prepare("SELECT pwd from USERDATA where id = :id");
                $stmt->bindParam(":id",$id);
                $stmt->execute();
            }

            catch(PDOException $ex)
            {
                echo "오류 발생! : ".$ex->getMessage()."<br>";
                return 1;
            }

            $pwd = $stmt->fetchColumn();
        
            $connect = null;

            if(strcmp($pwd, $this->pwd) == 0)
            {
                //일치하는 아이디 있음 
                return 0;
            }
        
            else
            {
                //일치하는 아이디와 비밀번호 없음
                return 1;
            }
        }

        function signUpData()
        {
            $id = $this->id;
            $pwd = $this->pwd;
            $name = $this->name;
            $email = $this->email;
            $p_num = $this->phone_num;

            $connect = $this->DBConn();

            $stmt = $connect->prepare("INSERT INTO USERDATA(id, pwd, name, email, phone_num) values (:id, :pwd, :name, :email, :p_num)");
            
            $stmt->bindparam(":id",$id);
            $stmt->bindparam(":pwd",$pwd);
            $stmt->bindparam(":name",$name);
            $stmt->bindparam(":email",$email);
            $stmt->bindparam(":p_num",$p_num);
            
            try
            {
                $stmt->execute();
            }

            catch(PDOException $ex)
            {
                echo "오류 발생! : ".$ex->getMessage()."<br>";
                return 1;
            }

            $connect = null;
            return 0;
        }

        function idCheck()
        {
            
            $cid = $this->id;
            $cmp = '';
            $connect = $this->DBConn();

            $stmt = $connect->prepare("SELECT id from USERDATA where id = :id");
            $stmt->bindparam(":id", $cid);
            
            try
            {
            $stmt->execute();
            
            $cmp = $stmt->fetchColumn();
            }
            
            catch(PDOException $ex)
            {
                echo "오류 발생! : ".$ex->getMessage()."<br>";
            }
          
            if(strcmp($cmp,$cid) == 0)
            {
                return 0;
            }

            return 1;
            
        }
    }


    class itemDAO extends DBC
    {
        public $item_id;
        public $item_name;
        public $item_info;
        public $abv;
        public $brand;
        public $maker;
        public $origin;
        public $price;
        public $del_fee;
        public $img_adr;
    }


    class cartDAO extends DBC
    {
        public $cart_id;
        public $uid;
        public $item_id;
        public $item_name;
        public $price;
        public $del_fee;
        public $order_cnt;
        public $flag;

        function add_Cart()
        {
            $uid = $this->uid;
            $item_name = $this->item_name;
            $order_cnt = $this->order_cnt;
            
            $connect = $this->DBConn();
            
            try
            {
            $stmt = $connect->prepare("SELECT * from ITEM where item_name = :id");
            $stmt->bindValue(":id", $item_name);
            }

            catch(PDOException $ex)
            {
                echo "오류 발생! : ".$ex->getMessage()."<br>";
            }
            
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $img_adr = $row['img_adr'];
            $item_id = $row['item_id'];
            $price = $row['price'];
            $del_fee = $row['del_fee'];
            
            try
            {
            $stmt = $connect->prepare("INSERT INTO CART(uid,item_id,item_name,price,del_fee,order_cnt,img_adr) 
                values (:uid,:item_id,:item_name,:price,:del_fee,:order_cnt,:img_adr)");
            
            $stmt->bindValue(":uid", $uid);
            $stmt->bindValue(":item_id", $item_id);
            $stmt->bindValue(":item_name", $item_name);
            $stmt->bindValue(":price", $price);
            $stmt->bindValue(":del_fee", $del_fee);
            $stmt->bindValue(":order_cnt", $order_cnt);
            $stmt->bindValue(":img_adr", $img_adr);

            $stmt->execute();
            }

            catch(PDOException $ex)
            {
                echo "오류 발생! : ".$ex->getMessage()."<br>";
            }

            $connect = null;
        }

        function getCartData()
        {
            header('Content-Type: application/json; charset=UTF-8');

            $connect = $this->DBConn();
            $uid = $this->uid;
            
            try
            {
            $stmt = $connect->prepare("SELECT * FROM CART where uid = :uid");
            $stmt->bindParam(":uid",$uid);
            
            $stmt->execute();
            }

            catch(PDOException $ex)
            {
                echo "오류 발생! : ".$ex->getMessage()."<br>";
            }

            $cart = array();
            $row = $stmt->fetchAll(PDO::FETCH_NUM);

            $i = 0;

            while($i < count($row))
            {
                array_push($cart,
                    array
                    (
                        'uid' => $row[$i][1],
                        'item_id' => $row[$i][2],
                        'name' => $row[$i][3],
                        'price' => $row[$i][4],
                        'del_fee' => $row[$i][5],
                        'quantity' => $row[$i][6],
                        'flag' => $row[$i][7],
                        'image' => $row[$i][8]
                    )
                );
                $i++;
            }

            $connect = null;

            echo json_encode($cart);
        
        }
    }
?>