<?php if($setup->isErrors()): ?>
<section class="item error">
    <div class="row title">
        <h4>Error</h4>
    </div>
    <div class="row">
        <ul>
            <?php foreach($setup->getErrors() as $er): ?>
            <li><?php echo $er; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
<?php endif; ?>