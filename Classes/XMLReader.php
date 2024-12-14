<?php
namespace Classes;
use Exception;
use DOMDocument;
//use Database\Database;
use Models\{Authors,Books};
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;
class XMLReader
{
	private $Authors;
	private $Books;
	public function __construct() {
		$this->Authors = new Authors();
		$this->Books = new Books;
	}

	
	public function processXML($file)
	{
		$metadata = [];
		$folder = dirname($file);
		$filename = basename($file);
		
		$authorMetaData =[];
		$bookMetaData =[];
		$xmlContent = file_get_contents($file);
		if (!mb_detect_encoding($xmlContent ,'UTF-8', true))
		{
			$xmlContent = mb_convert_encoding($xmlContent, 'UTF-8');
		}
		libxml_use_internal_errors(true);
		$xml = simplexml_load_string($xmlContent,null, LIBXML_NOCDATA);
		if (!$xml) {
			$errors = libxml_get_errors();
			 libxml_clear_errors();
			throw new Exception('Exiting....Invalid Content ' . $file . '----' . json_encode($errors));
		}
		
			
        if (count($xml->book) >= 1) {
			foreach($xml->book as $book) {
				//$author = trim($book->author);
				//$title =  trim($book->name);
				if ( (!isset($book->author)) || (empty(trim($book->author))) ) {
					throw new Exception('Missing <author> field in XML: ' . $file);
				}
				if ( (!isset($book->name))  ) {
					throw new Exception('Missing <name> field in XML: ' . $file);
				}
				$metadata = [];
				foreach($book as $key => $value){
					if ($key =='author') {
						$author = trim($value);
						//continue;
					}
					if ($key =='name') {
						$title = trim($value);
						//continue;
					}
					
					$metadata[$key] = $value;
				} 
				$meta = json_encode($metadata);
				$isAuthor = $this->Authors->findAuthor($author);
				$dataAuthor =[
					'name' => $author,
					'metadata' => $meta,
					'filename' =>$filename,
					'folder'   => $folder
					
				];
				if (!empty($isAuthor))
				{
					$author_id = $isAuthor['id'];
					// update 
					$this->Authors->update($author_id,$meta,$folder,$filename);
				} else {
					$author_id  = $this->Authors->create($dataAuthor);
				}
				//$author_id = !empty($isAuthor) ? $isAuthor['id'] : $this->Authors->create($dataAuthor);
				$bookexist = $this->Books->findbyBook($author_id, $title);

				if (!$bookexist)
				{	
					$dataBook =[
							'title' => $title,
							'author_id' => $author_id,
							'folder' => $folder,
							'filename' => $filename,
							'metadata' => $meta
						];
					$this->Books->create($dataBook);
				}  else {
					$this->Books->update($bookexist['id'],$meta,$folder,$filename);
				}
			
			}
		} else {
			if ( (!isset($xml->author)) || (empty(trim($xml->author))) ) {
				throw new Exception('Missing <author> field in XML: ' . $file);
			}
			if ( (!isset($xml->name))  ) {
				throw new Exception('Missing <name> field in XML: ' . $file);
			}
			
			foreach($xml as $key => $value){
				if ($key =='author') {
						$author = trim($value);
						//continue;
				}
				if ($key =='name') {
						$title = trim($value);
						//continue;
				}
				$metadata[$key] = $value;
			}
			$meta = json_encode($metadata);
			$dataAuthor = [
				'name' => $author,
				'metadata' => $meta,
				'filename' =>$filename,
				'folder'   => $folder
			];
			
			$isAuthor = $this->Authors->findAuthor($author);
			if (!empty($isAuthor))
			{
				$author_id = $isAuthor['id'];
				// update 
				$this->Authors->update($author_id,$meta,$folder,$filename);
			} else {
				$author_id  = $this->Authors->create($dataAuthor);
			}
			//$author_id = !empty($isAuthor) ? $isAuthor['id'] : $this->Authors->create($dataAuthor);
			$bookexist = $this->Books->findbyBook($author_id, $title);
			if (!$bookexist)
			{	
				$dataBook =[
						'title' => $title,
						'author_id' => $author_id,
						'folder' => $folder,
						'filename' => $filename,
						'metadata' => $meta
					];
				$this->Books->create($dataBook);
			} else {
				$this->Books->update($bookexist['id'],$meta,$folder,$filename);
			}
		}
		
	}	


	public function processFolder($directory)
	{
		$storage = new   RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

		foreach($storage as $file) {
			if ($file->isFile() && strtolower($file->getExtension()) === 'xml') {
				$path = $file->getPathname();
				$this->processXML($path);
			}
		}
	}
}
?>