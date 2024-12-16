<?php

/**
 * DatabaseExecution Trait
 *
 * This trait provides common methods for performing database operations such as 
 * creating, updating, and retrieving records, as well as handling pagination 
 * and counting results. It simplifies common database interactions using PDO.
 *
 * @package    TransferMateExam
 * @subpackage Traits
 * @author     Jan Roxas <janrennel.roxas@gmail.com>
 * @version    1.0
 * @since      2024-12-16
 * @phpversion 8.0
 */

namespace Traits;

use Exception;
use PDO;

trait DatabaseExecution
{
    /**
     * Create a new record in the table
     * 
     * @param array $data The data to insert into the table
     * 
     * @return int|false Returns the last inserted ID on success, or false on failure
     * @throws Exception If the provided data is not an array
     */
    public function create(array $data)
    {
        if (!is_array($data)) {
            throw new Exception('Invalid data');
        }

        foreach ($data as $k => $v) {
            if (in_array($k, $this->allowFields)) {
                $this->fields[$k] = $v;
            }
        }

        if (count($this->fields) >= 1) {
            $connection = $this->db->getConnect();
            $columns = implode(", ", array_keys($this->fields));
            $holder = ":" . implode(", :", array_keys($this->fields));
            $sql = "INSERT INTO $this->tableName ($columns) VALUES ($holder)";
            
            $prep = $connection->prepare($sql);

            foreach ($this->fields as $key => $value) {
                $prep->bindValue(":$key", $value, PDO::PARAM_STR);
            }

            if ($prep->execute()) {
                return $connection->lastInsertId();
            }
        }

        return false;
    }

    /**
     * Update an existing record
     * 
     * @param int    $id       The ID of the record to update
     * @param string $meta     The metadata to update
     * @param string $folder   The folder name
     * @param string $filename The filename
     * 
     * @return void
     */
    public function update(int $id, string $meta, string $folder, string $filename): void
    {
        $connection = $this->db->getConnect();
        $sql = "UPDATE $this->tableName SET metadata = :metadata, folder = :folder, filename = :filename WHERE id = :id";

        $prep = $connection->prepare($sql);
        $prep->bindValue(":metadata", $meta, PDO::PARAM_STR);
        $prep->bindValue(":folder", $folder, PDO::PARAM_STR);
        $prep->bindValue(":filename", $filename, PDO::PARAM_STR);
        $prep->bindValue(":id", $id, PDO::PARAM_INT);
        $prep->execute();
    }

    /**
     * Paginate the results
     * 
     * @param string $sql         The SQL query to execute
     * @param string $search      Optional search term
     * @param int    $perPage     Number of results per page
     * @param int    $currentPage The current page number
     * 
     * @return array The paginated results
     */
    public function paginate(string $sql, string $search = null, int $perPage = 10, int $currentPage = 1): array
    {
        $offset = ($currentPage - 1) * $perPage;

        $sql .= " LIMIT :limit OFFSET :offset";
        $connection = $this->db->getConnect();
        $prep = $connection->prepare($sql);

        $prep->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $prep->bindValue(':offset', $offset, PDO::PARAM_INT);
        
        if ($search) {
            $prep->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        }

        $prep->execute();
        return $prep->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get the total number of records matching the search query
     * 
     * @param string $sql    The SQL query to execute
     * @param string $search Optional search term
     * 
     * @return int The total count of matching records
     */
    public function getTotal(string $sql, string $search = null): int
    {
        $sqlCount = "SELECT COUNT(*) FROM (" . $sql . ") AS total ";
        
        if ($search) {
            $sqlCount .= " WHERE searchfield LIKE :search ";
        }

        $connection = $this->db->getConnect();
        $prepCount = $connection->prepare($sqlCount);
        
        if ($search) {
            $prepCount->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        }

        $prepCount->execute();
        return (int) $prepCount->fetchColumn();
    }

    /**
     * Executes a database query and returns the result.
     *
     * @param  string $sql    The SQL query to execute.
     * @param  array  $params Parameters to bind to the query.
     * @param  bool   $single return single record if true otherwise 
     * @return mixed The result of the query.
     */
    public function executeQuery(string $sql, array $params = [], bool $single = true) 
    {
        $connection = $this->db->getConnect();
        $prep  = $connection->prepare($sql);

        foreach ($params as $key => $value) {
            $prep->bindValue($key, $value, is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR);
        }
        $prep->execute();
        if ($single) {
            $result = $prep->fetch(PDO::FETCH_ASSOC);
        } else {
            $result = $prep->fetchAll(PDO::FETCH_ASSOC);
        }
        
        return $result ?: null;

    }
}

?>
