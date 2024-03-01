<?php

require_once 'database.php';

class User{
    private $conn;

    // constructor
    public function __construct(){
        $database   = new Database();
        $db         = $database->dbConnection();
        $this->conn = $db;
    }

    // Execute queries SQL
    public function runQuery($sql){
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }

    // insert
    public function insert($name, $email) {
        try{
            $stmt = $this->conn->prepare("INSERT INTO crud_users (name, email) VALUES (:name, :email)");
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
            $stmt->execute();
            return $stmt;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    // update
    public function update($name, $email, $id){
        try{
            $stmt = $this->conn->prepare("UPDATE crud_users SET name = :name, email = :email WHERE id = :id");
            $stmt->bindParam(":name", $name);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    // delete
    public function delete($id){
        try{
            $stmt = $this->conn->prepare("DELETE FROM crud_users WHERE id = :id");
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt;
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }

    // redirect url method
    public function redirect($url){
        header("Location: $url");
    }
}
?>
