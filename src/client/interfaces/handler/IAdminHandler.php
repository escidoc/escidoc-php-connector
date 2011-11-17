<?php
namespace escidoc\client\interfaces\handler;

/**
 * General interface definition for AdminHandler implementations such as REST, SOAP and so on.
 *
 * All methods will throw the general EscidocException to support backward and forward compability in case of interface changes.
 *
 * TODO: add documentation
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface IAdminHandler {

	/**
	 *
	 * @param string $taskParam
	 * @return string
	 *
	 * @throws EscidocException
	 * @throws AuthorizationException
	 * @throws AuthenticationException
	 * @throws InvalidXmlException
	 */
	function deleteObjects($taskParam);

	/**
	 *
	 * @return string
	 *
	 * @throws EscidocException
	 * @throws AuthorizationException
	 * @throws AuthenticationException
	 */
	function getPurgeStatus();

	/**
	 *
	 * @return string
	 *
	 * @throws EscidocException
	 * @throws AuthorizationException
	 * @throws AuthenticationException
	 */
	function getReindexStatus();

	/**
	 *
	 * @param string $clearIndex
	 * @param string $indexNamePrefix
	 * @return string
	 *
	 * @throws EscidocException
	 * @throws AuthorizationException
	 * @throws AuthenticationException
	 * @throws InvalidSearchQueryException
	 */
	function reindex($clearIndex, $indexNamePrefix);

	/**
	 * @return string
	 *
	 * @throws EscidocException
	 * @throws AuthorizationException
	 * @throws AuthenticationException
	 */
	function getRepositoryInfo();

	/**
	 *
	 * @param unknown_type $exampleSet
	 * @return string
	 *
	 * @throws EscidocException
	 * @throws AuthorizationException
	 * @throws AuthenticationException
	 * @throws InvalidSearchQueryException
	 */
	function loadExamples($exampleSet);

	/**
	 *
	 * @return string
	 *
	 * @throws EscidocException
	 * @throws AuthorizationException
	 * @throws AuthenticationException
	 */
	function getIndexConfiguration();
}
?>