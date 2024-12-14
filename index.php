<?php
require __DIR__ . '/autoloader.php';

use Models\Books;

class Index
{
	protected $books;
	public function __construct()
	{
		 
		$this->books = new Books();
		
	}

	public function Render($searchTerm,$currentPage)
	{
		try {
		 $currentPage = $currentPage;
		$recordsPerPage = 10;
		$records = $this->books->getBooksWithAuthors($searchTerm,$recordsPerPage,$currentPage);
		$total = $this->books->getTotalCountBooksWithAuthors($searchTerm);
		
		 $totalPages = ceil($total / $recordsPerPage);

		 

		}catch (\Exception $e) {
			echo 'Error '.$e->getMessage();
		}
		require __DIR__.'/views/index.php';
	}

	
	public function viewXml($folder,$filename)
	{
		try {
			$folder = urldecode($folder);
			$filename = urldecode($filename);
		
			$fullPath =  $folder . "/".$filename;
			if (!file_exists($fullPath)) {
            	throw new Exception("File not found: " . $fullPath);
        	}
			$xml = simplexml_load_file($fullPath);
			 if (!$xml ) {
            	throw new Exception("Failed to load XML from file: " . $fullPath);
        		}
			//header('Content-Type: text/html; charset=utf-8');
			header('Content-Type: application/xml');
			echo ($xml->asXML());
		}catch(Exception $e) {
			echo "Error ". $e->getMessage();
		}
	
	}
		
}

 $page =new Index();
 if ((!isset($_GET['view'])) || ($_GET['view'] !=1)){

 	$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
	$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
 	$page->Render($searchTerm,$currentPage);
 } else {
 	$folder = $_GET['metafolder'];
 	$file = $_GET['metafile'];
 	$page->viewXml($folder,$file);
 }	

?>