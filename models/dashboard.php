<?php
class DashboardModel {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getTotalLivros() {
        return $this->db->query("SELECT COUNT(*) FROM produto WHERE ativo = 1")->fetchColumn();
    }

    public function getTotalClientes() {
        return $this->db->query("SELECT COUNT(*) FROM cliente")->fetchColumn();
    }

    public function getTotalPedidosMes() {
        return $this->db->query("
            SELECT COUNT(*) FROM venda 
            WHERE MONTH(data) = MONTH(CURDATE()) AND YEAR(data) = YEAR(CURDATE())
        ")->fetchColumn();
    }

    public function getFaturamentoMes() {
        return $this->db->query("
            SELECT COALESCE(SUM(valor_total), 0) FROM venda 
            WHERE MONTH(data) = MONTH(CURDATE()) AND YEAR(data) = YEAR(CURDATE())
        ")->fetchColumn();
    }

    public function getEstoqueResumo() {
        return [
            'em_estoque'    => $this->db->query("SELECT COALESCE(SUM(quantidade_estoque), 0) FROM livro")->fetchColumn(),
            'estoque_baixo' => $this->db->query("SELECT COUNT(*) FROM livro WHERE quantidade_estoque < 5")->fetchColumn(),
            'esgotados'     => $this->db->query("SELECT COUNT(*) FROM livro WHERE quantidade_estoque = 0")->fetchColumn(),
        ];
    }

    public function getVendasUltimosMeses() {
        return $this->db->query("
            SELECT DATE_FORMAT(data, '%b') AS mes, COALESCE(SUM(valor_total), 0) AS total
            FROM venda
            WHERE data >= DATE_SUB(CURDATE(), INTERVAL 6 MONTH)
            GROUP BY YEAR(data), MONTH(data)
            ORDER BY YEAR(data), MONTH(data)
        ")->fetchAll();
    }

    public function getPedidosRecentes($limite = 5) {
        $stmt = $this->db->prepare("
            SELECT v.id_venda, c.nome AS cliente, v.data, v.valor_total
            FROM venda v
            JOIN cliente c ON c.id = v.cliente_id
            ORDER BY v.data DESC
            LIMIT :limite
        ");
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}