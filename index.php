<?php

  require_once("config.php");

  // carrega um usuário
  // $user = new Usuario();
  // $user->loadById(3);
  // echo $user;

  // carrega lista de usuários
  // $lista = Usuario::getList();
  // echo json_encode($lista);

  // carrega uma lista de usuários buscando pelo login
  // $busca = Usuario::search("jo");
  // echo json_encode($busca);

  // carrega um usuário usando o login e a senha
  // $usuario = new Usuario();
  // $usuario->login("anderson", "123456");
  // echo $usuario;

  // insere novo usuário
  // $aluno = new Usuario("anderson", "123456");
  // $aluno->insert();
  // echo $aluno;

  // altera um usuário
  // $usuario = new Usuario();
  // $usuario->loadById(1);
  // $usuario->update("toor", "senhadoroot");
  // echo $usuario;

  // deleta um usuário
  $usuario = new Usuario();
  $usuario->loadById(1);
  $usuario->delete();
  echo $usuario;