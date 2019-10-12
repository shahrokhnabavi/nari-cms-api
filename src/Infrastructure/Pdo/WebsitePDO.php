<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Pdo;

use PDO;

class WebsitePDO extends PDO
{
    public function beginTransaction()
    {
        if (!$this->inTransaction()) {
            parent::beginTransaction();
        }
    }

    public function rollBack()
    {
        if (!$this->inTransaction()) {
            parent::rollBack();
        }
    }

    public function commit()
    {
        if (!$this->inTransaction()) {
            parent::commit();
        }
    }
}
