<?php
namespace escidoc\client\rest\serviceLocator;

require_once 'HTTP/Request.php';

use escidoc\client\http\HttpMethod;
use escidoc\client\exceptions\TransportException;

use \HTTP_Request;
use \PEAR;
use \Exception;
use \Net_URL;

abstract class RestService {

	/**
	 * @var Net_URL
	 */
	private $serviceAddress;

	/**
	 * @var string
	 */
	private $path;

	/**
	 * @param Net_URL $serviceAddress
	 * @param string $path
	 *
	 * @throws InvalidArgumentException if $serviceAddress or $path are null.
	 */
	public function __construct(Net_URL $serviceAddress, $path) {
		if ($serviceAddress==null) {
			throw new InvalidArgumentException("Please specifiy a serviceAddress.");
		}
		if ($path==null) {
			throw new InvalidArgumentException("Please specify a REST path for this service.");
		}
		$this->serviceAddress = $serviceAddress;
		$this->path = $this->checkPath($path);
	}

	/**
	 *
	 * Enter description here ...
	 * @param string $path
	 * @param HttpMethod $httpMethod
	 * @param mixed $data
	 * @throws InternalClientException
	 */
	protected function send(HttpMethod $httpMethod, $pathExtension, $data=null, $handle=null) {

		$httpRequest = new HTTP_Request($this->serviceAddress->getURL().$this->path.$pathExtension);
		$httpRequest->addCookie('escidocCookie', $handle);
		$httpRequest->setMethod($httpMethod);
		if ($data != null) {
			$httpRequest->setBody($data);
		}
		$this->configureHttpClient($httpRequest);

		$req_err = $httpRequest->sendRequest();
		// catch connection timeouts, connection refused etc.
		if (PEAR::isError($req_err)) {
			throw new TransportException($this->serviceAddress->getURL()." : ".
				$req_err->getMessage(), $req_err->getCode());
		}
		// handle response
		$code = $httpRequest->getResponseCode();
		if (!($code>=200 && $code<=299)) {
			//eSciDocExceptionMapper::eSciDocExceptionMapper($body);
		}
		// TODO use streams
		$body = $httpRequest->getResponseBody();
		$httpRequest->disconnect(); // just in case something went wrong


		$foo = new HTTP_Request_Listener();

		return $body;
	}

	/**
	 *
	 *
	 * @param HTTP_Request $httpRequest
	 */
	private final function configureHttpClient(HTTP_Request $httpRequest) {
		if($httpRequest == null) return;
		// configurations for RestService
		$httpRequest->_allowRedirects = false;

		// read configuration
		//$httpRequest->setProxy(); - depending on the Url
		//$httpRequest->_readTimeout
	}

	/**
	 * Returns the servieAddress URL.
	 *
	 * @return Net_URL The serviceAddress URL
	 */
	public function getServiceAddress() {
		return $this->serviceAddress;
	}

	/**
	 *
	 * @param string $path
	 * @return string
	 */
	private final function checkPath($path) {
		if(strpos($path, "?") === 0) {
			return $path;
		}
		if(strpos($path, "/") !== 0) {
			return "/".$path;
		}
		return $path;
	}
}
?>