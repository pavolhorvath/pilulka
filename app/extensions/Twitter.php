<?php

namespace app\extensions;

use system\EnvLoader;
use \TwitterAPIExchange;

class Twitter
{
	private TwitterAPIExchange $connection;

	private string $apiUrl = 'https://api.twitter.com/2/';

	private string $methode;

	private string $endPoint;

	private array $params;

	private static array $endPoints = [
		'SearchTweets' => 'tweets/search/recent',
	];

	public function __construct()
	{
		$this->getConnection();
	}

	public function setMethode (string $methode):Twitter
	{
		$this->methode = strtoupper($methode);

		return $this;
	}

	public function setEndPoint (string $endPoint):Twitter
	{
		if (self::$endPoints[$endPoint]) {
			$endPoint = self::$endPoints[$endPoint];
		}

		$this->endPoint = $endPoint;

		return $this;
	}

	private function setGetField ():void
	{
		$getField = '';

		foreach ($this->params as $key => $value) {
			$getField .= !$getField ? '?' : '&';
			$getField .= "{$key}={$value}";
		}

		$this->connection->setGetfield($getField);
	}

	public function setParams (array $params):Twitter
	{
		$this->params = $params;

		return $this;
	}

	public function send ():array
	{
		if ($this->methode == 'GET') {
			$this->setGetField();
		} elseif ($this->methode == 'POST') {
			$this->connection->setPostfields($this->params);
		}

		$url = $this->apiUrl . $this->endPoint;
		$response = $this->connection->buildOauth($url, $this->methode)->performRequest();
		$response = json_decode($response, true);

		return $response;
	}

	private function getConnection ():void
	{
		$auth = array(
			'oauth_access_token' => EnvLoader::getEnvValue('ACCESS_TOKEN'),
			'oauth_access_token_secret' => EnvLoader::getEnvValue('ACCESS_TOKEN_SECRET'),
			'consumer_key' => EnvLoader::getEnvValue('API_KEY'),
			'consumer_secret' => EnvLoader::getEnvValue('API_KEY_SECRET'),
		);

		$this->connection = new TwitterAPIExchange($auth);
	}

	public static function init ():Twitter
	{
		return new Twitter();
	}
}