<?php

    $factory = new StepFactory();
    $setup = $factory->getStep();
    if($setup->run())
    {
        if(!empty($_POST['do']) && $setup->isProcessMode())
        {
            die(json_encode(array('s'=>'ok')));
        }

        if(!empty($_POST))
        {
            header('Location: ?page='.$setup->getNextStep());
//            header('Location: http://'
//                    .$_SERVER['HTTP_HOST']
//                    .substr(
//                        $_SERVER['REQUEST_URI'],
//                        0,
//                        ($p = strpos($_SERVER['REQUEST_URI'],'?')) ? $p : strlen($_SERVER['REQUEST_URI'])
//                    )
//                    .'?page='.$setup->getNextStep());
        }
    }
?>