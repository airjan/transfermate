<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Authors</title>
  <link rel="stylesheet" href="styles/styles.css">
</head>
<body>

  <div class="data-grid">
    <h1>List of Authors</h1>
     <div class="search-container">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search by author" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
            <input type="submit" value="Search">
        </form>
    </div>
    <div class='table-container'>
    <table>
      <thead>
        <tr>
          <th >Name</th>
          <th >Book</th>
          <th>Date Published</th>
          <th>XML</th>
         
        </tr>
      </thead>
      <tbody id="table-body">
        <?php
        if (count($records) == 0) {

            echo '<tr><td colspan=3>No Records</td></tr>';
            
        } else {

            ?>
            <?php foreach($records as $record) {
                ?>
            <tr>
                <Td> <?php echo $record['author_name'];?></Td>
                <td><?php echo empty($record['book_title']) ? 'No books found' : htmlspecialchars($record['book_title']); ?></td>
                <td>
                    <?php 
                    $published = new DateTime($record['book_created']);
                    echo $published->format('F j, Y');

                    ?>
                </td>
                <Td><a href="index.php?view=1&metafolder=<?php echo urlencode($record['folder']);?>&metafile=<?php echo urlencode($record['filename']); ?>">XML here</a> </Td>
         
            </tr>

                <?php 
            }

        }
        ?>
       
      </tbody>
    </table>
    </div> <!-- table-container -->
    <?php require 'pagination.php'; ?>

  </div>
<script>
    window.onload = function() {
    var rows = document.querySelectorAll('tbody tr');
    rows.forEach(function(row, index) {
        setTimeout(function() {
            row.classList.add('visible');
        }, index * 100); // Delay for each row (100ms between rows)
    });
};
</script>
</body>
</html>
