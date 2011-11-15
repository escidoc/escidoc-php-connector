<?php
namespace escidoc\client\http;

/**
 * Url type.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
class Url {

	/**
	 * @var string
	 */
	private $url;

	/**
	 * @var array
	 */
	private $parsedUrl;

	/**
	 * @param string $url The URL as a string.
	 * @throws IllegalArgumentException if the parsing of the URL fails.
	 */
	public function __construct($urlString) {
		$this->url = $this->normalize($urlString);
		if(!$this->url) {
			throw new InvalidArgumentException("The provided URL is not valid.");
		}
		$this->parsedUrl = parse_url($urlString);
		if(!$this->parsedUrl) {
			throw new InvalidArgumentException("The provided URL is not valid.");
		}
	}

	/**
	 * Returns the scheme of the URL.
	 *
	 * @return string
	 */
	public function getScheme() {
		return $this->parsedUrl['scheme'];
	}

	/**
	 * Returns the host of the URL.
	 *
	 * @return string
	 */
	public function getHost() {
		return $this->parsedUrl['host'];
	}

	/**
	 * Returns the port of the URL.
	 *
	 * @return string
	 */
	public function getPort() {
		return $this->parsedUrl['port'];
	}

	/**
	 * Returns the user of the URL.
	 *
	 * @return string
	 */
	public function getUser() {
		return $this->parsedUrl['user'];
	}

	/**
	 * Returns the pass of the URL.
	 *
	 * @return string
	 */
	public function getPass() {
		return $this->parsedUrl['pass'];
	}

	/**
	 * Returns the path of the URL.
	 *
	 * @return string
	 */
	public function getPath() {
		return $this->parsedUrl['path'];
	}

	/**
	 * Returns the query of the URL.
	 *
	 * @return string
	 */
	public function getQuery() {
		return $this->parsedUrl['query'];
	}

	/**
	 * Returns the fragment of the URL.
	 *
	 * @return string
	 */
	public function getFragment() {
		return $this->parsedUrl['fragment'];
	}

	/**
	 * Returns the URL itself as the string representation.
	 *
	 * @return string The URL itself.
	 */
	public function __toString() {
		return $this->url;
	}

	/**
	 *
	 *
	 * @param string $url
	 */
	private function normalize($url) {
		if($url == null) return false;
		if(strrpos($url, "/") === strlen($url)-1) {
			return substr($url, 0, strlen($url)-1);
		}
		return $url;
	}
}
?>