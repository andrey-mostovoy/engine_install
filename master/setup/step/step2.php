<?php
//module
class Step2 extends Steps
{
    private $tmp_exlude = array('.htaccess');
    
    public function __construct()
    {
        parent::__construct();
        if(!isset($this->options['check']) || $this->options['check'] == false)
        {
            $this->setErrorToSession($this->lang['_error']['no_check']);
            header('Location: ?page=check');
        }
    }
    protected function init()
    {
        return true;
    }
    protected function collect()
    {
        $this->options['modules']['exlude'] = $this->getExludeModules();
        $this->options['modules']['exlude_files'] = $this->getExludePaths();
        $this->options['modules']['install'] = $this->getInstallModules();
        return true;
    }
    protected function process()
    {
        if(!isset($_SESSION[self::SESS_NAME]['step2phase']))
        {
            if($this->unzip())
            {
                $_SESSION[self::SESS_NAME]['step2phase'] = '1';
                return true;
            }
        }
        else
        {
            if($this->unzip($this->tmp_exlude))
            {
                unset($_SESSION[self::SESS_NAME]['step2phase']);
                return true;
            }
        }
        return false;
    }
    private function unzip($enties=null)
    {
        $za = new ZipArchive();

        $za->open($this->zip_file);

        if(is_null($enties))
        {
            $enties = array();
            for ($i=0; $i<$za->numFiles;$i++)
            {
                $stat = $za->statIndex($i);

                //if not found name in excuded modules then process it
                if(!$this->isInExludes($stat['name']))
                {
                    $enties[] = $stat['name'];
                }
            }
        }
        return $za->extractTo($this->basedir, $enties);
    }
    private function getInstallModules()
    {
        $install_modules = $this->main_modules;
        foreach($this->modules as $k=>&$v)
        {
            if(!in_array($k, $this->options['modules']['exlude']))
            {
                $install_modules[$k] = $v;
            }
        }
        unset($v);
        return $install_modules;
    }
    private function getExludeModules()
    {
        if(!isset($_POST['module']) || empty($_POST['module']))
        {
            return array_keys($this->modules);
        }
        $exlude_modules = array();
        $install_modules = $_POST['module'];
        foreach($this->modules as $k=>&$v)
        {
            if(!in_array($k, $install_modules))
            {
                $exlude_modules[] = $k;
            }
        }
        unset($v);
        return $exlude_modules;
    }
    private function getExludePaths()
    {
        $paths = $this->tmp_exlude;
        foreach($this->options['modules']['exlude'] as &$em)
        {
            $class = $this->modules[$em];
            $module = new $class();
            $paths = array_merge($paths, $module->getPathFiles());
        }
        unset($em);
        return $paths;
    }
    private function isInExludes($name)
    {
        foreach($this->options['modules']['exlude_files'] as &$f)
        {
            if(false !== strpos($name, $f))
                return true;
        }
        unset($f);
        return false;
    }
}
?>