<?php

class CepController
{
    public function buscar(): void
    {
        if (!isset($_SESSION['usuario_id'])) {
            http_response_code(401);
            echo json_encode([
                'erro' => 'Não autorizado.'
            ]);
            exit;
        }

        header('Content-Type: application/json; charset=utf-8');

        $cep = preg_replace('/\D/', '', $_GET['cep'] ?? '');

        if (strlen($cep) !== 8) {
            http_response_code(400);

            echo json_encode([
                'erro' => 'CEP inválido.'
            ]);

            exit;
        }

        $url = "https://viacep.com.br/ws/{$cep}/json/";

        $resposta = @file_get_contents($url);

        if ($resposta === false) {
            http_response_code(500);

            echo json_encode([
                'erro' => 'Não foi possível consultar o CEP.'
            ]);

            exit;
        }

        $dados = json_decode($resposta, true);

        if (!$dados || !empty($dados['erro'])) {
            http_response_code(404);

            echo json_encode([
                'erro' => 'CEP não encontrado.'
            ]);

            exit;
        }

        echo json_encode([
            'endereco' => trim(
                ($dados['logradouro'] ?? '') .
                ', ' .
                ($dados['bairro'] ?? '')
            )
        ]);
    }
}