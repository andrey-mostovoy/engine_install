<?php

    interface NamingStrategy
    {
        function createName();
    }

    class SetupViews
    {
        public function getViewStrategy()
        {
            $class = 'DefaultNamingStrategy';
            
            foreach(Setup::$step_alias as $k => &$sa)
            {
                if(isset($_POST[$sa])
                    || (isset($_POST['step']) && $_POST['step'] == $k)
                    || (isset($_GET['page']) && $_GET['page'] == $sa)
                ) {
                    $class = ucfirst($sa).'NamingStrategy';
                    break;
                }
            }
            unset($sa);
            if(!@class_exists($class))
            {
                $class = 'StepViews';
            }
            return new Context(new $class());
        }
    }
    class StepViews implements NamingStrategy
    {
        function createName()
        {
            $key = null;
            $view_file = null;
            
            if(!isset($_GET['page']))
            {
                foreach(Setup::$step_alias as $k => &$sa)
                {
                    if(isset($_POST[$sa])
                        || (isset($_POST['step']) && $_POST['step'] == $k)
                    ) {
                        $key = $k;
                        break;
                    }
                }
                unset($sa);
            }
            
            // get next array item
            if(!isset($_GET['page']))
            {
                $view_file = current(Setup::$step_alias);
                if(!$view_file && $key)
                {
                    $view_file = Setup::$step_alias[$key];
                }
                else
                {
                    $key = key(Setup::$step_alias);
                }
            }
            else
            {
                $view_file = $_GET['page'];
                $key = array_search($_GET['page'], Setup::$step_alias);
            }
            
            if(!file_exists('views/'.$view_file.'.php'))
            {
                $view_file = 'step'.$key;
            }
            return 'views/'.$view_file.'.php';
        }
    }
    // show by step
    class StepNamingStrategy extends StepViews implements NamingStrategy
    {
        function createName()
        {
            if(isset($_POST['step']) && file_exists('views/step'.($_POST['step']+1).'.php'))
            {
                return 'views/step'.($_POST['step']+1).'.php';
            }
            elseif(isset($_GET['page']) && $_GET['page'] == 'step' && isset($_GET['s']))
                return 'views/step'.$_GET['s'].'.php';
            return 'views/confirm.php';
        }
    }
    // show by alias
//    class WelcomeNamingStrategy extends StepViews implements NamingStrategy
//    {
//    }
    class CheckNamingStrategy extends StepViews implements NamingStrategy
    {
    }
    class ConfirmNamingStrategy extends StepViews implements NamingStrategy
    {
    }
    class DefaultNamingStrategy extends StepViews implements NamingStrategy
    {
        function createName()
        {
            return 'views/welcome.php';
        }
    }

    class Context
    {
        private $namingStrategy;
        function __construct(NamingStrategy $strategy)
        {
            $this->namingStrategy = $strategy;
        }
        function execute()
        {
            return $this->namingStrategy->createName();
        }
    }
    
//    $context = new Context(new StepViews());
//    include_once $context->execute();
    $view_factory = new SetupViews();
    $context = $view_factory->getViewStrategy();
    include_once $context->execute();
?>