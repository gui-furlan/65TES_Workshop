<?php 

use PHPUnit\Framework\TestCase;

require 'src/Usuario.php';
require 'src/ValidadorSenha.php';

class ValidadorSenhaTest extends TestCase {

    /**
     * Classe de TestCase.
     * Essa classe testa todos os métodos do utilitário ValidadorSenha.
     * Ao executar a classe, todos os testes serão executados.
     */

    /**
     * Aqui, forma implementados três tipos de assert: 
     * Exceções: expectException(), expectExceptionMessage().
     * Comparação: assertTrue.
     */

     public function testTemTamanhoMinimo() {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("A senha deve ter mais de 8 caracteres.");
        
        $usuario = new Usuario("usuario", "12/03/1990");
        $validador = new ValidadorSenha($usuario, "12345678");
        $validador->temTamanhoMinimo();
    }

    public function testTemLetrasENumeros() {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("A senha deve conter letras e números.");
        
        $usuario = new Usuario("usuario", "12/03/1990");
        $validador = new ValidadorSenha($usuario, "somenteletras");
        $validador->temLetrasENumeros();

        $validador = new ValidadorSenha($usuario, "1234567890");
        $validador->temLetrasENumeros();
    }

    public function testTemLetraMaiuscula() {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("A senha deve conter pelo menos uma letra maiúscula.");
        
        $usuario = new Usuario("usuario", "12/03/1990");
        $validador = new ValidadorSenha($usuario, "senha123");
        $validador->temLetraMaiuscula();
    }

    public function testTemCaractereEspecial() {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("A senha deve conter pelo menos um caractere especial (!, @, #, $, %, &, (, ), [, ], {, }, <, >).");
        
        $usuario = new Usuario("usuario", "12/03/1990");
        $validador = new ValidadorSenha($usuario, "Senha123");
        $validador->temCaractereEspecial();
    }

    public function testNaoContemUsername() {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("A senha não pode conter o nome de usuário.");
        
        $usuario = new Usuario("usuario", "12/03/1990");
        $validador = new ValidadorSenha($usuario, "usuario123@");
        $validador->naoContemUsername();
    }

    public function testNaoContemDataNascimento() {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("A senha não pode conter a data de nascimento.");
        
        $usuario = new Usuario("usuario", "12/03/1990");
        $validador = new ValidadorSenha($usuario, "12/03/1990@");
        $validador->naoContemDataNascimento();

        $validador = new ValidadorSenha($usuario, "12031990@");
        $validador->naoContemDataNascimento();
    }

    public function testValidaSenhaValida() {
        $usuario = new Usuario("usuario", "12/03/1990");
        $validador = new ValidadorSenha($usuario, "SenhaValida@123");
        $this->assertTrue($validador->validaSenha());
    }

    public function testValidaSenhaInvalida() {
        $this->expectException(Exception::class);
        
        $usuario = new Usuario("usuario", "12/03/1990");
        $validador = new ValidadorSenha($usuario, "senha123");
        $validador->validaSenha();
    }

    public function testContaCriteriosAtendidos() {
        $expected = 6;
        $usuario = new Usuario("usuario", "12/03/1990");
        $validador = new ValidadorSenha($usuario, "Senha@12345");

        $this->assertEquals($expected, $validador->contaCriteriosAtendidos(), "A senha atingiu $expected critérios.");
    }
}
