<?php

namespace app\controllers;

use app\extensions\Twitter;
use system\EnvLoader;
use system\Response;
use system\View;
/**
 * Class AppController
 */
class AppController
{
	public function index ():void
	{
		View::init()->render('index');
	}

	public function getTweets (array $keyWords, int $tweetsCount = 100):void
	{
		$response = Twitter::init()
			->setMethode('GET')
			->setEndPoint('SearchTweets')
			->setParams([
				'query' => implode(' OR ', $keyWords),
				'max_results' => $tweetsCount,
				'tweet.fields' => 'id,author_id,text,created_at',
				'expansions' => 'author_id',
				'user.fields' => 'name',
			])
			->send();

		$tweets = [];

		if (isset($response['data']) && is_array($response['data'])) {
			$authors = [];
			foreach ($response['includes']['users'] as $user) {
				$authors[$user['id']] = $user['name'];
			}

			foreach ($response['data'] as $tmpTweet) {
				$tweets[] = [
					'id' => $tmpTweet['id'],
					'text' => $tmpTweet['text'],
					'created' => date('d.m.Y H:i:s', strtotime($tmpTweet['created_at'])),
					'author' => $authors[$tmpTweet['author_id']],
				];
			}
		}

		Response::init()->json($tweets)->send();
	}
}