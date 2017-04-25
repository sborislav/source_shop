<?php


class install extends shop_system
{

    private $_config = array();


    public function is_install()
    {
        if ( file_exists(SYSTEM.'/config/global.cfg.php') )
        {
            require_once SYSTEM.'/config/global.cfg.php';
            if ( $config['is_install'] === true )
            {
                $this->_config = $config;
                return true;
            }
        }
        return false;
    }


    public function page()
    {
        if ( parent::themes_int() > 1 )
        {
            if ( empty($this->_config['is_themes']) ) return $config['is_themes'];
        }
        return $this->themes;
    }




}




?>
