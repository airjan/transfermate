<?php

/**
 * Class XmlReader
 * 
 * This class is responsible for reading, processing, and handling XML files containing book and author data.
 * It extracts metadata from the XML content, processes authors and books, and stores them in the database.
 *
 * @package    TransferMateExam
 * @subpackage Classes
 * @author     Jan Roxas <janrennel.roxas@gmail.com>
 * @version    1.0
 * @since      2024-12-16
 */

namespace Classes;

use Exception;
use DOMDocument;
use Models\{Authors,Books};
use RecursiveIteratorIterator;
use RecursiveDirectoryIterator;

class XmlReader
{
    private $Authors;
    private $Books;

    /**
     * XmlReader constructor.
     * 
     * Initializes the Authors and Books models.
     */
    public function __construct()
    {
        $this->Authors = new Authors();
        $this->Books = new Books;
    }

    /**
     * Processes the given XML file.
     * 
     * Reads the XML file, converts its content to UTF-8 encoding if necessary, 
     * and processes the book and author data. If the XML contains multiple books, 
     * it processes each book; otherwise, it processes a single book.
     *
     * @param  string $file The path to the XML file.
     * @throws Exception If the XML content is invalid or if there are missing required fields.
     */
    private function processXml($file)
    {
        $metadata = [];
        $folder = dirname($file);
        $filename = basename($file);
        
        $authorMetaData =[];
        $bookMetaData =[];
        $xmlContent = file_get_contents($file);
        if (!mb_detect_encoding($xmlContent, 'UTF-8', true)) {
            $xmlContent = mb_convert_encoding($xmlContent, 'UTF-8');
        }
        libxml_use_internal_errors(true);
        $xml = simplexml_load_string($xmlContent, null, LIBXML_NOCDATA);
        if (!$xml) {
            $errors = libxml_get_errors();
            libxml_clear_errors();
            throw new Exception('Exiting....Invalid Content ' . $file . '----' . json_encode($errors));
        }
        
            
        if (count($xml->book) >= 1) {

            foreach($xml->book as $book) {
                $author = $this->getAuthor($book);
                $title = $this->getBookTitle($book);
                $meta = $this->convertToMetaData($book);
            
                $authorId = $this->handleAuthor($author, $meta, $folder, $filename);
                $this->handleBook($authorId, $title, $meta, $folder, $filename);
            }

        } else {

            $author = $this->getAuthor($xml);
            $title = $this->getBookTitle($xml);
            $meta = $this->convertToMetaData($xml);
            $authorId = $this->handleAuthor($author, $meta, $folder, $filename);
            $this->handleBook($authorId, $title, $meta, $folder, $filename);
            
        }
        
    }

    /**
     * Converts the given XML data to a metadata array and encodes it as a JSON string.
     *
     * This method iterates through the XML elements and collects the data into an associative array, 
     * then converts the array into a JSON format .
     *
     * @param  SimpleXMLElement $xml The XML element containing the data to be converted.
     * @return string A JSON-encoded string representing the metadata extracted from the XML.
     * */

    private function convertToMetaData( $xml) 
    {
        $metadata = [];
        foreach($xml as $key => $value) {
            $metadata[$key] = $value;
        }
        return  json_encode($metadata);
    }

    /**
     * Retrieves the author name from the XML element.
     *
     * @param  SimpleXMLElement $xml XML element containing author data.
     * @return string Author name.
     * @throws Exception If the author field is missing or empty.
     */
    private function getAuthor($xml): string
    {
        if ((!isset($xml->author)) || (empty(trim($xml->author))) ) {
        
            throw new Exception("Missing <author> field in XML.");
        }
        return trim($xml->author);
        
    }

    /**
     * Retrieves the book title from the XML element.
     *
     * @param  SimpleXMLElement $xml XML element containing book data.
     * @return string Book title.
     * @throws Exception If the title field is missing or empty.
     */
    private function getBookTitle($xml): string
    {
        if (!isset($xml->name)) {
            throw new Exception("Missing <name> field in XML.");
        }
        return trim($xml->name);
    }

    /**
     * Handles the creation or updating of the author record in the database.
     *
     * @param  string $author   Author name.
     * @param  string $meta     Author metadata.
     * @param  string $folder   Directory path.
     * @param  string $filename Name of the XML file.
     * @return int The ID of the author.
     */
    private function handleAuthor(string $author, string $meta, string $folder, string $filename): int
    {
        $existingAuthor = $this->Authors->findAuthor($author);
        $authorData = [
            'name' => $author,
            'metadata' => $meta,
            'filename' => $filename,
            'folder' => $folder,
        ];

        if ($existingAuthor) {
            $authorId = $existingAuthor['id'];
            $this->Authors->update($authorId, $meta, $folder, $filename);
        } else {
            $authorId = $this->Authors->create($authorData);
        }

        return $authorId;
    }

    /**
     * Handles the creation or updating of the book record in the database.
     *
     * @param int    $authorId Author ID.
     * @param string $title    Book title.
     * @param string $meta     Book metadata.
     * @param string $folder   Directory path.
     * @param string $filename Name of the XML file.
     */
    private function handleBook(int $authorId, string $title, string $meta, string $folder, string $filename): void
    {
        $existingBook = $this->Books->findbyBook($authorId, $title);

        if ($existingBook) {
            $this->Books->update($existingBook['id'], $meta, $folder, $filename);
        } else {
            $bookData = [
                'title' => $title,
                'author_id' => $authorId,
                'folder' => $folder,
                'filename' => $filename,
                'metadata' => $meta,
            ];
            $this->Books->create($bookData);
        }
    }

    public function processFolder($directory)
    {
        $storage = new   RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

        foreach($storage as $file) {
            if ($file->isFile() && strtolower($file->getExtension()) === 'xml') {
                $path = $file->getPathname();
                $this->processXml($path);
            }
        }
    }
}
?>
