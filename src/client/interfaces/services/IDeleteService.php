<?php
namespace escidoc\services;

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
	public function delete(string $resourceId);
}
?>