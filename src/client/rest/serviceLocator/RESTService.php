<?php
namespace escidoc\client\rest;

use escidoc\client\http\Url;
use escidoc\client\http\HttpMethod;
use escidoc\client\exceptions\TransportException;

use \HTTP_Request;
use \PEAR;
use \Exception;
use \Net_URL;

require_once '../../../ClassLoader.php';
require_once 'HTTP/Request.php';

class RESTService {

	/**
	 * @var Net_URL
	 */
	private $serviceAddress;

	/**
	 * @param Net_URL $serviceAddress
	 */
	public function __construct(Net_URL $serviceAddress) {
		$this->serviceAddress = $serviceAddress;
	}

	/**
	 *
	 * Enter description here ...
	 * @param string $path
	 * @param HttpMethod $httpMethod
	 * @param mixed $data
	 * @throws InternalClientException
	 */
	public function send(HttpMethod $httpMethod, $path, $data=null, $handle=null) {

		$checkedPath = $this->checkPath($path);

		$httpRequest = new HTTP_Request($this->serviceAddress->getURL().$checkedPath);
		$httpRequest->addCookie('escidocCookie', $handle);
		$httpRequest->setMethod($httpMethod);
		if ($data != null) {
			$httpRequest->setBody($data);
		}
		$this->configureHttpClient($httpRequest);

		$req_err = $httpRequest->sendRequest();
		// catch connection timeouts, connection refused etc.
		if (PEAR::isError($req_err)) {
			throw new TransportException($this->serviceAddress->getURL()." : ".$req_err->getMessage(), $req_err->getCode());
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
	public final function configureHttpClient(HTTP_Request $httpRequest) {
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

$r = new RestService(new Net_URL("http://localhost:8080"));
try {
	$r->send(HttpMethod::GET(), "/ir/items");
} catch(Exception $e) {
	echo $e."\n";
}
?>