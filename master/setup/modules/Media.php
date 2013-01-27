<?php

class Media extends Module
{
    protected $depend = array();
    protected $file = array(
        'class' => array(
            'Common' => array(
                'Media',
            ),
            'extension' => array(
                'Media'
            ),
        ),
        'libs' => array(
            'media',	// dir
        ),
    );
    protected $code = array();
}
?>