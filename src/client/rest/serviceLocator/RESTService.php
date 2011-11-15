<?php
namespace escidoc\client\rest;

require_once '../../../ClassLoader.php';

require_once 'HTTP/Request.php';

use escidoc\client\http\Url;
use escidoc\client\http\HttpMethod;
use escidoc\client\exceptions\InternalClientException as InternalClientException;

use \HTTP_Request as HTTP_Request;
use \HTTP_Request_Listener as HTTP_Request_Listener;
use \PEAR as PEAR;
use \Exception as Exception;
use \HttpRequest as HttpRequest;

class RESTService {

	/**
	 * @var Url
	 */
	private $serviceAddress;

	/**
	 * @param Url $serviceAddress
	 */
	public function __construct(Url $serviceAddress) {
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

		$httpRequest = new HTTP_Request($this->serviceAddress.$checkedPath);
		$httpRequest->addCookie('escidocCookie', $handle);
		$httpRequest->setMethod($httpMethod);
		if ($data != null) {
			$httpRequest->setBody($data);
		}
		$this->configureHttpClient($httpRequest);

		$req_err = $httpRequest->sendRequest();
		// catch connection timeouts, connection refused etc.
		if (PEAR::isError($req_err)) {
			throw new InternalClientException($this->serviceAddress." : ".$req_err->getMessage(), $req_err->getCode());
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

$r = new RestService(new Url("http:localhost:8080"));
try {
	$r->send(HttpMethod::GET(), "/ir/items");
} catch(Exception $e) {
	echo $e."\n";
}
$foo = new HTTP_Request("http:localhost:8080");
$r->configureHttpClient($foo);
echo var_dump($foo->_allowRedirects);

?>