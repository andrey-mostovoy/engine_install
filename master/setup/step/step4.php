<?php
//confirm
class Step4 extends Steps
{
    public function __construct()
    {
        parent::__construct();
        if(!isset($this->options['check']) || $this->options['check'] == false)
        {
            $this->setErrorToSession($this->lang['_error']['no_check']);
            header('Location: ?page=check');
        }
        if(!isset($this->options['modules']))
        {
            $this->setErrorToSession($this->lang['_error']['no_module']);
            header('Location: ?page=module');
        }
        if(!isset($this->options['code']))
        {
            $this->setErrorToSession($this->lang['_error']['no_code']);
            header('Location: ?page=settings');
        }
    }
    
    protected function init()
    {
        return true;
    }
    protected function collect()
    {
        $this->options['confirm'] = true;
        return true;
    }
    protected function process()
    {
        sleep(2);
        return true;
    }
    
    public function getModulesToConfirm()
    {
        $setup_modules = array();
        foreach($this->modules as $k => &$v)
        {
            if(!in_array($k, $this->options['modules']['exlude']))
            {
                $setup_modules[$k] = $v;
            }
        }
        unset($v);
        return $setup_modules;
    }
    
    public function getCodeToConfirm()
    {
        $code = array();
        foreach($this->options['code'] as $k => $v)
        {
            if(isset($v['condition']))
            {
                if(isset($v[$v['condition']]) && !empty($v[$v['condition']]))
                {
                    $code[$k] = $v;
                }
                unset($code[$k][$v['condition']], $code[$k]['condition']);
            }
            else
            {
                $code[$k] = $v;
            }
        }
        return $code;
    }
}
?>