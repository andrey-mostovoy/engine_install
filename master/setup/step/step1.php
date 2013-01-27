<?php
// check
class Step1 extends Steps
{
    protected function init()
    {
        return true;
    }
    protected function collect()
    {
        $this->options['check'] = true;
        return true;
    }
    protected function process()
    {
        return true;
    }
    
    public function getSystemCheck()
    {
        $target_php_ver = '5.2.0';
        
        $requirements = array(
            array(
                $this->lang['check']['zip_ext'],
                true,
                extension_loaded('zip'),
                $this->lang['check']['comment']['zip_ext'],
            ),
            array(
                $this->lang['check']['php_ver'],
                true,
                version_compare(PHP_VERSION, $target_php_ver, ">="),
                str_replace('{ver}',$target_php_ver,$this->lang['check']['comment']['php_ver']),
            ),
            array(
                $this->lang['check']['write_inst_dir'],
                true,
                is_writeable($this->basedir),
                $this->lang['check']['comment']['write_inst_dir'],
            ),
            array(
                $this->lang['check']['pcre_ext'],
                true,
                extension_loaded("pcre"),
                $this->lang['check']['comment']['pcre_ext'],
            ),
            array(
                $this->lang['check']['spl_ext'],
                true,
                extension_loaded("SPL"),
                $this->lang['check']['comment']['spl_ext'],
            ),
            array(
                $this->lang['check']['mysql_ext'],
                true,
                extension_loaded('mysql'),
                $this->lang['check']['comment']['mysql_ext'],
            ),
            array(
                $this->lang['check']['gd_ext'],
                true,
                ($message = $this->checkGD()) === '',
                $message
            ),
            array(
                $this->lang['check']['finfo_ext'],
                true,
                class_exists('finfo') || function_exists('mime_content_type'),
                $this->lang['check']['comment']['finfo_ext'],
            ),
            array(
                $this->lang['check']['curl_ext'],
                true,
                function_exists('curl_init'),
                $this->lang['check']['comment']['curl_ext'],
            ),
            array(
                $this->lang['check']['json_ext'],
                true,
                function_exists('json_decode'),
                $this->lang['check']['comment']['json_ext'],
            ),
        );
        
        return $requirements;
    }
    
    private function checkGD()
    {
        if(extension_loaded('gd'))
        {
            $gdinfo = gd_info();
            if ($gdinfo['FreeType Support'])
                return '';
            return 'GD installed<br />FreeType support not installed';
        }
        return 'GD not installed';
    }
}
?>