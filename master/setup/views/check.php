<?php require_once 'header.php'; /*step 2*/?>
    <article class="items">
        <?php include 'error.php'; ?>
    </article>
    <article class="item check">
        <div class="row title">
            <h3>System check</h3>
        </div>
        <div class="row">
            <table>
                <?php $fail = false; foreach($setup->getSystemCheck() as $c): 
                    $supported = $c[1] == $c[2];
                    if($supported)
                    {
                        $class = 'ok';
                    }
                    else
                    {
                        $class = 'fail';
                        $fail = true;
                    }?>
                <tr class="<?php echo $class; ?>">
                    <td class="<?php echo $class; ?>"></td>
                    <td><?php echo $c[0]; ?></td>
                    <td><?php echo $c[3]; ?></td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </article>
    <article class="btn">
        <form action="" method="post">
            <input type="hidden" name="collect" value="2" />
            <input type="hidden" name="check" value="1" />
            <?php if(!$fail): ?>
            <input type="submit" value="Next" />
            <?php endif; ?>
        </form>
    </article>
<?php require_once 'footer.php'; ?>