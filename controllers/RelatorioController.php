<?php

require_once __DIR__ . '/../models/relatorio.php';

class RelatorioController
{
    private Relatorio $relatorio;

    public function __construct()
    {
        $this->relatorio = new Relatorio();
    }

    public function index(): void
    {
        $this->check();

        $produtosMaisVendidos = $this->relatorio->produtosMaisVendidos();
        $fornecedores = $this->relatorio->fornecedores();
        $entradasRecentes = $this->relatorio->entradasRecentes();
        $estoqueBaixo = $this->relatorio->estoqueBaixo();

        require_once __DIR__ . '/../views/relatorio.php';
    }

    private function check(): void
    {
        if (!isset($_SESSION['usuario_id'])) {
            header("Location: index.php?controller=auth&action=form");
            exit;
        }
    }
}