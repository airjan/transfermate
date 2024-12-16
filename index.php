<?php

/**
 * Main script for Displaying Authors.
 *
 * This script initializes an instance of the `Books` class and processes the list of books.
 * It supports pagination and searching of books and authors, and can also render XML content when requested
 *
 * @package    TransferMateExam
 * @uses       Models/Books
 * @author     Jan Roxas <janrennel.roxas@gmail.com>
 * @version    1.0
 * @since      2024-12-16
 * @phpversion 8.0
 */

require __DIR__ . '/autoloader.php';

use Models\Books;

class Index
{
    /**
     * @var Books $books Instance of the Books model
     */
    protected $books;

    /**
     * Index constructor.
     * Initializes the Books model.
     */
    public function __construct()
    {
        $this->books = new Books();
    }

    /**
     * Renders the list of books and their authors with pagination.
     * 
     * Retrieves books and authors based on the search term and current page.
     *  includes the view file to display the results.
     * 
     * @param string $searchTerm  The search term for filtering books.
     * @param int    $currentPage The current page number for pagination.
     * 
     * @return void
     */
    public function render(string $searchTerm, int $currentPage): void
    {
        try {
            $recordsPerPage = 10;
            $records = $this->books->getBooksWithAuthors($searchTerm, $recordsPerPage, $currentPage);
            $total = $this->books->getTotalCountBooksWithAuthors($searchTerm);
            $totalPages = ceil($total / $recordsPerPage);
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }

        include __DIR__ . '/views/index.php';
    }

    /**
     * Displays the XML content of a specified file.
     * 
     * Reads the XML file from the given folder and filename, and outputs
     * the content to the browser with the appropriate XML headers.
     * 
     * @param string $folder   The folder containing the XML file.
     * @param string $filename The name of the XML file.
     * 
     * @return void
     */
    public function viewXml(string $folder, string $filename): void
    {
        try {
            $folder = urldecode($folder);
            $filename = urldecode($filename);

            $fullPath = $folder . "/" . $filename;

            if (!file_exists($fullPath)) {
                throw new Exception("File not found: " . $fullPath);
            }

            $xml = simplexml_load_file($fullPath);

            if (!$xml) {
                throw new Exception("Failed to load XML from file: " . $fullPath);
            }

            header('Content-Type: application/xml');
            echo $xml->asXML();

        } catch (Exception $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}

// Instantiate the Index class
$page = new Index();

// Check if the user is requesting to view XML, otherwise render the page with books
if ((!isset($_GET['view'])) || ($_GET['view'] != 1)) {

    $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
    $searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
    $page->render($searchTerm, $currentPage);

} else {

    $folder = $_GET['metafolder'];
    $file = $_GET['metafile'];
    $page->viewXml($folder, $file);
    
}
?>
