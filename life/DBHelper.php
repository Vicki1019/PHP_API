<?php

    /**
     * 資料庫相關類別
     *
     * 包含所有與資料庫相關的功能
     */
    class DBHelper
    {
        /** @var string $host 資料庫主機名稱 */
        private $host  = 'localhost';
        /** @var string $user 使用者名稱 */
        private $user = 'root';
        /** @var string $password 密碼 */
        private $password = 'mysql1passwd';
        /** @var string $db 資料庫名稱 */
        private $db = 'life';
        /** @var object $connect 資料庫連線 */
        public $connect;
        /** @var mixed $result 資料庫變動後的結果 */
        public $result;

        /**
         * 建構子
         *
         * 連接資料庫並設定字符編碼，若連接錯誤會出現連接錯誤的訊息
         *
         * @return void
         */
        public function __construct()
        {
            $this->connect = new mysqli(
                $this->host,
                $this->user,
                $this->password,
                $this->db
            );
            mysqli_set_charset($this->connect, "utf8mb4");

            if ($this->connect->connect_error) {
                die("Connection failed: " . $this->connect->connect_error);
            }
        }

        // /**
        //  * 取得資料表中符合欄位的資料
        //  *
        //  * @var string $sql 查詢資料表中 id, name, content, time欄位的資料
        //  *
        //  * @return object
        //  */
        // public function getList()
        // {
        //     $sql = 'SELECT id, name, content, time FROM message_board';
        //     $result = mysqli_query($this->connect, $sql);

        //     return $result;
        // }

        /**
         * 新增帳號
         *
         * @param string $group_no 群組編號
         * @param string $name 暱稱
         * @param string $email 信箱
         * @param string $passwd 密碼
         *
         * @var string $sql 新增使用者到資料表中
         *
         * @return mixed
         */
        public function register($group_no, $name, $email, $passwd)
        {
            $sql = "INSERT INTO member_info(group_no, member_nickname, email, passwd)
                    VALUES ('$group_no', '$name', '$email', '$passwd')";
            // $sql = "INSERT INTO message_board(name, content) value('$name', '$content')";
            mysqli_query($this->connect, $sql);
            $result = $this->connect->affected_rows;
            if($result != 1){
                return false;
            }else{
                return $result;
            }
        }

        /**
         * 記錄群組
         *
         * @param string $group_no 群組碼
         * @param string $name 名稱
         *
         * @var string $sql 新增群組
         *
         * @return mixed
         */
        public function group($group_no, $name)
        {
            $sql = "INSERT INTO group_code(group_no, group_cn)
                    VALUES ('$group_no', '$name')";
            mysqli_query($this->connect, $sql);
            $result = $this->connect->affected_rows;
            if($result != 1){
                return false;
            }else{
                return $result;
            }
        }

        /**
         * 登入系統
         *
         * @param string $email 信箱
         * @param string $passwd 密碼
         *
         * @var string $sql 查找帳號
         *
         * @return mixed
         */
        public function login($email, $passwd)
        {
            $sql = "SELECT 'name', 'email' FROM member_info WHERE email='$email' AND passwd='$passwd'";
            mysqli_query($this->connect, $sql);
            $result = $this->connect->affected_rows;
            if($result != 1){
                return false;
            }else{
                return $result;
            }
        }

        /**
         * 信箱驗證是否重複
         *
         * @param string $email 信箱
         *
         * @var string $sql 查找帳號
         *
         * @return bool
         */
        public function emailCheck($email)
        {
            $sql = "SELECT 'email' FROM member_info WHERE email='$email'";
            mysqli_query($this->connect, $sql);
            $result = $this->connect->affected_rows;
            if($result != 0){
                return false;
            }else{
                return true;
            }
        }

        /**
         * 產生群組亂碼
         *
         * @param string $length 長度
         *
         * @var string $str 亂碼字典
         *
         * @return string $random_str
         */
        public function randomstr($length=5)
        {
            $str = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            $random_str = substr(str_shuffle($str), 0, $length);
            return $random_str;
        }

        /**
         * 檢查群組亂碼是否重複
         *
         * @param string $group_no 群組亂碼
         *
         * @var string $sql 查詢亂碼
         * @var mysqli_result|bool $result 查詢結果
         *
         * @return bool
         */
        public function randomstrCheck($group_no)
        {
            $sql =  "SELECT 'group_no' FROM member_info WHERE group_no='$group_no'";
            $result = mysqli_query($this->connect, $sql);
            if($result->num_rows > 0){
                return false;
            }else{
                return true;
            }
        }

        /**
         * 取得單位資料
         *
         * @var string $sql 查詢資料表中 unit_cn欄位的資料
         *
         * @return object
         */
        public function getunit()
        {
            $sql = 'SELECT unit_cn FROM unit_code';
            $result = mysqli_query($this->connect, $sql);

             return $result;
        }

        /**
         * 解構子
         *
         * 關閉資料庫
         *
         * @return void
         */
        public function __destruct()
        {
            $this->connect->close();
        }
    }
