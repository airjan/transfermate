<?php
require __DIR__ . '/autoloader.php';
use Database\Migration\{Author,Books,
					SearchAuthorIndex,
					AddfieldsAuthorMetaData,
					AddfieldsBooksMetaData
					};

$author = new Author();
$author->migrate();
$books = new Books();
$books->migrate();
$searchIndex = new SearchAuthorIndex();
$searchIndex->migrate();
$authorMeta =  new AddfieldsAuthorMetaData();
$authorMeta->migrate();
$bookMeta = new AddfieldsBooksMetaData();
$bookMeta->migrate();
echo "done";
?>