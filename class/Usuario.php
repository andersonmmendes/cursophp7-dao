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
        $this->setData($results[0]);
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
        $this->setData($results[0]);
      } else {
        throw new Exception("Login e/ou senha inválidos");
      }
    }

    public function setData($data){
      $this->setIdUsuario($data["idusuario"]);
      $this->setDesLogin($data["deslogin"]);
      $this->setDesSenha($data["dessenha"]);
      $this->setDtCadastro(new DateTime($data["dtcadastro"]));
    }

    public function insert(){
      $sql = new Sql();

      $results = $sql->select("call sp_usuarios_insert(:login, :senha)", array(
        ":login" => $this->getDesLogin(),
        ":senha" => $this->getDesSenha()
      ));

      if(count($results) > 0){
        $this->setData($results[0]);
      }
    }

    public function update($login, $senha){
      $this->setDesLogin($login);
      $this->setDesSenha($senha);

      $sql = new Sql();
      $sql->execQuery("update tb_usuarios set deslogin = :login, dessenha = :senha where idusuario = :id", array(
        ":login" => $this->getDesLogin(),
        ":senha" => $this->getDesSenha(),
        ":id" => $this->getIdUsuario()
      ));
    }

    public function delete(){
      $sql = new Sql();

      $sql->execQuery("delete from tb_usuarios where idusuario = :id", array(
        ":id" => $this->getIdUsuario()
      ));

      $this->setIdUsuario(0);
      $this->setDesLogin("");
      $this->setDesSenha("");
      $this->setDtCadastro(new DateTime());
    }

    public function __construct($login = "", $senha = ""){
      $this->setDesLogin($login);
      $this->setDesSenha($senha);
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