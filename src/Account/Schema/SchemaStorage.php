<?php
namespace Api\Schema;

use Api\Common\Id;
use Api\Common\PdoStorage;
use Api\Common\Time;
use PDO;

class SchemaStorage
{
    use PdoStorage;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function save(SchemaData $schemaData)
    {
        $this->transactional(function() use ($schemaData) {
            $id = new Id();
            $status = Schema::STATUS_ACTIVE;
            $createdAt = new Time();

            $stmt = $this->pdo->prepare('
              INSERT INTO schemas (id, accountId, name, status, createdAt, data)
              VALUES (:id, :accountId, :name, :status, :createdAt, :data)
            ');
            $stmt->execute([
                ':id' => $id,
                ':accountId' => $schemaData->getAccountId(),
                ':name' => $schemaData->getName(),
                ':status' => $status,
                ':createdAt' => $createdAt,
                ':data' => json_encode($schemaData->getData())
            ]);

            return new Schema(
                $id,
                $schemaData->getAccountId(),
                $schemaData->getName(),
                $status,
                $createdAt,
                $schemaData->getData()
            );
        });
    }

    public function get($id)
    {
        $stmt = $this->pdo->prepare('
            SELECT id, accountId, name, status, createdAt, data
            FROM schemas
            WHERE id = :id
        ');
        $stmt->execute([':id' => $id,]);
        $row = $stmt->fetch();
        if ($row === false) {
            return null;
        }

        return new Schema(
            $row['id'],
            $row['accountId'],
            $row['name'],
            $row['status'],
            $row['createdAt'],
            json_decode($row['data'], true)
        );
    }
}