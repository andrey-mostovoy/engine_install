<?php require_once 'header.php'; /*step 3*/?>
    <article class="item">
        <div class="row title">
            <h3>Modules</h3>
        </div>
        <div class="row subtitle">
            <p>Be careful! Engine will be setup to parent directory: <strong><?php echo $setup->basedir; ?></strong>.</p>
        </div>
    </article>

    <article class="items">
        <?php include 'error.php'; ?>
        <form action="" method="post">
            <input type="hidden" name="collect" value="2" />
            <input type="hidden" name="step" value="2" />

            <article class="item">
                <article class="columed-content">
                    <section class="column">
                        <?php foreach($setup->modules as $k => $v): ?>
                            <div class="row">
                                <input type="checkbox" name="module[]" value="<?php echo $k; ?>" /> <?php echo $setup->lang['module'][$k]; ?>
                            </div>
                        <?php endforeach; ?>
                    </section>
                    <section class="column">
                    </section>
                </article>
            </article>

            <article class="btn">
                <input type="submit" value="Next" />
            </article>
        </form>
    </article>
<?php require_once 'footer.php'; ?>