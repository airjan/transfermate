<?php
namespace Models;

use Database\baseConnection;
use Traits\DBExecution;
use PDO;
use Exception;
class Books extends baseConnection
{
	use DBExecution;
	
	protected $tableName = 'books';
	protected $allowFields =['title','author_id','metadata','folder','filename'];
	protected $fields =[];
	

	public function findbyBook($author_id,$title)
	{
		$sql ="SELECT * FROM {$this->tableName} where title=:title and author_id=:author_id  LIMIT 1";
		$connection = $this->db->getConnect();
		$prep = $connection->prepare($sql);
		$prep->bindValue(":title", $title,PDO::PARAM_STR);
		$prep->bindValue(':author_id',  $author_id);
		$prep->execute();
		$result = $prep->fetch(PDO::FETCH_ASSOC);
		return $result ?: null;
	}

	public function getBooksWithAuthors($search,$perPage,$currentPage)
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
       
        /*
        HMM.. much better if we create pagination and move to traits so it can be used as global, 
        what if there are more than thousands of records fastest way to resolve is use pagination so it will limit the data fetching from database
        ** other possible solutions 
        * caching 

         */
        /*
        $connection = $this->db->getConnect();
        $prep = $connection->prepare($sql);
		
        if ($search) {
        	$prep->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        	
        }
       
        $prep->execute();
        return $prep->fetchAll(PDO::FETCH_ASSOC);
    	*/
        
       
        $books = $this->paginate($sql,$search,$perPage,$currentPage);
        return $books;
        
    }
    // added so we can have the pagination computation
    public function getTotalCountBooksWithAuthors($search)
    {
    	$sql = "SELECT b.id, a.name  as searchfield
                FROM {$this->tableName} b
                LEFT JOIN authors a ON b.author_id = a.id";
        return $this->getTotal($sql, $search);
    }
	
}
?>