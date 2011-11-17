<?php
namespace escidoc\client\interfaces\handler;

use escidoc\client\exceptions\server\EscidocException;
use escidoc\client\exceptions\server\application\notfound\ScopeNotFoundException;
use escidoc\client\exceptions\server\application\invalid\XmlCorruptedException;
use escidoc\client\exceptions\server\application\invalid\XmlSchemaValidationException;
use escidoc\client\exceptions\server\application\notfound\AggregationDefinitionNotFoundException;
use escidoc\client\exceptions\server\application\missing\MissingMethodParameterException;
use escidoc\client\exceptions\server\application\invalid\InvalidXmlException;
use escidoc\client\exceptions\server\application\security\AuthenticationException;
use escidoc\client\exceptions\server\application\security\AuthorizationException;

/**
 * General interface definition for AggregationDefinitionHandler implementations such as REST, SOAP and so on.
 *
 * All methods will throw the general EscidocException to support backward and forward compability in case of interface changes.
 *
 * TODO: add documentation
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface IAggregationDefinitionHandler {

	/**
	 *
	 *
	 * @param SearchRetrieveRequest $request
	 * @return string
	 *
	 * @throws AuthorizationException
	 * @throws AuthenticationException
	 * @throws InvalidXmlException
	 * @throws MissingMethodParameterException
	 * @throws EscidocException
	 */
	function retrieveAggregationDefinitions(SearchRetrieveRequest $request);

	/**
	 *
	 *
	 * @param ExplainRequest $request
	 * @return string
	 *
	 * @throws AuthorizationException
	 * @throws AuthenticationException
	 * @throws InvalidXmlException
	 * @throws MissingMethodParameterException
	 * @throws EscidocException
	 */
	function retrieveAggregationDefinitions(ExplainRequest $request);

	/**
	 *
	 *
	 * @param string $id
	 *
	 * @throws AuthenticationException
	 * @throws AuthorizationException
	 * @throws AggregationDefinitionNotFoundException
	 * @throws MissingMethodParameterException
	 * @throws EscidocException
	 */
	function delete($id);

	/**
	 *
	 *
	 * @param string $xml
	 * @return string
	 *
	 * @throws XmlSchemaValidationException
	 * @throws XmlCorruptedException
	 * @throws AuthenticationException
	 * @throws AuthorizationException
	 * @throws ScopeNotFoundException
	 * @throws MissingMethodParameterException
	 * @throws EscidocException
	 */
	function create($xml);

	/**
	 *
	 *
	 * @param string $id
	 * @return string
	 *
	 * @throws AuthenticationException
	 * @throws AuthorizationException
	 * @throws AggregationDefinitionNotFoundException
	 * @throws MissingMethodParameterException
	 */
	function retrieve($id);
}
?>