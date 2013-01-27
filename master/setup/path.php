<?php

class Path
{
    private $file_list = array();
    
    public function __construct()
    {
        
    }
    public function __destruct()
    {
        ;
    }
    
    public final function getPathFiles($path_arr)
    {
        if(!empty($this->file_list))
        {
            return $this->file_list;
        }
        $this->getPath($path_arr);
        return $this->file_list;
    }
    
    private function getPath($arr, $path=null)
    {
        $path = is_null($path) ? '' : $path;
        foreach($arr as $k=>$v)
        {
            if(is_array($v))
            {
                $this->getPath($v, $path.$k.'/');
            }
            else
            {
                $this->file_list[] = $path . $v;
            }
        }
        return;
    }
}
?>