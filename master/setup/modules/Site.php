<?php

class Site extends Module
{
    protected $depend = array();
    protected $file = array();
    protected $code = array(
        'configs/Config' => array(
            'name' => 'test name',
            'debug' => 1,
            'admin_url' => 'admin',
            'theme' => 'default',
        ),
    );
    
    public function validate($code)
    {
        foreach($code as $k => $c)
        {
            if($k != 'debug' && empty($c))
            {
                $this->error[] = 'empty_'.$k;
            }
        }
        if(!isset($code['debug']))
        {
            $this->error[] = 'empty_debug';
        }
        return empty($this->error);
    }
}
?>