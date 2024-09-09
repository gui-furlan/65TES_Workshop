<?php

use PHPUnit\Framework\TestCase;

require "src/Usuario.php";

class UsuarioDBTest extends TestCase {

    private static $pdo = null;
    private $conn = null;

    public static function setUpBeforeClass(): void {
        $dsn      = 'pgsql:host=localhost;dbname=teste_dbunit_01';
        $user     = 'postgres';
        $password = 'password';

        if (self::$pdo === null) {
            self::$pdo = new PDO($dsn, $user, $password);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    public function testCriarTabelaLogTrocaSenha() {
        $usuario = Usuario::makeNewWithDB('usuario_test', '2000-01-01', self::$pdo);
        $usuario->criarTabelaLogTrocaSenha();

        $query = "SELECT * FROM information_schema.tables WHERE table_name = 'password_log'";
        $result = self::$pdo->query($query);
        $this->assertNotFalse($result->fetch(), 'A tabela password_log não foi criada corretamente.');
    }

    public function testInserirLogTrocaSenha() {
        $usuario = Usuario::makeNewWithDB('usuario_test', '2000-01-01', self::$pdo);
        $usuario->lancarLog();

        $query = "SELECT * FROM password_log WHERE username = 'usuario_test'";
        $result = self::$pdo->query($query);
        $log = $result->fetch();

        $this->assertNotFalse($log, 'O log de troca de senha não foi inserido corretamente.');
        $this->assertEquals('usuario_test', $log['username'], 'O username do log inserido está incorreto.');
    }
}