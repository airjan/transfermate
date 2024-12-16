<?php

/**
 * Main script for processing XML files using the XMLReader class.
 *
 * This script initializes an instance of the `XMLReader` class and processes XML
 * files located in the specified folder.  
 * Outputs any error messages encountered during the process.
 *
 * @package    TransferMateExam
 * @uses       Classes\XMLReader
 * @author     Jan Roxas <janrennel.roxas@gmail.com>
 * @version    1.0
 * @since      2024-12-16
 * @phpversion 8.0
 */

// Include the autoloader to load required classes
require __DIR__ . '/autoloader.php';

use Classes\XmlReader; 

 $xml = new XmlReader();
 $folder = "books_xml";
try {
    $xml->processFolder($folder);

} catch(\Exception $e) {
    echo $e->getMessage();
}
?>
