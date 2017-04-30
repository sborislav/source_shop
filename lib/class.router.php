<?php

class router
{
    private $_array_url = array();
    private $_array_controler = array();
    private $_array_parametrs = array();

    private $_controler = 'error404';
    private $_parametrs = array();

    private $system_class;

    public function __construct($system)
    {
        $this->system_class = $system;
        $this->loadConfig();
    }

    private function loadConfig()
    {
        require_once SYSTEM.'/config/router.cfg.php';
    }

    public function add($url, $controler, $parametrs = null)
    {
        $this->_array_url[] = $url;
        $this->_array_controler[] = $controler;
        if ( is_array($parametrs) ) $this->_array_parametrs[$controler] = $parametrs;
    }

    public function routing($url)
    {
        $true = false;
        if ( strlen($url) > 1)
        {
            foreach ( $this->_array_url as $item )
            {
/*
                echo 'url = '.$url.'<br>';
                echo 'item = '.$item.'<br>';
                var_dump(strripos($url, $item) === 0);
                echo '<br>';
                var_dump(substr($url, strlen($item), 1) == '/');
                echo '<br>';
                var_dump(substr($url,-1) == substr($item, -1));
                echo '<br>';
*/

                if ( strripos($url, $item) === 0 && ( substr($url, strlen($item), 1) == '/' || substr($url,-1) == substr($item, -1) ) )
                {
                    $key = array_search( $item, $this->_array_url );
                    $this->_controler = $this->_array_controler[$key];

                    $string = str_replace($item.'/','',$url);

                    $array = explode('/', $string);

                    if ( isset($this->_array_parametrs[$this->_controler]) && count($this->_array_parametrs[$this->_controler]) > 0 )
                    {
                        if ( count($array) == count($this->_array_parametrs[$this->_controler]) && count($this->_array_parametrs[$this->_controler]) > 0 )
                        {
                            $true = true;
                            $i = 0;
                            foreach ($this->_array_parametrs[$this->_controler] as $value)
                            {
                                $this->_parametrs[$value] = $array[$i];
                                $i +=1;
                            }
                        }
                    }
                    else
                        $true = true;
                }
            }
            if ( !$true ) $this->_controler = 'error404';
        }
        else
        {
            $this->_controler = 'index';
        }
        if ( !$this->system_class->is_install() ) $this->_controler = 'install';
    }

    public  function is_parametrs()
    {
        return $this->_parametrs;
    }

    public function getController()
    {
        return $this->_controler;
    }

    public function loadController()
    {
        require_once SYSTEM . '/controller/Controller.php';
        require_once SYSTEM . '/controller/'.$this->_controler.'Controller.php';
    }

    public function start()
    {
        $REQUEST = substr($_SERVER['REQUEST_URI'], strlen($this->system_class->getSystemArray()['url']) );

        //$REQUEST = str_replace($dir,'',$_SERVER['REQUEST_URI']);
        if ( substr($REQUEST, -1) == '/' && strlen($REQUEST) > 1 ) $REQUEST = substr($REQUEST, 0, -1);

        $this->routing($REQUEST);
        return $this;
    }

}

?>