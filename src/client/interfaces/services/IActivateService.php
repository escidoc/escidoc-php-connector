<?php
namespace escidoc\client\interfaces\services;

/**
 * Interface for HandlerClients, which support resources, which can be activated or deactivated.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface IActivateService {

	/**
	 * Activates a resource.
	 *
	 * @param string $groupId
	 * @param TaskParam $taskParam
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	function activate(string $resourceId, TaskParam $taskParam);

	/**
	 * Deactivates a resource.
	 *
	 * @param string $groupId
	 * @param TaskParam $taskParam
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	function deactivate(string $resourceId, TaskParam $taskParam);
}
?>