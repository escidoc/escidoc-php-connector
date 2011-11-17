<?php
namespace escidoc\client\interfaces\services;

use escidoc\Resource;

/**
 * Interface for HandlerClients, which support resources, which can be updated.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface IUpdateService {

	/**
	 * Updates the specified Resource on the infrastructure using the provided resourceId.
	 *
	 * <i>Implementations should declare the concrete type of the Resource.</i>
	 *
	 * @param Resource $resource
	 * @return Resource The updated resource from the infrastructure.
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	function update(Resource $resource);

	/**
	 * Updates the specified Resource on the infrastructure using the specified resourceId. This function can be convenient, if you like to update a resource by using a newly created Resource object.
	 *
	 * <i>Implementations should declare the concrete type of the Resource.</i>
	 *
	 * @param Resource $resource
	 * @return Resource The updated resource from the infrastructure.
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	function update(string $resourceId, Resource $resource);
}
?>