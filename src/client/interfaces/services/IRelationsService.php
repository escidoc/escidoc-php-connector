<?php
namespace escidoc\services;

/**
 * Interface for HandlerClients, which support resources, which themselves support Relations.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface IRelationsService {

	/**
	 * Retrieve the Relations of the specified resource.
	 *
	 * @param string $resourceId
	 * @return Relations of the specified resource.
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	public function retrieveRelations(string $resourceId);
}
?>