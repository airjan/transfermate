<?php

$file = __DIR__ . '/mysample2.xml';
try {
$xml = simplexml_load_file($file);
$metadata =[];
    //echo count($xml->book);

		echo 'okay you passed here<br>';
        // If the XML contains multiple <book> elements

        if (count($xml->book) >= 1) {
        	echo 'okay too many book';
            foreach($xml->book as $book ){
                echo 'Author: ' . $book->author . '<br>';
                echo 'Name: ' . $book->name . '<br>';
                foreach($book as $key =>$value){
                    if (($key =='name') || ($key=='author')) {
                        continue;
                    }
                    $metadata[$key] = $value;
                }
                  print_r(json_encode($metadata));
            }
          
            /*
            foreach ($xml->book as $book) {
                echo 'Author: ' . $book->author . '<br>';
                echo 'Name: ' . $book->name . '<br>';
                echo '<br>';
            } 
            */
        } 
        // If there's a single <book> element
        else {
           	echo 'single book';
            foreach($xml as $key =>$value)
            {

                echo $key .'----'. $value .'<br>';
                 if ($key =='name' || $key =='author') {
                    continue;
                 }
                 $metadata[$key] = $value;
            }
            echo 'Author: ' . $xml->author . '<br>';
            echo 'Name: ' . $xml->name . '<br>';
            print_r(json_encode($metadata));
        }
     
} catch(\Exception $e) {
	echo $e->getMessage();
}
?>
