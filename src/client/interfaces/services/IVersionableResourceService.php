<?php
namespace escidoc\services;

use escidoc\VersionHistory;

/**
 * Interface for HandlerClients, which support versionable resource, which support a version history.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface IVersionableResourceService {

	/**
	 * Retrieve the VersionHistory of the specified resource.
	 *
	 * @param string $resourceId
	 * @return VersionHistory The version history of the resource.
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	public function retrieveVersionHistory(string $resourceId);
}
?>