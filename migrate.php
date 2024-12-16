<?php

/**
 * Database Migrations for Authors, Books, and Metadata
 * 
 * This script executes the database migration for the following entities:
 * - Author
 * - Books
 * - Search Index for Author
 * - Additional fields for Author metadata
 * - Additional fields for Books metadata
 * 
 * The migration operations are run sequentially for each class, and upon
 * successful execution, a "done" message is printed.
 *
 * @package    TransferMateExam
 * @uses       Database\Migration\Author, 
 *             Database\Migration\Books, 
 *             Database\Migration\SearchAuthorIndex, 
 *             Database\Migration\AddfieldsAuthorMetaData, 
 *             Database\Migration\AddfieldsBooksMetaData
 * @author     Jan Roxas <janrennel.roxas@gmail.com>
 * @version    1.0
 * @since      2024-12-16
 * @phpversion 8.0
 */

// Include the autoloader to load required classes
require __DIR__ . '/autoloader.php';

// Import required migration classes for Authors, Books, Search Index, and Metadata
use Database\Migration\{Author, Books, SearchAuthorIndex, AddfieldsAuthorMetaData, AddfieldsBooksMetaData};


    $migrations = [
            new Author(),
            new Books(),
            new SearchAuthorIndex(),
            new AddfieldsAuthorMetaData(),
            new AddfieldsBooksMetaData(),
    ];

    foreach($migrations as $migration) {
        try {
            $migration->migrate();
        } catch (\Exception $e) {
            echo "Migration failed: " . $e->getMessage() . "\n";
        }
    }

    ?>
