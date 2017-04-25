<?php

class router
{
    private $_array = array();
    private $_array_url = array();
    private $_array_parametrs = array();

    private $_controler = '404';

    public function add($url, $controler, $parametrs = null)
    {
        $this->_array_url[] = $url;
        $this->_array_controler[] = $controler;
        if ( is_array($parametrs) ) $this->$_array_parametrs[$controler] = $parametrs;
    }


    public function routing($url)
    {
        if ( strlen($url) > 1 )
        {
            foreach ( $this->_array_url as $item )
            {
                if ( strripos($url, $item) === 0 )
                {
                    $string = str_replace($item.'/','',$url);
                    $array = compact($stringm, '/');
                    
                }
            }
        }
        else
        {
            return 'index';
        }
        if ( in_array($url, $this->_array_url) )
        {
            $key = array_search( $url, $this->_array_url );
            $this->_controler = $this->_array_controler[$key];
            return $this->_controler;
        }
        return false;
    }

    public function is_controler()
    {
        return $this->_controler;
    }
}

?>