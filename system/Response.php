<?php

namespace system;

/**
 * Class MyResponse
 * @author Ing. Pavol Horvath
 */
class Response
{
	/**
	 * @var mixed
	 */
	private $response = '';

	/**
	 * @param mixed $response
	 *
	 * @return $this
	 */
	public function json (mixed $response):Response
	{
		header('Content-Type: application/json');
		$this->response = json_encode($response);

		return $this;
	}

	/**
	 * @param string $msg
	 * @param bool   $asJson
	 */
	public function unauthorized (string $msg = 'Unauthorized', bool $asJson = true):void
	{
		http_response_code(401);

		if ($asJson) {
			$this->json($msg)->send();
		}

		echo $msg;
		exit();
	}

	/**
	 *
	 */
	public function send ():void
	{
		echo $this->response;
		exit();
	}

	/**
	 * @return Response
	 */
	public static function init ():Response
	{
		return new Response();
	}
}