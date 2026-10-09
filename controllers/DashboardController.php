<?php
require_once __DIR__ . '/../models/dashboard.php';

class DashboardController
{
    public function index()
    { 
        $nome   = $_SESSION['nome']   ?? 'Usuário';
        $perfil = $_SESSION['perfil'] ?? 'vendedor';

        $model = new DashboardModel();

        $totalLivros    = $model->getTotalLivros();
        $totalClientes  = $model->getTotalClientes();
        $totalPedidos   = $model->getTotalPedidosMes();
        $faturamentoMes = $model->getFaturamentoMes();

        $estoque      = $model->getEstoqueResumo();
        $emEstoque    = $estoque['em_estoque'];
        $estoqueBaixo = $estoque['estoque_baixo'];
        $esgotados    = $estoque['esgotados'];

        $vendasMeses = $model->getVendasUltimosMeses();

        $maxVenda = 0;
        foreach ($vendasMeses as $v) {
            if ($v['total'] > $maxVenda) $maxVenda = $v['total'];
        }

        $pedidosRecentes = $model->getPedidosRecentes(5);

        require_once __DIR__ . '/../views/dashboard.php';
    }
}