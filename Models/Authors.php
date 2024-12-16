<?php

/**
 * Authors model class.
 * 
 * This Class is responsible for interacting with the authors table in the database 
 * It provides methods to retrieve an author by their name 
 *
 * @package    TransferMateExam
 * @subpackage Models
 * @author     Jan Roxas <janrennel.roxas@gmail.com>
 * @version    1.0 
 * @since      2024-12-16
 * @phpversion 8.0 
 */

namespace Models;

use Database\BaseConnection;
use Traits\DatabaseExecution;

class Authors  extends BaseConnection
{
    use DatabaseExecution;

    protected $tableName = 'authors';
    protected $allowFields = ['name', 'metadata', 'filename', 'folder'];
    protected $fields = [];

    /**
     * Finds an author by name 
     *
     * @param  string $name The name of the author to search for 
     * @return array| null returns the author record as associative array 
     */
    public function findAuthor(string  $name): ?array
    {
        $sql = "SELECT * FROM {$this->tableName} WHERE name=:name  LIMIT 1";
        return $this->executeQuery($sql, [':name' => $name]);
       
    }

}
?>
