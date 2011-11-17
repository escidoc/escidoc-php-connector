<?php
use escidoc\client\exceptions\server\application\invalid\XmlSchemaValidationException;
use escidoc\client\exceptions\server\application\notfound\ItemNotFoundException;
use escidoc\client\exceptions\server\application\invalid\InvalidContextStatusException;
use escidoc\client\exceptions\server\application\invalid\InvalidContextStatusException;
use escidoc\client\exceptions\server\application\violated\AdminDescriptorViolationException;
use escidoc\client\exceptions\server\application\invalid\InvalidItemStatusException;
use escidoc\client\exceptions\server\application\missing\MissingElementValueException;
use escidoc\client\exceptions\server\application\notfound\ContentModelNotFoundException;
use escidoc\client\exceptions\server\application\invalid\InvalidStatusException;
use escidoc\client\exceptions\server\application\invalid\InvalidStatusException;
use escidoc\client\exceptions\server\application\notfound\RelationPredicateNotFoundException;
use escidoc\client\exceptions\server\application\notfound\ContextNotFoundException;
use escidoc\client\exceptions\server\application\notfound\ReferencedResourceNotFoundException;
use escidoc\client\exceptions\server\application\notfound\ReferencedResourceNotFoundException;
use escidoc\client\exceptions\server\application\missing\MissingMdRecordException;
use escidoc\client\exceptions\server\application\invalid\InvalidContentException;
use escidoc\client\exceptions\server\application\invalid\InvalidContextException;
use escidoc\client\exceptions\server\application\notfound\ContainerNotFoundException;
use escidoc\client\exceptions\server\application\missing\MissingAttributeValueException;
use escidoc\client\exceptions\server\application\violated\LockingException;
use escidoc\client\exceptions\server\application\violated\OptimisticLockingException;
use escidoc\client\exceptions\server\EscidocException;
use escidoc\client\exceptions\server\application\invalid\InvalidXmlException;
use escidoc\client\exceptions\server\application\invalid\InvalidXmlException;
use escidoc\client\exceptions\server\application\security\AuthorizationException;
use escidoc\client\exceptions\server\application\security\AuthenticationException;
use escidoc\client\exceptions\server\application\missing\MissingMethodParameterException;

/**
 * General interface definition for ContainerHandler implementations such as REST, SOAP and so on.
 *
 * All methods will throw the general EscidocException to support backward and forward compability in case of interface changes.
 *
 * TODO: add documentation
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface IContainerHandler {

	/**
	 *
	 *
	 * @param SearchRetrieveRequest $request
	 * @return string
	 *
	 * @throws MissingMethodParameterException
	 * @throws AuthenticationException
	 * @throws AuthorizationException
	 * @throws InvalidXmlException
	 * @throws EscidocException
	 */
	function retrieveContainers(SearchRetrieveRequest $request);

	/**
	 *
	 *
	 * @param ExplainRequest $request
	 * @return string
	 *
	 * @throws MissingMethodParameterException
	 * @throws AuthenticationException
	 * @throws AuthorizationException
	 * @throws InvalidXmlException
	 * @throws EscidocException
	 */
	function retrieveContainers(ExplainRequest $request);

	/**
	 *
	 * @param string $containerId
	 * @param SearchRetrieveRequest $request
	 * @return string
	 *
	 * @throws MissingMethodParameterException
	 * @throws AuthenticationException
	 * @throws AuthorizationException
	 * @throws InvalidXmlException
	 * @throws EscidocException
	 */
	function retrieveMembers($containerId, SearchRetrieveRequest $request);

	/**
	 *
	 * @param string $containerId
	 * @param ExplainRequest $request
	 * @return string
	 *
	 * @throws MissingMethodParameterException
	 * @throws AuthenticationException
	 * @throws AuthorizationException
	 * @throws InvalidXmlException
	 * @throws EscidocException
	 */
	function retrieveMembers($containerId, ExplainRequest $request);

	/**
	 * TODO: Is this method still supported???
	 *
	 * @param string $containerId
	 * @param string $taskParam
	 * @return string
	 *
	 * @throws OptimisticLockingException
	 * @throws LockingException
	 * @throws MissingMethodParameterException
	 * @throws MissingAttributeValueException
	 * @throws ContainerNotFoundException
	 * @throws InvalidContextException
	 * @throws AuthenticationException
	 * @throws AuthorizationException
	 * @throws InvalidContentException
	 * @throws EscidocException
	 */
	function addTocs($containerId, $taskParam);

	/**
	 *
	 *
	 * @param string $containerId ????
	 * @param string $containerXml
	 * @return string
	 *
	 * @throws LockingException
	 * @throws MissingAttributeValueException
	 * @throws ContainerNotFoundException
	 * @throws InvalidContextException
	 * @throws MissingMdRecordException
	 * @throws ReferencedResourceNotFoundException
	 * @throws AuthenticationException
	 * @throws AuthorizationException
	 * @throws ContextNotFoundException
	 * @throws InvalidContentException
	 * @throws RelationPredicateNotFoundException
	 * @throws MissingMethodParameterException
	 * @throws InvalidStatusException
	 * @throws ContentModelNotFoundException
	 * @throws MissingElementValueException
	 * @throws InvalidXmlException
	 * @throws EscidocException
	 */
	function createContainer($containerId, $containerXml);

	/**
	 *
	 *
	 * @param string $containerId
	 * @param string $taskParam
	 * @return string
	 *
	 * @throws OptimisticLockingException
	 * @throws LockingException
	 * @throws MissingMethodParameterException
	 * @throws MissingAttributeValueException
	 * @throws ContainerNotFoundException
	 * @throws InvalidContextException
	 * @throws InvalidContentException
	 * @throws AuthenticationException
	 * @throws AuthorizationException
	 * @throws EscidocException
	 */
	function addMembers($containerId, $taskParam);

	/**
	 *
	 *
	 * @param string $containerId
	 * @param string $taskParam
	 * @return string
	 *
	 * @throws InvalidItemStatusException
	 * @throws LockingException
	 * @throws AdminDescriptorViolationException
	 * @throws ContainerNotFoundException
	 * @throws AuthenticationException
	 * @throws AuthorizationException
	 * @throws InvalidContextStatusException
	 * @throws ItemNotFoundException
	 * @throws ContextNotFoundException
	 * @throws InvalidContentException
	 * @throws XmlSchemaValidationException
	 * @throws EscidocException
	 */
	function removeMembers($containerId, $taskParam);
}
?>