<?php

class ValidadorSenha {
    private String $senha;
    private Usuario $usuario;

    public function __construct($usuario, $senha) {
        $this->senha = $senha;
        $this->usuario = $usuario;
    }

    // Usados para expectException() e expectExceptionMessage();
    public function temTamanhoMinimo() {
        if (strlen($this->senha) <= 8) {
            throw new Exception("A senha deve ter no mínimo 8 caracteres.");
        }
        return true;
    }

    public function temLetrasENumeros() {
        if (!preg_match('/[A-Za-z]/', $this->senha) || !preg_match('/[0-9]/', $this->senha)) {
            throw new Exception("A senha deve conter letras e números.");
        }
        return true;
    }

    public function temLetraMaiuscula() {
        if (!preg_match('/[A-Z]/', $this->senha)) {
            throw new Exception("A senha deve conter pelo menos uma letra maiúscula.");
        }
        return true;
    }

    public function temCaractereEspecial() {
        if (!preg_match('/[!@#\$%\&\(\)\[\]\{\}<>\]]/', $this->senha)) {
            throw new Exception("A senha deve conter pelo menos um caractere especial (!, @, #, $, %, &, (, ), [, ], {, }, <, >).");
        }
        return true;
    }

    public function naoContemUsername() {
        if (stripos($this->senha, $this->usuario->getUsername()) !== false) {
            throw new Exception("A senha não pode conter o nome de usuário.");
        }
        return true;
    }

    public function naoContemDataNascimento() {
        $dataNascimentoLimpa = preg_replace('/[^0-9]/', '', $this->usuario->getDataNascimento());
        if (strpos($this->senha, $dataNascimentoLimpa) !== false) {
            throw new Exception("A senha não pode conter a data de nascimento.");
        }
        return true;
    }

    // Usado para assertTrue();
    public function validaSenha() {
        return $this->temTamanhoMinimo() &&
               $this->temLetrasENumeros() &&
               $this->temLetraMaiuscula() &&
               $this->temCaractereEspecial() &&
               $this->naoContemUsername() &&
               $this->naoContemDataNascimento();
    }

    // Usado para assertEquals().
    public function contaCriteriosAtendidos() {
        $criteriosAtendidos = 0;
    
        try {
            if ($this->temTamanhoMinimo()) {
                $criteriosAtendidos++;
            }
        } catch (Exception $e) {}
    
        try {
            if ($this->temLetrasENumeros()) {
                $criteriosAtendidos++;
            }
        } catch (Exception $e) {}
    
        try {
            if ($this->temLetraMaiuscula()) {
                $criteriosAtendidos++;
            }
        } catch (Exception $e) {}
    
        try {
            if ($this->temCaractereEspecial()) {
                $criteriosAtendidos++;
            }
        } catch (Exception $e) {}
    
        try {
            if ($this->naoContemUsername()) {
                $criteriosAtendidos++;
            }
        } catch (Exception $e) {}
    
        try {
            if ($this->naoContemDataNascimento()) {
                $criteriosAtendidos++;
            }
        } catch (Exception $e) {}
    
        return $criteriosAtendidos;
    }
}