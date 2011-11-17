<?php
namespace escidoc\client\interfaces\services;

/**
 * Interface for HandlerClients, which support resources, which can be deleted.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface IDeleteService {

	/**
	 * Deletes the resource in the infrastructure.
	 *
	 * @param string $resourceId
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	function delete(string $resourceId);
}
?>