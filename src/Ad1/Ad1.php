<?php namespace Ad1;

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

	/**
	 * Proxy for API methods defined in methods map property
	 * @param string $name method alias
	 * @param array $args method args
	 * @return array API response
	 * @throws BadMethodCallException if method doesn't exist
	 * @throws InvalidArgumentException for wrong args
	 */
	public function __call($name, $args) {
		if (!array_key_exists($name, $this->methods)) {
			throw new \BadMethodCallException(sprintf('Method %s does not exist.', $name));
		}

		$params = reset($args) ?: array();
		if ($params && !is_array($params)) {
			throw new \InvalidArgumentException('Request params must be an array.');
		}

		return $this->resolver->resolve($this->methods[$name], $params);
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
