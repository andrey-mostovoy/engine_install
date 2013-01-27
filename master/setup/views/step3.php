<?php require_once 'header.php'; /*step 3*/?>
    <article class="items">
        <form action="" method="post">
            <input type="hidden" name="collect" value="2" />
            <input type="hidden" name="step" value="3" />
            <?php include 'error.php'; ?>
            <article class="item">
                <div class="row title">
                    <h3><?php echo $setup->lang['module']['site']; ?> settings</h3>
                </div>
                <article class="columed-content">
                    <section class="column">
                        <div class="row">
                            <label><?php echo $setup->lang['module_vars']['site']['name'];?>:</label>
                            <?php echo $setup->input('text','site','name',null,true); ?>
                        </div>
                        <div class="row">
                            <label><?php echo $setup->lang['module_vars']['site']['debug'];?>:</label>
                            <?php echo $setup->input('radio','site','debug',null,true,'1'); ?> On
                            <?php echo $setup->input('radio','site','debug',null,true,'0'); ?> Off
                        </div>
                    </section>
                    <section class="column">
                        <div class="row">
                            <label><?php echo $setup->lang['module_vars']['site']['admin_url'];?>:</label>
                            <?php echo $setup->input('text','site','admin_url',null,true); ?>
                        </div>
                        <div class="row">
                            <label><?php echo $setup->lang['module_vars']['site']['theme'];?>:</label>
                            <?php echo $setup->input('text','site','theme',null,true); ?>
                        </div>
                    </section>
                </article>
            </article>
            <article class="item">
                <div class="row title">
                    <h3><?php echo $setup->lang['module']['db']; ?> settings</h3>
                </div>
                <article class="columed-content">
                    <section class="column">
                        <div class="row">
                            <label><?php echo $setup->lang['module_vars']['db']['server'];?>:</label>
                            <?php echo $setup->input('text','db','server',null,true); ?>
                        </div>
                        <div class="row">
                            <label><?php echo $setup->lang['module_vars']['db']['dbname'];?>:</label>
                            <?php echo $setup->input('text','db','dbname'); ?>
                        </div>
                        <div class="row">
                            <label><?php echo $setup->lang['module_vars']['db']['dbdriver'];?>:</label>
                            <?php echo $setup->input('radio','db','dbdriver',null,true,'mysql'); ?> MySQL
                            <?php echo $setup->input('radio','db','dbdriver',null,true,'mysqli'); ?> MySQLi
                        </div>
                    </section>
                    <section class="column">
                        <div class="row">
                            <label><?php echo $setup->lang['module_vars']['db']['username'];?>:</label>
                            <?php echo $setup->input('text','db','username',null,true); ?>
                        </div>
                        <div class="row">
                            <label><?php echo $setup->lang['module_vars']['db']['password'];?>:</label>
                            <?php echo $setup->input('password','db','password',null,true); ?>
                        </div>
                    </section>
                </article>
            </article>
            <article class="item">
                <div class="row title">
                    <h3><?php echo $setup->lang['module']['cache']; ?> settings</h3>
                </div>
                <article class="columed-content">
                    <section class="column">
                        <div class="row">
                            <label><?php echo $setup->lang['module_vars']['cache']['use'];?>:</label>
                            <?php echo $setup->input('hidden','cache','condition',null,null,'use'); ?>
                            <?php echo $setup->input('checkbox','cache','use',null,true); ?>
                        </div>
                        <div class="row">
                            <label><?php echo $setup->lang['module_vars']['cache']['cache'];?>:</label>
                            <?php echo $setup->input('radio','cache','cache',null,true,'Memcache'); ?> Memcache
                        </div>
                    </section>
                    <section class="column">
                        <div class="row">
                            <label><?php echo $setup->lang['module_vars']['cache']['host'];?>:</label>
                            <?php echo $setup->input('text','cache','host',null,true); ?>
                        </div>
                        <div class="row">
                            <label><?php echo $setup->lang['module_vars']['cache']['port'];?>:</label>
                            <?php echo $setup->input('text','cache','port',null,true); ?>
                        </div>
                    </section>
                </article>
            </article>
            <?php if($setup->isModuleInstall('compression')): ?>
            <article class="item">
                <div class="row title">
                    <h3><?php echo $setup->lang['module']['compression']; ?> settings</h3>
                </div>
                <article class="columed-content">
                    <section class="column">
                        <div class="row">
                            <label><?php echo $setup->lang['module_vars']['compression']['use'];?>:</label>
                            <?php echo $setup->input('hidden','compression','condition',null,null,'use'); ?>
                            <?php echo $setup->input('checkbox','compression','use',null,true); ?>
                            <?php echo $setup->input('hidden','compression','compression',null,null,'true'); ?>
                        </div>
                    </section>
                </article>
            </article>
            <?php endif; ?>
            <article class="btn">
                <input type="button" value="Back" onclick="window.location.href='?page=module'; return false;"/>
                <input type="submit" value="Next" />
            </article>
        </form>
    </article>
<?php require_once 'footer.php'; ?>