<?php

class Compression extends Module
{
    protected $depend = array();
    protected $file = array();
    protected $default_code = array(
        'configs/Config' => array(
            'compression' => false,
        ),
    );
    protected $code = array(
        'configs/Config' => array(
            'use' => array(
                'condition' => 'use',
                'value' => 0,
            ),
            'compression' => array(
                'condition' => 'use',
                'value' => true,
            ),
        ),
    );
    
    public function validate($code)
    {
        $this->validateEmptyWithConditions($code);
        return empty($this->error);
    }
}
?>