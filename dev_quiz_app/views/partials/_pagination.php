<?php if ($params['totalPages'] > 1) : ?>
<div id="pagination" class="pagination">
    <span id="pagination-prev" 
        data-prev-page="<?= $params['currentPage'] <= 1 ? "false" :  $params['currentPage'] - 1 ?>" 
        class="icon-prev">
    </span>
    <span id="pagination-pages">
        <?= $params['currentPage'] ?> sur <?= $params['totalPages'] ?>
    </span>
    <span id="pagination-next" 
        data-next-page="<?= $params['currentPage'] >= $params['totalPages'] ? "false" : $params['currentPage'] + 1 ?>" 
        class="icon-next">
    </span>
</div>
<?php endif; ?>
