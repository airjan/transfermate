<?php

/**
 * Authors model class.
 * 
 * This Class is responsible for interacting with the Books table in the database 
 * It provides methods to retrieve a book by title and author, list books with author information,  and compute pagination.
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

class Books extends BaseConnection
{
    use DatabaseExecution;
    
    protected $tableName = 'books';
    protected $allowFields = ['title', 'author_id', 'metadata', 'folder', 'filename'];
    protected $fields = [];

    /**
     * Finds a book by title and author ID.
     *
     * @param  int    $author_id The ID of the author.
     * @param  string $title     The title of the book.
     * @return array|null The book record as an associative array, or null if not found.
     */
    public function findbyBook(int $author_id,string $title): ?array
    {
        $sql ="SELECT * FROM {$this->tableName} WHERE title=:title and author_id=:author_id  LIMIT 1";
        return $this->executeQuery($sql, [':title' => $title, ':author_id' => $author_id]);
       
    }

    /**
     * Retrieves books with author details, with pagination support.
     *
     * @param  string|null $search      Search term for filtering authors by name.
     * @param  int         $perPage     The number of records per page.
     * @param  int         $currentPage The current page number.
     * @return array The paginated list of books with authors.
     */
    public function getBooksWithAuthors(string $search,int $perPage,int $currentPage): ?array
    {

        $sql = "SELECT b.id AS book_id, 
        		b.title AS book_title, 
        		a.id AS author_id, 
        		a.name AS author_name,
        		a.filename, a.folder,
        		 b.created_at as book_created
                FROM {$this->tableName} b
                LEFT JOIN authors a ON b.author_id = a.id " ;
        if ($search) {
            $sql .= " WHERE a.name like :search  ";
        }
         
        $books = $this->paginate($sql, $search, $perPage, $currentPage);
        return $books;
        
    }

    /**
     * Retrieves the total count of books with authors, for pagination.
     *
     * @param  string|null $search Search term for filtering authors by name.
     * @return int The total count of books.
     */
    public function getTotalCountBooksWithAuthors(?string $search): int
    {
        $sql = "SELECT b.id, a.name  as searchfield
                FROM {$this->tableName} b
                LEFT JOIN authors a ON b.author_id = a.id";
        return $this->getTotal($sql, $search);
    }
    
}

?>
