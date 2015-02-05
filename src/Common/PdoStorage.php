<?php
namespace Api\Common;

use PDO;
use Exception;

trait PdoStorage
{
    /**
     * @var PDO
     */
    private $pdo;

    public function transactional(callable $function)
    {
        $this->pdo->beginTransaction();
        try {
            $function();
            $this->pdo->commit();
        }
        catch (Exception $e)
        {
            $this->pdo->rollBack();
            throw $e;
        }
    }
}