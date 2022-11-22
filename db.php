<?php

class Database {
    public $host = "localhost:3306";
    public $user = "u0_a304";
    public $password = "";
    public $conn = null;

    public function __construct(){
        mysqli_report(MYSQLI_REPORT_OFF);
        
        $this->conn = new mysqli($this->host, $this->user, $this->password);

        if(mysqli_connect_error()){
            die("Unable to connect to database");
        }

        if(!$this->conn->select_db("tendering")){
            $this->create_db();
        }

    }

    private function create_db(){
        $db = $this->conn;

        $db->begin_transaction();

        try {
            $db->query("CREATE DATABASE tendering;");

            $db->select_db("tendering");
            
            $db->query("CREATE TABLE User (
                        user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(32) NOT NULL,
                        email VARCHAR(32) NOT NULL UNIQUE,
                        org VARCHAR(32),
                        gender VARCHAR(8) NOT NULL,
                        password VARCHAR(32) NOT NULL
                    );");


            $db->query("CREATE TABLE Seller (
                        seller_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        user_id INT UNSIGNED UNIQUE NOT NULL,
                        FOREIGN KEY (user_id) REFERENCES User(user_id)
                    );");


            $db->query("CREATE TABLE Buyer (
                        buyer_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        user_id INT UNSIGNED UNIQUE NOT NULL,
                        FOREIGN KEY (user_id) REFERENCES User(user_id)
                    );");

            $db->query("CREATE TABLE Tender (
                        tender_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        title VARCHAR(32) NOT NULL,
                        description VARCHAR(255),
                        payment VARCHAR(16),
                        seller_id INT UNSIGNED,
                        FOREIGN KEY (seller_id) REFERENCES Seller(seller_id)
                    );");

            $db->query("CREATE TABLE Contract (
                        cont_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        title VARCHAR(32),
                        description VARCHAR(255),
                        tender_id INT UNSIGNED,
                        buyer_id INT UNSIGNED,
                        FOREIGN KEY (tender_id) REFERENCES Tender(tender_id),
                        FOREIGN KEY (buyer_id) REFERENCES Buyer(buyer_id)
                    );");

            $db->commit();

        } catch (\Throwable $th) {
            $db->rollback();
            return true;
        }
    }
    public function error (){
        return mysqli_error($this->conn);
    }
    
    public function register($name, $email, $org, $gender, $password){
        $db = $this->conn;
        
        $sql = "INSERT INTO User (name, email, org, gender, password) VALUES (?,?,?,?,?);";
        $s = $db->prepare($sql);
        $password = md5($password);
        
        $s->bind_param("sssss", $name, $email, $org, $gender, $password);
        $result = $s->execute();
        return $result;
    }
    
    public function login($email, $password){
        $db = $this->conn;
        
        $sql = "SELECT * FROM User WHERE email = ? AND password = ?;";
        $sql = "SELECT * FROM User WHERE email = ? AND password = ?;";
        $s = $db->prepare($sql);
        $password = md5($password);
        
        $s->bind_param("ss", $email, $password);
        $s->execute();
        
        $result = $s->get_result();
        return $result->fetch_assoc();
    }
    
    public function add_seller($user_id){
        $db = $this->conn;
        
        $sql = "INSERT INTO Seller(user_id) VALUES (?);";
        $s = $db->prepare($sql);
        $s->bind_param("i", $user_id);
        return $s->execute ();
    }
    public function get_seller_by_user($user_id){
        $db = $this->conn;
        
        $sql = "SELECT seller_id , user_id FROM Seller WHERE user_id = ?;";
        $s = $db->prepare($sql);
        $s->bind_param("i", $user_id);
        $s->execute ();
        $result = $s->get_result();
        
        return $result->fetch_assoc();
    }
    public function add_buyer($user_id){
        $db = $this->conn;
        
        $sql = "INSERT INTO Buyer(user_id) VALUES (?);";
        $s = $db->prepare($sql);
        $s->bind_param("i", $user_id);
        return $s->execute ();
    }
    public function add_tender($title, $description, $payment, $seller_id){
        $db = $this->conn;
        
        $sql = "INSERT INTO Tender(title, description, payment, seller_id) VALUES (?,?,?,?);";
        $s = $db->prepare($sql);
        $s->bind_param("sssi", $title, $description, $payment, $seller_id);
        return $s->execute ();
    }
    public function add_contract($title, $description, $tender_id, $buyer_id){
        $db = $this->conn;
        
        $sql = "INSERT INTO Contract(title, description, tender_id, buyer_id) VALUES (?,?,?,?);";
        $s = $db->prepare($sql);
        $s->bind_param("ssii", $title, $description, $tender_id, $buyer_id);
        return $s->execute ();
    }
    public function list_tenders(){
        $db = $this->conn;
        
        $sql = "SELECT tender_id, title, description, payment FROM Tender;";
        $s = $db->prepare($sql);
        
        $s->execute ();
        return $s->get_result();
    }
    public function get_tender($id){
        $db = $this->conn;
        
        $sql = "SELECT tender_id, title, description, payment FROM Tender WHERE tender_id = ?;";
        $s = $db->prepare($sql);
        $s->bind_param("i", $id);
        $s->execute ();
        $result = $s->get_result();
        
        return $result->fetch_assoc();
    }
    public function insert_id(){
        return $this->conn->insert_id;
    }
}

?>