<?php 
namespace Traits;
use Exception;
use PDO;
trait DBExecution
{


    public function create(array $data )
	{
		
		if (!is_array($data))
		{
			throw new Exception('Invalid data ');
		}
		foreach($data as $k => $v) {
			if (in_array($k , $this->allowFields)) {
				$this->fields[$k] = $v;
			}
		}

		if (count($this->fields) >=1) {
			$connection = $this->db->getConnect();
			$columns= implode(", ", array_keys($this->fields));
 			$holder = ":" . implode(", :", array_keys($this->fields));
 			$sql = "insert into  $this->tableName ($columns) VALUES ($holder) ";
 			
			$prep = $connection->prepare($sql);

			foreach($this->fields as $key => $value) {

				$prep->bindValue(":$key", $value,PDO::PARAM_STR);
				
			}
			if ($prep->execute()) {
					return $connection->lastInsertId();
			} else {

			}
		}
		return false;

	}

	/*
	*	@param int $id id of the record
	* 	@param json $meta meta json 
	*	@param string @folder folder name 
	*	@param string @filename filename 
	*	@return null 

	*/

	public function update($id, $meta, $folder, $filename)
	{
		
			$connection = $this->db->getConnect();
			$sql = " update  $this->tableName set metadata =:metadata, folder=:folder, filename =:filename where id=:id";
			$prep = $connection->prepare($sql);
			$prep->bindValue(":metadata", $meta,PDO::PARAM_STR);
			$prep->bindValue(":folder", $folder,PDO::PARAM_STR);
			$prep->bindValue(":filename", $filename);
			$prep->bindValue(":id", $id,PDO::PARAM_INT);
			$prep->execute();

	}

	public function paginate($sql, $search=null, $perPage = 10,$currentPage = 1)
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

	public function getTotal($sql, $search = null)
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
         return $prepCount->fetchColumn();
	}

}

?>