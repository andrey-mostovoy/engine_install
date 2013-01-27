<?php
// settings
class Step3 extends Steps
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
    }
    protected function init()
    {
        return true;
    }
    protected function collect()
    {
        if(!empty($_POST['code']))
        {
            foreach($_POST['code'] as $k=>&$c)
            {
                $code = explode('.', $k);
                if(isset($code[2]))
                    $this->options['code'][$code[0]][$code[1]][$code[2]] = $c;
                else
                    $this->options['code'][$code[0]][$code[1]] = $c;
            }
            unset($c,$code);
        }
        if(!empty($_POST['unset']))
        {
            foreach($_POST['unset'] as $k=>&$u)
            {
                if(!isset($_POST['code'][$k]))
                {
                    $code = explode('.', $k);
                    if(isset($code[2]))
                        unset($this->options['code'][$code[0]][$code[1]][$code[2]]);
                    else
                        unset($this->options['code'][$code[0]][$code[1]]);
                }
            }
            unset($u);
        }
        return $this->validate();
    }
    protected function process()
    {
        if(!isset($_SESSION[self::SESS_NAME]['step3phase']))
        {
            $modules = $this->main_modules+$this->modules;
            foreach($modules as &$m)
            {
                $module = new $m();
                $module->insertCode($this->options);
            }
            unset($m, $module);
            
            $_SESSION[self::SESS_NAME]['step3phase'] = '1';
        }
        else
        {
            unset($_SESSION[self::SESS_NAME]['step3phase']);
        }
        return true;
    }
    private function validate()
    {
        $modules = $this->options['modules']['install'];
        foreach($this->options['code'] as $m => &$code)
        {
            $module = new $modules[$m]();
            if(!$module->validate($code))
            {
                foreach($module->getErrors() as $er)
                {
                    if(isset($this->lang['_error']['module'][$m][$er]))
                        $this->error[] = $this->lang['_error']['module'][$m][$er];
                    else
                        $this->error[] = $er;
                }
            }
        }
        unset($code);
        return empty($this->error);
    }

    public final function input($type,$module,$code,$sub=null,$def='',$val='')
    {
        $csub = empty($sub) ? '' : '.'.$sub;
        switch($type)
        {
            case 'hidden':
                return <<<EOD
                <input type="hidden" name="code[$module.$code$csub]" value="$val" />
EOD;
                break;
                break;
            case 'text':
            case 'password':
                return <<<EOD
                <input type="$type" name="code[$module.$code$csub]" value="{$this->code($module,$code,$sub,$def)}" />
EOD;
                break;
            case 'checkbox':
                $checked = $hidden = '';
                if('' != $this->code($module,$code,$sub,$def))
                {
                    $checked = 'checked="checked"';
                    $hidden = <<<EOD
                    <input type="hidden" name="unset[$module.$code$csub]" value="1" />
EOD;
                }
                return <<<EOD
                $hidden
                <input type="checkbox" name="code[$module.$code$csub]" value="1" $checked />
EOD;
                break;
            case 'radio':
                $checked = $hidden = '';
                if($val == $this->code($module,$code,$sub,$def))
                {
                    $checked = 'checked="checked"';
                    $hidden = <<<EOD
                    <input type="hidden" name="unset[$module.$code$csub]" value="1" />
EOD;
                }
                return <<<EOD
                $hidden
                <input type="radio" name="code[$module.$code$csub]" value="$val" $checked />
EOD;
                break;
        }
    }
    public function code($module,$code,$sub=null,$def='')
    {
        if($def === true)
        {
            $c = ucfirst($module);
            $m = new $c();
            $value = $m->getDefaultCodeValue($code,$sub);
        }
        else
        {
            $value = $def;
        }
        if(isset($this->options['code'])
            && !empty($module) && !empty($code)
        ) {
            if(!empty($sub))
            {
                if(isset($this->options['code'][$module][$code][$sub]))
                    $value = $this->options['code'][$module][$code][$sub];
            }
            else
            {
                if(isset($this->options['code'][$module][$code]))
                    $value = $this->options['code'][$module][$code];
            }
        }
        return $value;
    }
}
?>