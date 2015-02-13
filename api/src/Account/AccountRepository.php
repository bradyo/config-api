<?php
namespace Api\Account;

use PDO;

class AccountRepository
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function findOne($id)
    {
        $stmt = $this->pdo->prepare('
          SELECT a.id, a.name FROM accounts a
          WHERE a.id = :id
          LIMIT 1
        ');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $rows = $stmt->fetchAll();
        if (count($rows) > 0) {
            $row = $rows[0];
            return new Account($row['id'], $row['name']);
        } else {
            return null;
        }
    }

    public function findAll($clientId, $search = null, $filter = null, $limit = 50, $offset = 0)
    {
        $limit = (int) $limit;
        if ($limit > 1000) {
            $limit = 1000;
        }

        $offset = (int) $offset;
        if ($offset < 0) {
            $offset = 0;
        }

        $stmt = $this->pdo->prepare('
          SELECT a.id, a.name FROM accounts a
          LEFT JOIN clients c ON c.account_id = a.id
          WHERE c.id = :client_id
          LIMIT :limit
          OFFSET :offset
        ');
        $stmt->bindParam(':client_id', $clientId);
        $stmt->bindParam(':limit', $limit);
        $stmt->bindParam(':offset', $offset);
        $stmt->execute();

        $accounts = [];
        $rows = $stmt->fetchAll();
        foreach ($rows as $row) {
            $accounts[] = new Account($row['id'], $row['name']);
        }
        return $accounts;
    }
}