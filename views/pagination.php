<!-- Pagination Links -->
<div class="pagination">

    <?php
    $searchTerm = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; 
    $searchParam ='';
    if (!empty($searchTerm))
    {
        $searchParam = '&search=' . $searchTerm;
    }
   
    ?>
    <?php if ($currentPage > 1): ?>
        <a href="?page=<?= $currentPage - 1 . $searchParam; ?>">Previous</a>
    <?php endif; ?>

    <?php for ($page = 1; $page <= $totalPages; $page++): ?>
        <a href="?page=<?= $page . $searchParam; ?>" <?= $page == $currentPage ? 'class="active"' : ''; ?>>
            <?= $page; ?>
        </a>
    <?php endfor; ?>

    <?php if ($currentPage < $totalPages): ?>
        <a href="?page=<?= $currentPage + 1 . $searchParam; ?>">Next</a>
    <?php endif; ?>
</div>