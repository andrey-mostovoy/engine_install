<?php

interface Step
{
    public function run();
}

class StepFactory
{
    public function getStep()
    {
        $class = 'Step1';
        if(isset($_POST['step']))
        {
            $class = 'Step'.$_POST['step'];
        }
        else
        {
            foreach(Setup::$step_alias as $k => &$sa)
            {
                if(isset($_POST[$sa])
                    || (isset($_POST['step']) && $_POST['step'] == $k)
                    || (isset($_GET['page']) && $_GET['page'] == $sa)
                ) {
                    $class = 'Step'.$k;
                    break;
                }
            }
            unset($sa);
        }
        
        return new $class();
    }
}

abstract class Steps extends Setup implements Step
{
    public function run()
    {
        return $this->{$this->mode}();
    }
    abstract protected function init();
    abstract protected function collect();
    abstract protected function process();
}
?>