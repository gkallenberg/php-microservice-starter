<?php
namespace NYPL\Starter\Model\ModelInterface;

use NYPL\Starter\Model;
use NYPL\Starter\Model\Schema;

interface MessageInterface
{
    /**
     * @return Schema
     */
    public function getSchema();
}
