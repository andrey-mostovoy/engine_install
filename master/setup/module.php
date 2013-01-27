<?php

abstract class Module
{
    protected $depend = array();
    protected $file = array();
    /**
     * Array for default values for code replacements.
     * Optional use. Can set default value inside 
     * {@see $code} option
     * @var array
     */
    protected $default_code = array();
    /**
     * Code raplacements. Consist from default values and conditions
     * when its appear. In cases when need different default value
     * use {@see $default_code}
     * @var array
     */
    protected $code = array();
    
    protected $error = array();
    
    private $path;
    
    public function __construct()
    {
        $this->path = new Path();
    }
    public final function getDepends()
    {
        return $this->depend;
    }
    public final function getFiles()
    {
        return $this->file;
    }
    public final function getCodes()
    {
        return $this->code;
    }
    public function getErrors()
    {
        return $this->error;
    }
    public final function getPathFiles()
    {
        return $this->path->getPathFiles($this->file);
    }
    
    private function getCode($file,$key,$default=false)
    {
        if($default)
            $var = 'default_code';
        else
            $var = 'code';
        if(isset($this->{$var}[$file][$key]))
        {
            if(is_array($this->{$var}[$file][$key]) && isset($this->{$var}[$file][$key]['value']))
            {
                return $this->{$var}[$file][$key]['value'];
            }
            elseif(!is_array($this->{$var}[$file][$key]))
            {
                return $this->{$var}[$file][$key];
            }
        }
        return null;
    }
    public function insertCode($opts=null)
    {
        if(!empty($this->code))
        {
            $code = $this->mergeCodeWithOptions($opts);
            foreach($code as $filename => &$codes)
            {
                if(file_exists($file = $_SERVER['DOCUMENT_ROOT'].'/'.$filename.'.php'))
                {
                    file_put_contents($file,
                            str_replace(
                                    array_map(array($this,'modifyCodeKey'), array_keys($codes)),
                                    array_values($codes),
                                    file_get_contents($file)
                            )
                    );
                    unset($file);
                }
            }
            unset($codes);
        }
    }
    
    private function modifyCodeKey($k)
    {
        return '{=setup:'.strtolower(get_class($this)).':'.$k.'=}';
    }
    
    private function mergeCodeWithOptions($opts=null)
    {
        $code = array();

        foreach($this->code as $ck => &$c)
        {
            foreach($c as $kk => &$cc)
            {
                if(is_array($cc))
                {
                    if(isset($cc['condition']))
                    {
                        if($kk == $cc['condition'])
                        {
                            continue;
                        }
                        
                        // check condition
                        if(isset($opts['code'][strtolower(get_class($this))][$cc['condition']])
                            && isset($opts['code'][strtolower(get_class($this))][$kk])
                        ) {
                            $value = $this->getValue($opts['code'][strtolower(get_class($this))][$kk], $this->getDefaultCodeValue($kk,null,$ck));
                        }
                        else
                        {
                            $value = $this->getDefaultCodeValue($kk,null,$ck);
                        }
                    }
                    else
                    {
                        $value = $this->getDefaultCodeValue($kk,null,$ck);
                    }
                }
                else
                {
                    if(isset($opts['code'][strtolower(get_class($this))][$kk])
                        && !empty($opts['code'][strtolower(get_class($this))][$kk])
                    ) {
                        $value = $this->getValue($opts['code'][strtolower(get_class($this))][$kk], $this->getDefaultCodeValue($kk,null,$ck));
                    }
                    else
                    {
                        $value = $this->getDefaultCodeValue($kk,null,$ck);
                    }
                }

                if(is_bool($value))
                {
                    $value = $value ? 'true' : 'false';
                }
                elseif(is_string($value))
                {
                    $value = '\''.$value.'\'';
                }
                $code[$ck][$kk] = $value;
            }
            unset($cc);
        }
        unset($c);

        return $code;
    }
    private function getValue($val, $def)
    {
        return (!is_string($def) && !is_bool($def)) ? intval($val) : $val;
    }
    public function getDefaultCodeValue($key, $subkey=null, $file=null)
    {
        $value = null;
        if(is_null($file))
        {
            foreach($this->code as $k => &$v)
            {
                $value = $this->getCode($k, $key, true);
                if(is_null($value))
                {
                    $value = $this->getCode($k, $key);
                }
                if(!is_null($value))
                {
                    break;
                }
            }
            unset($v);
        }
        else
        {
            $value = $this->getCode($file, $key, true);
            if(is_null($value))
            {
                $value = $this->getCode($file, $key);
            }
        }
        return $value;
    }
    
    public function validate($code)
    {
        return true;
    }
    protected function validateEmpty($code)
    {
        $empty = false;
        foreach($code as $k => $c)
        {
            if(empty($c))
            {
                $empty = true;
                $this->error[] = 'empty_'.$k;
            }
        }
        return !$empty;
    }
    protected function validateEmptyWithConditions($code)
    {
        $empty = false;
        foreach($this->code as &$mcode)
        {
            foreach($mcode as $f => &$c)
            {
                if(is_array($c))
                {
                    if(isset($c['condition']) && !empty($code[$c['condition']])
                        && empty($code[$f])
                    ) {
                        $empty = true;
                        $this->error[] = 'empty_'.$f;
                    }
                }
                else
                {
                    if(empty($code[$f]))
                    {
                        $empty = true;
                        $this->error[] = 'empty_'.$f;
                    }
                }
            }
            unset($c);
        }
        unset($mcode);
        return !$empty;
    }
}
?>