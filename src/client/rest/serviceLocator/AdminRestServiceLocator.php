<?php
namespace escidoc\client\rest\serviceLocator;

use escidoc\client\exceptions\server\application\invalid\InvalidSearchQueryException;
use escidoc\client\exceptions\server\application\invalid\InvalidXmlException;
use escidoc\client\exceptions\server\application\security\AuthenticationException;
use escidoc\client\exceptions\server\application\security\AuthorizationException;
use escidoc\client\exceptions\server\EscidocException;
use escidoc\client\interfaces\handler\IAdminHandler;

use escidoc\client\http\HttpMethod;
use escidoc\client\rest\serviceLocator\RestService;
use escidoc\util\Preconditions;
use \Net_URL;
use \InvalidArgumentException;

/**
 *
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
class AdminRestServiceLocator extends RestService implements IAdminHandler {

	/**
	 * @var string
	 */
	public static $PATH = "/adm/admin";

	public function __construct($serviceAddress) {
		parent::__construct($serviceAddress, &self::$PATH);
	}

	/**
	 * (non-PHPdoc)
	 * @see escidoc\client\interfaces\handler.IAdminHandler::deleteObjects()
	 */
	public function deleteObjects($taskParam) {
		return $this->send(HttpMethod::POST(), "/deleteobjects", $taskParam);
	}

	/**
	 * (non-PHPdoc)
	 * @see escidoc\client\interfaces\handler.IAdminHandler::getPurgeStatus()
	 */
	public function getPurgeStatus() {
		return $this->send(HttpMethod::GET(), "/deleteobjects");
	}

	/**
	 * (non-PHPdoc)
	 * @see escidoc\client\interfaces\handler.IAdminHandler::getReindexStatus()
	 */
	public function getReindexStatus() {
		return $this->send(HttpMethod::GET(), "/reindex");
	}

	/**
	 * (non-PHPdoc)
	 * @see escidoc\client\interfaces\handler.IAdminHandler::reindex()
	 */
	public function reindex($clearIndex, $indexNamePrefix) {
		Preconditions::checkNotNull($clearIndex);
		Preconditions::checkNotNull($indexNamePrefix);
		return $this->send(HttpMethod::POST(), "/reindex/$clearIndex/$indexNamePrefix");
	}

	/**
	 * (non-PHPdoc)
	 * @see escidoc\client\interfaces\handler.IAdminHandler::getRepositoryInfo()
	 */
	public function getRepositoryInfo() {
		return $this->send(HttpMethod::GET(), "/get-repository-info");
	}

	/**
	 * (non-PHPdoc)
	 * @see escidoc\client\interfaces\handler.IAdminHandler::loadExamples()
	 */
	public function loadExamples($exampleSet) {
		Preconditions::checkNotNull($exampleSet);
		return $this->send(HttpMethod::GET(), "/load-examples/$exampleSet");
	}

	/**
	 * (non-PHPdoc)
	 * @see escidoc\client\interfaces\handler.IAdminHandler::getIndexConfiguration()
	 */
	public function getIndexConfiguration() {
		return $this->send(HttpMethod::GET(), "/get-index-configuration");
	}
}
?>