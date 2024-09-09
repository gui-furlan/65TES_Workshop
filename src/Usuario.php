<?php

use PDO;

require "src/ValidadorSenha.php";

class Usuario {
 
    private $username;
    private $senha;
    private $dataNascimento;

    private PDO $pdo;

    public function __construct() {

    }

    public static function makeNew($username, $dataNascimento) {
        $usuario = new Usuario();
        $usuario->username = $username;
        $usuario->senha = "";
        $usuario->dataNascimento = $dataNascimento;
        return $usuario;
    }

    public static function makeNewWithDB($username, $dataNascimento, PDO $pdo) {
        $usuario = new Usuario();
        $usuario->username = $username;
        $usuario->senha = "";
        $usuario->dataNascimento = $dataNascimento;
        $usuario->pdo = $pdo;
        return $usuario;
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
            $this->lancarLog();
            return true;
        } else {
            return false;
        }
    }

    public function criarTabelaLogTrocaSenha() {
        $query = "
            CREATE TABLE IF NOT EXISTS password_log (
                id SERIAL PRIMARY KEY,
                username varchar(255),
                data_hora TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ";

        $this->pdo->query($query);
    }

    public function lancarLog() {
        $this->criarTabelaLogTrocaSenha();

        $query = "
            INSERT INTO password_log (username) VALUES ('$this->username');
        ";

        $this->pdo->query($query);
    }

}