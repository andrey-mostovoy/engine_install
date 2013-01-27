<?php require_once 'header.php'; ?>
    <article class="item">
        <div class="row title">
            <h3>Here the all settings to  setup:</h3>
        </div>
    </article>
    <article class="items">
        <?php include 'error.php'; ?>
        <form action="" method="post">
            <input type="hidden" name="collect" value="2" />
            <input type="hidden" name="confirm" value="1" />
            <article class="item">
                <div class="row title">
                    <h3>Modules, files:</h3>
                </div>
                <article class="columed-content">
                    <section class="column">
                        <div class="row">
                            <ul>
                                <li><?php echo $setup->lang['module']['base']; ?> </li>
                                <?php foreach($setup->getModulesToConfirm() as $m): ?>
                                <li><?php echo $m; ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </section>
                    <section class="column">
                    </section>
                </article>
            </article>
            <?php $settings = $setup->getCodeToConfirm(); ?>
            <?php $item = 'site'; include 'confirm_code_item.php'; ?>
            <?php $item = 'db'; include 'confirm_code_item.php'; ?>
            <?php $item = 'cache'; include 'confirm_code_item.php'; ?>
            <?php $item = 'compression'; include 'confirm_code_item.php'; ?>
            <article class="btn">
                <input type="button" value="Back" onclick="window.location.href='?page=settings'; return false;"/>
                <input type="submit" value="Start Setup Process" />
            </article>
        </form>
    </article>
<?php require_once 'footer.php'; ?>