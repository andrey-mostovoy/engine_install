<?php

class Setup
{
    const SESS_NAME = 'ena_setup';
    
    public $basedir;
    public $modules;
    public $lang;
    /**
     * key_name => file and class name
     * @var type 
     */
    public $main_modules = array(
        'site' => 'Site',
        'db' => 'Db',
        'cache' => 'Cache',
    );
    public static $step_alias = array(
        'welcome',
        'check',
        'module',
        'settings',
        'confirm',
        'process',
    );
    
    protected $zip_file = 'engine.zip';
    /**
     * collect, process, init
     * @var type 
     */
    protected $mode = 'init';
    protected $options;
    
    protected $error = array();
    
    public function __construct()
    {
        if(isset($_SESSION[self::SESS_NAME]['opt']))
        {
             $this->options = unserialize($_SESSION[self::SESS_NAME]['opt']);
        }
        if(isset($_SESSION[self::SESS_NAME]['err']))
        {
             $this->error = $_SESSION[self::SESS_NAME]['err'];
             unset($_SESSION[self::SESS_NAME]['err']);
        }
        
        if(!empty($_POST['collect']))
        {
            $this->setCollectMode();
        }
        elseif(!empty($_POST['do']))
        {
            $this->setProcessMode();
        }
        
        $this->basedir = substr(str_replace('\\',DIRECTORY_SEPARATOR,getcwd()), 0, -6);        //'
        $this->modules = include 'module_list.php';
        $this->lang = include 'lang.php';
    }
    public function __destruct()
    {
        $_SESSION[self::SESS_NAME]['opt'] = serialize($this->options);
    }
    
    public final function setCollectMode()
    {
        $this->mode = 'collect';
    }
    public final function setProcessMode()
    {
        $this->mode = 'process';
    }
    public final function isProcessMode()
    {
        return $this->mode == 'process';
    }
    public final function getOptions()
    {
        return $this->options;
    }
    protected function setErrorToSession($error)
    {
        $_SESSION[self::SESS_NAME]['err'][] = $error;
    }
//    public function run()
//    {
//    }
    public function getNextStep()
    {
        $key = null;

        foreach(Setup::$step_alias as $k => &$sa)
        {
            if(isset($_POST[$sa])
                || (isset($_POST['step']) && $_POST['step'] == $k)
                || (isset($_GET['page']) && $_GET['page'] == $sa)
            ) {
                $key = $k;
                break;
            }
        }
        unset($sa);

        if(is_null($key))
        {
            reset(Setup::$step_alias);
        }

        // get next array item
        if(current(Setup::$step_alias))
        {
            $key = key(Setup::$step_alias);
        }
        
        return Setup::$step_alias[$key];
    }
    
    public final function isErrors()
    {
        return !empty($this->error);
    }
    public final function getErrors()
    {
        return $this->error;
    }
    public function isModuleInstall($module)
    {
        return isset($this->options['modules']['install'][$module]);
    }
    
}
?>