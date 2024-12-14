<?php
require __DIR__ . '/autoloader.php';

use Classes\XMLReader; 

 $xml = new XMLReader();
 $folder = "books_xml";
 try {
 	$xml->processFolder($folder);

} catch(\Exception $e) {
	echo $e->getMessage();
}
?>