<?php

class Route
{
	private $request;

	private $supportedHttpMethods = [
		'GET',
		'POST',
	];

	public function __construct(IRequest $request)
	{
		$this->request = $request;
	}

	public function __call($name, $args)
	{
		list($route, $method) = $args;

		if (!in_array(strtoupper($name), $this->supportedHttpMethods)) {
			$this->invlaidMethodHandler();
		}

		$this->{strtolower($name)}[$this->formatRoute($route)] = $method;
	}


	private function formatRoute($route) 
	{
		$result = rtrim($route, '/');

		if($result === '') {
			return '/';
		}

		return $result;
	}

	private function invalidMethodHandler()
	{
		header("{$this->request->serverProtocol} 405 Method Not Allowed");
	}

	public function resolve()
	{
		print_r($this->request);
		die();
		$methodDictionary = $this->{strtolower($this->request->requestMethod)};

		$formatedRoute = $this->formatRoute($this->request->requestUri);
		$method = $methodDictionary[$formatedRoute];

		if(is_null($method)) {
			$this->defaultRequestHandler();
			return;
		}

		echo call_user_func_array($method, [$this->request]);
	}

	public function __destruct()
	{
		$this->resolve();
	}
}
