<div id="solr-sort">
    <form method="get">
        <?php foreach ($query as $key => $value): ?>
            <?php if (!is_array($value) && $key !== 'sort'): ?>
                <?php echo $this->formHidden($key, $value); ?>
            <?php endif; ?>
        <?php endforeach; ?>

        <label>
            <?php
            echo __('Sort by');
            $sort = isset($query['sort']) ? $query['sort'] : null;
            echo $this->formSelect('sort', $sort, null, $sortOptions);
            ?>
        </label>
        <button type="submit"><?php echo __('Sort'); ?></button>
    </form>
</div>
