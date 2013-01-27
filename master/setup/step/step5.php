<?php
//process
class Step5 extends Steps
{
    public function __construct()
    {
        parent::__construct();
        if(!isset($this->options['check']) || $this->options['check'] == false)
        {
            $this->setErrorToSession($this->lang['_error']['no_check']);
            header('Location: ?page=check');
        }
        if(!isset($this->options['confirm']) || $this->options['confirm'] == false)
        {
            $this->setErrorToSession($this->lang['_error']['no_confirm']);
            header('Location: ?page=confirm');
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
        return true;
    }
    protected function process()
    {
        sleep(3);
        return true;
    }
    
    public function getProcessQueue()
    {
        return array(
            '2', // extract files
            '3', // change placeholders to code values
            '3', // install db
            '2', // extract .htaccess file
            '5', // delete setup directory
        );
    }
    public function getProcessStatusText()
    {
        return array(
            $this->lang['process']['module'],
            $this->lang['process']['2'],
            $this->lang['process']['3'],
            $this->lang['process']['3'],
            $this->lang['process']['3'],
        );
    }
}
?>