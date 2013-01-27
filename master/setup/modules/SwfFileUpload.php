<?php

class SwfFileUpload extends Module
{
    protected $depend = array(
        'media',
        'curl'
    );
    protected $file = array(
        'class' => array(
            'extension' => array(
                'SwfUpload',
                'SwfUploadSupplier'
            ),
        ),
        'components' => array(
            'SwfUpload',
        ),
        'controllers' => array(
            'SwfUpload',
        ),
        'template' => array(
            'common' => array(
                'elements' => array(
                    'swf_file_upload',
                    'swf_file_upload_js',
                    'swf_file_upload_css',
                    'swf_file_upload_thumbs',
                    'swf_file_upload_thumb_item',
                ),
            ),
        ),
        'js' => array(
            'swf_file_upload',  // dir
        ),
        'css' => array(
            'common' => array(
                'swf_file_upload',
            ),
        ),
        'image' => array(
            'common' => array(
                'swf_file_upload', // dir
            ),
        ),
        'gallery' => array(
            'tmp' => array(	//dir
                'image'		// dir
            ),
        ),
    );
    protected $code = array();
}
?>