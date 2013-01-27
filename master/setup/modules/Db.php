<?php

class Db extends Module
{
    protected $depend = array();
    protected $file = array();
    protected $code = array(
        'configs/Config' => array(
            'server' => 'localhost',
            'username' => 'dbusername',
            'password' => 'dbpassword',
            'dbname' => 'dbname',
            'dbdriver' => 'mysqli',
        ),
    );
    
    public function validate($code)
    {
        if($this->validateEmpty($code))
        {
            $this->tryConnect($code);
        }
        return empty($this->error);
    }
    private function tryConnect($code)
    {
        $error = false;
        $db_error;
        switch($code['dbdriver'])
        {
            case 'mysql':
                $mysql = @mysql_connect($code['server'], $code['username'], $code['password']);

                if( !$mysql )
                {
                    $error = 'fail_connect';
                    $db_error = mysql_error();
                }
                elseif( !@mysql_select_db($code['dbname'], $mysql) )
                {
                    $error = 'fail_connect';
                    $db_error = mysql_error();
                }
                else
                {
                    mysql_close($mysql);
                }
                break;
            case 'mysqli':
                $mysqli = @new mysqli($code['server'], $code['username'], $code['password'], $code['dbname']);
                if (mysqli_connect_errno())
                {
                    $error = 'fail_connect';
                    $db_error = mysqli_connect_error();
                }
                else
                    $mysqli->close();
                break;
            default:
                $error = 'unknown_dbdriver';
                break;
        }
        if($error)
        {
            $this->error[] = $error;
            if(!empty($db_error))
                $this->error[] = $db_error;
            return false;
        }
        return true;
    }
}
?>