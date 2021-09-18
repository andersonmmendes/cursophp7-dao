<?php
  class Usuario {
    private $idusuario;
    private $deslogin;
    private $dessenha;
    private $dtcadastro;

    public function getIdUsuario(){
      return $this->idusuario;
    }

    public function setIdUsuario($value){
      $this->idusuario = $value;
    }

    public function getDesLogin(){
      return $this->deslogin;
    }

    public function setDesLogin($value){
      $this->deslogin = $value;
    }

    public function getDesSenha(){
      return $this->dessenha;
    }

    public function setDesSenha($value){
      $this->dessenha = $value;
    }

    public function getDtCadastro(){
      return $this->dtcadastro;
    }

    public function setDtCadastro($value){
      $this->dtcadastro = $value;
    }

    public function loadById($id){
      $sql = new Sql();
      $results = $sql->select("select * from tb_usuarios where idusuario = :id", array(
        ":id" => $id
      ));

      if(count($results) > 0){
        $row = $results[0];
        $this->setIdUsuario($row["idusuario"]);
        $this->setDesLogin($row["deslogin"]);
        $this->setDesSenha($row["dessenha"]);
        $this->setDtCadastro(new DateTime($row["dtcadastro"]));
      }
    }

    public static function getList(){
      $sql = new Sql();

      return $sql->select("select * from tb_usuarios order by deslogin");
    }

    public static function search($login){
      $sql = new Sql();
      
      return $sql->select("select * from tb_usuarios where deslogin like :search order by deslogin", array(
        ":search" => "%". $login ."%"
      ));
    }

    public function login($usuario, $senha){
      $sql = new Sql();
      $results = $sql->select("select * from tb_usuarios where deslogin = :login and dessenha = :senha", array(
        ":login" => $usuario,
        ":senha" => $senha
      ));

      if(count($results) > 0){
        $row = $results[0];
        $this->setIdUsuario($row["idusuario"]);
        $this->setDesLogin($row["deslogin"]);
        $this->setDesSenha($row["dessenha"]);
        $this->setDtCadastro(new DateTime($row["dtcadastro"]));
      } else {
        throw new Exception("Login e/ou senha inválidos");
      }
    }

    public function __toString(){
      return json_encode(array(
        "idusuario" => $this->getIdUsuario(),
        "deslogin" => $this->getDesLogin(),
        "dessenha" => $this->getDesSenha(),
        "dtcadastro" => $this->getDtCadastro()->format("d/m/Y H:i:s")
      ));
    }
  }