<?php

class Database {
    public $host = "localhost:3306";
    public $user = "root";
    public $password = "";
    public $conn = null;

    public function __constructor(){
        $this->conn = new mysqli($this->host, $this->user, $this->password);

        if(mysqli_connect_error()){
            die("Unable to connect to database");
        }

        if(!$this->conn->select_db("tendering")){
            echo "Creating databse";
            $this->create_db();
        }

    }

    private function create_db(){
        $db = $this->conn;

        $db->begin_transaction();

        try {
            $db->query("CREATE DATABASE tendering;");

            $db->query("USE tendering;");
            $db->query("CREATE TABLE User (
                        user_id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                        name VARCHAR(32) NOT NULL,
                        email VARCHAR(32) NOT NULL UNIQUE,
                        org VARCHAR(32),
                        gender VARCHAR(8) NOT NULL,
                        password VARCHAR(16) NOT NULL
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
}
$db = new Database();

?>