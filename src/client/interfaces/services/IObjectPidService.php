<?php
namespace escidoc\client\interfaces\services;

use escidoc\TaskResult;

/**
 * Interface for HandlerClients, which support resources, where ObjectPids can be assigned to them.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface IObjectPidService {

	/**
	 * Assign an ObjectPid to the specified resource.
	 *
	 * @param string $resourceId
	 * @param TaskParam $param
	 * @return TaskResult The result of the request.
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	function assignObjectPid(string $resourceId, TaskParam $param);
}
?>