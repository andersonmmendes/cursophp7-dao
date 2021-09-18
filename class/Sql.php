<?php

  class Sql extends PDO {
    private $conn;

    public function __construct(){
      $this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "");
    }
    
    private function setParam($statement, $key, $value){
      $statement->bindValue($key, $value);
    }

    private function setParams($statement, $parameters = array()){
      foreach($parameters as $key => $value){
        $this->setParam($statement, $key, $value);
      }
    }

    public function execQuery($rawQuery, $params = array()){
      $stmt = $this->conn->prepare($rawQuery);
      
      $this->setParams($stmt, $params);

      $stmt->execute();

      return $stmt;
    }

    public function select($rawQuery, $params = array()):array {
      $stmt = $this->execQuery($rawQuery, $params);

      return $stmt->fetchAll(PDO::FETCH_ASSOC);          
    }
  }