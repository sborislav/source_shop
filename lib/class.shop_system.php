<?php

class shop_system
{
    public $themes = 'bootstrap';

    public function themes_int()
    {
        $dir = MODULES.'/themes';
        $files1 = scandir($dir);
        $li = 0;
        for ($i = 0; $i != count($files1); $i++) {
            if ( $i < 2 ) continue;

            if ( is_dir($dir.'/'.$files1[$i]) )
            {
                $this->themes = $files1[$i];
                $li += 1;
            }
        }
        return $li;
    }

    public function routing()
    {

    }

    function test( )
    {
        return true;
    }
}


?>