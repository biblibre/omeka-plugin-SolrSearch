<div id="solr-sort">
    <form method="get">
        <?php foreach ($query as $key => $value): ?>
            <?php if (!is_array($value) && $key !== 'sort'): ?>
                <?php echo $this->formHidden($key, $value); ?>
            <?php endif; ?>
        <?php endforeach; ?>

        <label>
            Sort by
            <?php echo $this->formSelect('sort', $query['sort'], null, $sortOptions); ?>
        </label>
        <button type="submit"><?php echo __('Sort'); ?></button>
    </form>
</div>
