
<?php

require_once __DIR__ . '/../config/db.php';

class Usuario
{
    private PDO $conn;

    public function __construct()
    {
        $this->conn = Database::getConnection();
    }

    public function buscarPorEmail($email)
    {
        $sql = "SELECT * FROM usuario WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':email' => $email]);

        return $stmt->fetch();
    }

    public function cadastrar(
        $nome,
        $email,
        $senha_hash,
        $perfil = 'vendedor',
        $ativo = 1
    ) {
        $sql = "INSERT INTO usuario (nome, email, senha, perfil, ativo)
                VALUES (:nome, :email, :senha, :perfil, :ativo)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':nome'   => $nome,
            ':email'  => $email,
            ':senha'  => $senha_hash,
            ':perfil' => $perfil,
            ':ativo'  => $ativo
        ]);
    }

    public function cadastrarCliente(
        string $nome,
        string $cpfCnpj,
        string $email,
        string $senhaHash
    ): bool {
        try {
            $this->conn->beginTransaction();

            // Cria a conta de acesso do cliente.
            $sql = "INSERT INTO usuario
                    (nome, email, senha, perfil, ativo)
                    VALUES (:nome, :email, :senha, 'cliente', 1)";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':nome'  => $nome,
                ':email' => $email,
                ':senha' => $senhaHash
            ]);

            // Cria o registro do cliente para associar às compras.
            $sql = "INSERT INTO cliente (nome, cpf_cnpj, email)
                    VALUES (:nome, :cpf_cnpj, :email)";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':nome'     => $nome,
                ':cpf_cnpj' => $cpfCnpj,
                ':email'    => $email
            ]);

            $clienteId = (int) $this->conn->lastInsertId();

            // Vincula o acesso ao cliente recém-criado.
            $sql = "INSERT INTO cliente_acesso
                    (cliente_id, email_login, senha_hash, ativo)
                    VALUES (:cliente_id, :email, :senha_hash, 1)";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':cliente_id' => $clienteId,
                ':email'      => $email,
                ':senha_hash' => $senhaHash
            ]);

            $this->conn->commit();

            return true;
        } catch (Throwable $e) {
            if ($this->conn->inTransaction()) {
                $this->conn->rollBack();
            }

            throw $e;
        }
    }
}