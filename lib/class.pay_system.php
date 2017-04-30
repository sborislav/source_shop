<?php

class Pay_system
{
    private $_form = array();
    private $_action = '';
    private $_price = 0;
    private $_id = 0;

    private $_result = array();

    function buildingForm()
    {
        return $this;
    }



    function form_action($value)
    {
        $this->_action = $value;
        return $this;
    }

    function index($name, $value)
    {
        $this->_form[$name] = $value;
        return $this;
    }

    function resultParam($name, $value)
    {
        $this->_result[$name] = $value;
        return $this;
    }

    function getParam($name)
    {
        return $this->_result[$name];
    }

    function setSum($price)
    {
        $this->_price = $price;
    }

    function getSum()
    {
        return $this->_price;
    }

    function setID($price)
    {
        $this->_id = $price;
    }

    function getID()
    {
        return $this->_id;
    }

    function getHASH($metod, $string)
    {
        $metod = strtolower($metod);
        return hash ( $metod , $string);
    }

    function builderForm()
    {
        return array(
            'action' => $this->_action,
            'form' => $this->_form,
        );
    }


    function addProduct()
    {
        $product = new Product();
        return $product;
    }

    function addBay()
    {
        $log = new log();
        return $log;
    }

    function GetIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
}

class Product
{
    private $id;
    private $price;
    private $title;
    private $description;
    private $date;
    private $query;

    public function setID($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setPrice($price)
    {
        $this->price = $price;
        return $this;
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setDate($date )
    {
        $this->date = $date;
        return $this;
    }

    public function setQuery($query)
    {
        $this->query = $query;
        return $this;
    }
}

Class log
{
    private $id;
    private $product_id;
    private $steam;
    private $ip;
    private $server_id;
    private $date;
    private $success;

    public function setID($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setProduct_id($product_id)
    {
        $this->product_id = $product_id;
        return $this;
    }

    public function setSteam($steam)
    {
        $this->steam = $steam;
        return $this;
    }

    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    public function setServer_id($server_id )
    {
        $this->server_id = $server_id;
        return $this;
    }

    public function setDate($date)
    {
        $this->date = $date->format('Y-m-d H:i:s');
        return $this;
    }

    public function setSuccess($success)
    {
        $this->success = $success;
        return $this;
    }

    public function Query($connect)
    {
        if ( is_numeric($this->id) )
            $sql = 'INSERT INTO `bay_log` (`id`, `product_id`, `steam`, `ip`, `server_id`, `date`, `success`) VALUES ( ?i, ?i, ?s, ?s, ?i, ?s, ?i)';
        else
            $sql = 'INSERT INTO `bay_log` (`id`, `product_id`, `steam`, `ip`, `server_id`, `date`, `success`) VALUES ( ?s, ?i, ?s, ?s, ?i, ?s, ?i)';
        $connect->query($sql,
            $this->id,
            $this->product_id,
            $this->steam,
            $this->ip,
            $this->server_id,
            $this->date,
            $this->success
            );
        return $connect->insertId();
    }
}

?>