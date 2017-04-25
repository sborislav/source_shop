<?php

class install
{

    public function is_install()
    {
        if ( file_exists(SYSTEM.'/config/global.cfg') )
        {
            require_once SYSTEM.'/config/global.cfg';
            if ( $is_install === true )
            {
                return true;
            }
        }
        return false;
    }

}

?>
