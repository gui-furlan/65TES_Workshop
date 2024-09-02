<?php

class Usuario {
 
    private $username;
    private $senha;
    private $dataNascimento;

    public function __construct($username, $dataNascimento) {
        $this->username = $username;
        $this->senha = "";
        $this->dataNascimento = $dataNascimento;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getDataNascimento() {
        return $this->dataNascimento;
    }

    public function setSenha($senha) {
        $validador = new ValidadorSenha($this, $senha);

        if ($validador->validaSenha() == true) {
            $this->senha = $senha;
        }

        // lança log de troca de senha
        // este é o teste do banco de dados.
    }

}