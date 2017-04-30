<?php

class shop_system
{
    public $themes = 'bootstrap';

    private $_config = array();

    private $_public_array = array();

    private $_is_install = false;

    private $_pay_metod = array();

    public function __construct()
    {
        $this->setSystemArray();
        $this->shopLoad();
        if ( file_exists(SYSTEM.'/config/global.cfg.php') )
        {
            require_once SYSTEM.'/config/global.cfg.php';
            if ( $config['is_install'] === true )
            {
                $this->_config = $config;
                $this->_public_array['shop_title'] = $this->getShopTitle();
                $this->_is_install = true;
            }
        }
    }

    public function setSystemArray()
    {
        $this->_public_array['url'] = str_replace('/index.php','',$_SERVER['DOCUMENT_URI']);
    }

    function getSystemArray()
    {
        return $this->_public_array;
    }

    public function is_install()
    {
        return $this->_is_install;
    }

    public function connect($connect = 'default')
    {
        return new SafeMySQL($this->_config['MySQL'][$connect]);
    }

    public function admin()
    {
        return $this->_config['admin'];
    }

    public function shopLoad()
    {
        require_once MODULES.'/pay/autoload.php'; // загрузка систем оплаты
        $this->_pay_metod = $bay_config;
    }

    public function getShopCFG($value = false)
    {
        if ($value)
            return (bool)array_key_exists($value, $this->_pay_metod );
        else
            return $this->_pay_metod;
    }

    public function is_themes()
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
        if ( $li > 1 )
        {
            if ( !empty($this->_config['is_themes']) ) return $this->_config['is_themes'];
        }
        return $this->themes;

    }

    function getShopTitle( )
    {
        return $this->_config['shop_title'];
    }

    public function builder($builder)
    {
        $loader = new Twig_Loader_Filesystem(MODULES.'/themes/'.$this->is_themes());
        $twig = new Twig_Environment($loader, array(
            //   'cache' => SYSTEM.'/cache',
            'cache' => false,));

        if ( !empty($builder) && !is_bool($builder) )
            return $twig->render($builder['twig'].'.html.twig', $builder['parameters']+$this->getSystemArray() );
        else
            return $twig->render('error404.html.twig', $this->getSystemArray() );
    }

    public function builder_debug($builder)
    {
        Header( 'Content-Type: text/plain' );
        Header( 'X-Content-Type-Options: nosniff' );
        $builder['parameters'] += $this->getSystemArray();
        return $builder;
    }




}


?>