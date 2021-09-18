<?php

namespace system;

use eftec\bladeone\BladeOne;

class View
{
	/**
	 * @var BladeOne
	 */
	private BladeOne $blade;

	/**
	 * View constructor.
	 */
	public function __construct ()
	{
		$this->blade = new BladeOne(
			__DIR__.'/../resources/views',
			__DIR__.'/../data/compiledViews'
		);
		$baseUrl = (strpos($_SERVER['SERVER_PROTOCOL'], 'HTTPS') !== false ? 'https://' : 'http://') . $_SERVER['SERVER_NAME'];
		$this->blade->setBaseUrl($baseUrl);
	}

	/**
	 * @param string $view
	 * @param array  $variables
	 *
	 * @return string
	 */
	public function render (string $view, array $variables = []):void
	{
		$html = $this->blade->run($view, $variables);

		echo $html;
		exit();
	}

	/**
	 * @param string $view
	 * @param array  $variables
	 *
	 * @return string
	 */
	public function get (string $view, array $variables = []):string
	{
		$html = $this->blade->run($view, $variables);

		return $html;
	}

	/**
	 * @return View
	 */
	public static function init ():View
	{
		return new View();
	}
}