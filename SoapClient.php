<?php

namespace App\Helpers;

use SoapClient;
use Exception;

class PHPSoapClient
{
    private static $instance = null;
    private static $location = null;
    private static $options = [];
    private static $wsdl;
    private static $parameters;

    public static function wsdl($wsdl)
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        self::$wsdl = $wsdl;
        return self::$instance;
    }

    public function location($location)
    {
        self::$location = ['location' => $location];
        return $this;
    }

    public function parameters($parameters)
    {
        self::$parameters = $parameters;
        return $this;
    }

    public function call($functionName)
    {
        try {
            $client = new SoapClient(self::$wsdl, self::$options);
            return $client->__soapCall($functionName, self::$parameters, self::$location);
        } catch (Exception $e) {
            return false;
        }
    }

    //OPTIONS
    public function trace($trace)
    {
        if ($trace) {
            self::$options = array_merge(self::$options, ['trace' => 1]);
        }
        return $this;
    }

    public function exception($exception)
    {
        if ($exception) {
            self::$options = array_merge(self::$options, ['exception' => 1]);
        }
        return $this;
    }

    public function timeout($timeout)
    {
        self::$options = array_merge(self::$options, ['connection_timeout' => $timeout]);
        return $this;
    }

}