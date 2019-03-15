<?php

namespace App\Helpers;

use SoapClient as PHPSoap;
use Exception;

class SoapClient
{
	private static $instance = null;
	private static $location = null;
	private static $options = [];
	private static $wsdl;
	private static $parameters;

	public static function wsdl(string $wsdl)
	{
		if (Self::$instance === null) {
			Self::$instance = new Self;
		}
		Self::$wsdl = $wsdl;
		return Self::$instance;
	}

	public function location(string $location)
	{
		Self::$location = ['location' => $location];
		return $this;
	}

	public function parameters(array $parameters)
	{
		Self::$parameters = $parameters;
		return $this;
	}

	public function call(string $functionName)
	{
		try {
			$client = new PHPSoap(Self::$wsdl, Self::$options);
			return $client->__soapCall($functionName, Self::$parameters, Self::$location);
		} catch (Exception $e) {
			return false;
		}
	}

	//OPTIONS
	public function trace(bool $trace)
	{
		if ($trace) {
			Self::$options = array_merge(Self::$options, ['trace' => 1]);
		}
		return $this;
	}

	public function exception(bool $exception)
	{
		if ($exception) {
			Self::$options = array_merge(Self::$options, ['exception' => 1]);
		}
		return $this;
	}

	public function timeout(int $timeout)
	{
		Self::$options = array_merge(Self::$options, ['connection_timeout' => $timeout]);
		return $this;
	}

}