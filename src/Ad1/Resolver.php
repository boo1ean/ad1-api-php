<?php namespace Ad1;

use Guzzle\Http\ClientInterface;

class Resolver
{
	/**
	 * Ad1 API endpoint
	 */
	const ENDPOINT = 'http://api.ad1.ru/v1/%s/?key=%s';

	/**
	 * Array of method options which specifies method name, params and stuff
	 */
	protected $key;

	/**
	 * HTTP client
	 */
	protected $adapter;

	/**
	 * @param string $key Ad1 API key
	 */
	public function __construct($key) {
		$this->key = $key;
	}

	/**
	 * Set HTTP adapter
	 * @param Guzzle\Http\ClientInterface $adapter instance of http client
	 */
	public function setAdapter(ClientInterface $adapter) {
		$this->adapter = $adapter;
	}

	/**
	 * Resolve params and call API method
	 * @param array $options API method options
	 * @param array $params method data
	 * @return array API response
	 */
	public function resolve(array $options, array $params) {
		$query = $this->composeQuery($options, $params);
		return $this->adapter->get($query)->send()->json();
	}

	/**
 	 * Compose query url using given options and query params
	 * @param array $options API method options
	 * @param array $params method data
	 * @return string query url
	 */
	public function composeQuery(array $options, array $params) {
		$url   = sprintf(static::ENDPOINT, $options['method'], $this->key);
		$query = '&' . http_build_query($params);
		return $url . $query;
	}
}
