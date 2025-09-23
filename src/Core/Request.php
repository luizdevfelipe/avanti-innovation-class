<?php

namespace App\Core;

class Request
{
    /**
     * Obtém dados de entrada da requisição.
     * @param string|null $key O nome da chave a ser recuperada dos dados de entrada. Se nulo, retorna todos os dados de entrada.
     * @return mixed Retorna o valor associado à chave especificada ou todos os dados de entrada se a chave for nula.
     */    
    public function input(?string $key = null, mixed $default = null): mixed
    {
        $data = array_merge($_GET, $_POST);
        if ($key === null) {
            return $data;
        }
        return $data[$key] ?? $default;
    }  

    /**
     * Valida os dados de entrada com base nas regras fornecidas.
     * @param array $data Os dados de entrada a serem validados.
     * @param array $rules As regras de validação para cada campo.
     * @return array Retorna um array de mensagens de erro ou array vazio se não houverem erros.
     */
    public function validate(array $data, array $rules): array
    {
        foreach ($data as $field => $value) {
            if (isset($rules[$field])) {
                foreach ($rules[$field] as $rule) {
                    if ($rule === 'required' && ($value === null || $value === '')) {
                        $errors[] = "$field é obrigatório.";
                    }
                    if ($rule === 'string' && !is_string($value)) {
                        $errors[] = "$field deve ser uma palavra.";
                    }
                    if ($rule === 'string:null' && $value !== null && $value !== '' && !is_string($value)) {
                        $errors[] = "$field deve ser uma palavra ou vazio.";
                    }
                    if ($rule === 'float' && !is_numeric($value)) {
                        $errors[] = "$field deve ser um número decimal.";
                    }
                    if ($rule === 'float:null' && $value !== null && $value !== '' && !is_numeric($value)) {
                        $errors[] = "$field deve ser um número decimal ou vazio.";
                    }
                    if ($rule === 'integer' && (filter_var($value, FILTER_VALIDATE_INT) === false)) {
                        $errors[] = "$field deve ser um número inteiro.";
                    }
                    if ($rule === 'integer:null' && $value !== null && $value !== '' && (filter_var($value, FILTER_VALIDATE_INT) === false)) {
                        $errors[] = "$field deve ser um número inteiro ou vazio.";
                    }
                    if ($rule === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $errors[] = "$field deve ser um endereço de email válido.";
                    }
                }
            }
        }
        return $errors ?? [];
    }
}
