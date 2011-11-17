<?php
namespace escidoc\client\interfaces\services;

use escidoc\Resource;

/**
 * Interface for HandlerClients, which support resources, which can be created.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface ICreateService {

	/**
	 * Creates a resource.
	 *
	 * @param Resource $resource The resource to create.
	 * @return Resource The created resource returned from the infrastructure.
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	function create(Resource $resource);
}
?>