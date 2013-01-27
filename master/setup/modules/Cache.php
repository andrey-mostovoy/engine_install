<?php

class Cache extends Module
{
    protected $depend = array();
    protected $file = array();
    protected $default_code = array(
        'configs/Config' => array(
            'host' => '',
            'port' => '',
        ),
    );
    protected $code = array(
        'configs/Config' => array(
            'use' => array(// this trick for not validate condition itself
                'condition' => 'use',
                'value' => 0,
            ),
            'cache' => array(
                'condition' => 'use',
                'value' => false,//'Memcache',
            ),
            'host' => array(
                'condition' => 'use',
                'value' => 'localhost'
            ),
            'port' => array(
                'condition' => 'use',
                'value' => '11211'
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