<?php
namespace Api\Account;

use Api\Common\Hash;
use PDO;

class AccountRepo
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function get($hash)
    {
        $stmt = $this->pdo->prepare('
          SELECT
            id,
            hash,
            name,
            contact_email_address
          FROM accounts
          WHERE hash = :hash
          LIMIT 1
        ');
        $stmt->execute([':hash' => $hash]);

        $rows = $stmt->fetchAll();
        if (count($rows) > 0) {
            $row = $rows[0];
            return new Account(
                $row['id'],
                $row['hash'],
                $row['name'],
                $row['contact_email_address']
            );
        } else {
            return null;
        }
    }

    public function save(NewAccount $newAccount)
    {
        $hash = new Hash();
        $stmt = $this->pdo->prepare('
            INSERT INTO accounts SET
              hash = :hash,
              name = :name,
              contact_email_address = :contact_email_address
        ');
        $stmt->execute([
            ':hash' => $hash,
            ':name' => $newAccount->getName(),
            ':contact_email_address' => $newAccount->getContactEmailAddress()
        ]);
        $id = $this->pdo->lastInsertId();

        return new Account(
            $id,
            $hash,
            $newAccount->getName(),
            $newAccount->getContactEmailAddress()
        );
    }

    public function find(AccountsQuery $query)
    {
        list ($where, $params) = $this->processQuery($query);
        $stmt = $this->pdo->prepare('
          SELECT
            a.id,
            a.hash,
            a.name,
            a.contact_email_address
          JOIN clients c ON c.account_id = a.id
          FROM accounts a
          WHERE ' . $where . '
          LIMIT ' . $query->getLimit() . '
          OFFSET ' . $query->getOffset() . '
        ');
        $stmt->execute($params);

        $rows = $stmt->fetchAll();
        $accounts = [];
        foreach ($rows as $row) {
            $accounts[] = new Account(
                $row['id'],
                $row['hash'],
                $row['name'],
                $row['contact_email_address']
            );
        }
        return $accounts;
    }

    public function count(AccountsQuery $query)
    {
        list ($where, $params) = $this->processQuery($query);
        $stmt = $this->pdo->prepare('
          SELECT COUNT(1)
          FROM accounts a
          JOIN clients c ON c.account_id = a.id
          FROM accounts a
          WHERE ' . $where . '
          GROUP BY a.id
        ');
        $stmt->execute($params);

        return $stmt->fetchColumn();
    }

    private function getWheres(AccountsQuery $query)
    {
        $params = [
            ':client_id' => $query->getClientId()
        ];
        $where = 'c.id = :client_id';
        if (! empty($query->getSearch())) {
            $where .= ' AND (a.name LIKE :search1 OR a.contact_email_address LIKE :search2)';
            $params[':search1'] = '%' . $query->getSearch() . '%';
            $params[':search2'] = '%' . $query->getSearch() . '%';
        }
        return [$where, $params];
    }
}