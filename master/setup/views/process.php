<?php require_once 'header.php'; ?>
<style>
	.ui-progressbar-value { background-image: url(views/image/pbar-ani.gif); }
</style>
<script type="text/javascript">
    var queue = [];
    var status_text = [];
    var current = null;
    var send_data;
    $(document).ready(function(){
        $("#progressbar").progressbar({
            value: 0
        });
        process();
    });
    <?php foreach($setup->getProcessQueue() as $q): ?>
        queue.push('<?php echo $q; ?>');
    <?php endforeach; ?>
    <?php foreach($setup->getProcessStatusText() as $st): ?>
        status_text.push('<?php echo $st; ?>');
    <?php endforeach; ?>

    function process()
    {
        if(current == null)
            current = 0;
        else
            current++;
        
        if(queue[current] != undefined)
        {
            send_data={};
            send_data['do'] = '3';
            send_data['step'] = queue[current];
            
            var persend = ((current+1)*100/queue.length);
            
            $.ajax({
                url: '/setup/',
                type: 'post',
                dataType: 'json',
                data: send_data,
                beforeSend: function(){
                    $('.loading').show();
                    $('#progress_status').text(status_text[current]);
                    $('#progressbar .ui-progressbar-value').show().animate({width: persend+'%'}, 5000);
                },
                success: function(r){
                    if(r.s == 'ok')
                    {
                        $('#progressbar .ui-progressbar-value').stop(true,true);
                        $("#progressbar").progressbar("value",persend);
                        if((current+1) < queue.length)
                        {
                            process();
                        }
                        else
                        {
                            $('#progress_status').text('<?php echo $setup->lang["process"]["done"];?>');
                            $('.loading').add("#progressbar").hide();
                        }
                    }
                    else
                    {
                        $('.loading').hide();
                    }
                }
            });
        }
    }
</script>
<article class="items">
    <article class="item">
        <section class="progressblock">
            <div class="loading left">
                <img src="views/image/ajax_loader1.gif" />
            </div>
            <section class="progress">
                <div class="title">
                    <h3 id="progress_status"></h3>
                </div>
                <div id="progressbar"></div>
            </section>
            <div class="loading right">
                <img src="views/image/ajax_loader2.gif" />
            </div>
        </section>
    </article>
</article>
<?php require_once 'footer.php'; ?>