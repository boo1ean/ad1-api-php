<?php namespace Ad1;

require '../vendor/autoload.php';
require 'Resolver.php';

use Guzzle\Http\ClientInterface;
use Guzzle\Http\Client;

class Ad1
{
	/**
	 * API methods map
	 */
	protected $methods = array(
		'categories' => array(
			'method' => 'Categories'
		),
		'geoCodes' => array(
			'method' => 'GeoCodes'
		),
		'geoCodeInfo' => array(
			'method' => 'GeoCodeInfo'
		),
		'wmOffers' => array(
			'method' => 'WmOffers'
		),
		'wmMyOffers' => array(
			'method' => 'WmMyOffers'
		),
		'wmSources' => array(
			'method' => 'WmSources'
		),
		'wmLinks' => array(
			'method' => 'WmLinks'
		),
		'wmSubaccounts' => array(
			'method' => 'WmSubaccounts'
		),
		'wmStats' => array(
			'method' => 'WmStats'
		)
	);

	/**
	 * API methods resolver
	 */
	protected $resolver;

	/**
	 * Initialize resolver instance with API key
	 *
	 * @param string $key ad1 API key
	 */
	public function __construct($key) {
		$this->resolver = new Resolver($key);
		$this->setDefaultAdapter();
	}

	public function __call($name, $args) {
		if (!array_key_exists($name, $this->methods)) {
			throw new \BadMethodCallException(sprintf('Method %s does not exist.', $name));
		}

		$params = reset($args);
		if ($params && !is_array($params)) {
			throw new \InvalidArgumentException('Request params must be an array.');
		}

		return $this->resolver->resolve($this->methods[$name], $params);
	}

	protected function get($url) {
		$response = $this->adapter->get($url)->send();
		var_dump($response->json());
	}

	/**
	 * Set HTTP adapter
	 * @param Guzzle\Http\ClientInterface $adapter instance of http client
	 */
	public function setAdapter(ClientInterface $adapter) {
		$this->resolver->setAdapter($adapter);
	}

	/**
 	 * Set default http adapter Guzzle\Http\Client
	 */
	public function setDefaultAdapter() {
		$this->setAdapter(new Client());
	}
}
