<?php
namespace escidoc\client\interfaces\services;

use escidoc\Resource;

/**
 * Interface for HandlerClients, which support resources, which can be retrieved.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface IRetrieveService {

	/**
	 * Retrieve the specified resource from the infrastructure.
	 *
	 * <i>Implementations should declare the concrete return type.</i>
	 *
	 * @param string $resourceId
	 * @return Resource The abstract retrieved resource.
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	function retrieve(string $resourceId);
}
?>