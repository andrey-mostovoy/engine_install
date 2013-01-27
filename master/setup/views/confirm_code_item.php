<?php if($setup->isModuleInstall($item)): ?>
<?php if(isset($settings[$item])): ?>
<article class="item">
    <div class="row title">
        <h3><?php echo $setup->lang['module'][$item]; ?> settings:</h3>
    </div>
    <article class="columed-content">
        <section class="column">
            <div class="row">
                <ul>
                    <?php foreach($settings[$item] as $k => $v): ?>
                    <li><?php echo $setup->lang['module_vars'][$item][$k]; ?> - <strong><?php echo $v; ?></strong> </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </section>
        <section class="column">
        </section>
    </article>
</article>
<?php endif; ?>
<?php endif; ?>