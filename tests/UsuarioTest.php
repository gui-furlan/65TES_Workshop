<?php

use PHPUnit\Framework\TestCase;

require "src/Usuario.php";

class UsuarioTest extends TestCase {

    public function testSetSenhaValidaLancaLog() {
        $pdo = new PDO('pgsql:host=localhost;dbname=teste_dbunit_01', 'postgres', 'password');
        
        $usuario = Usuario::makeNewWithDB("usuario_test", "12/03/1990", $pdo);

        $usuario->criarTabelaLogTrocaSenha();

        $usuario->setSenha("SenhaValida@123");

        $query = "SELECT * FROM password_log WHERE username = 'usuario_test'";
        $result = $pdo->query($query);
        $log = $result->fetch();

        $this->assertNotFalse($log, "O log de troca de senha não foi inserido corretamente.");
        $this->assertEquals('usuario_test', $log['username'], "O username no log está incorreto.");
    }
}
