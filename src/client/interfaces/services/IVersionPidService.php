<?php
namespace escidoc\services;

use escidoc\TaskResult;

/**
 * Interface for HandlerClients, which support resources, which support VersionPids to get assigned to.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface IVersionPidService {

	/**
	 * Assign a VersionPid to the specified resource.
	 *
	 * @param string $resourceId
	 * @param TaskParam $param
	 * @return TaskResult
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	public function assignVersionPid(string $resourceId, TaskParam $param);
}
?>