<?php
namespace escidoc\client\interfaces\services;

use escidoc\TaskResult;

/**
 * Interface for HandlerClients, which support resources, which can be revised.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface IReviseService {

	/**
	 * Revise the specified resource.
	 *
	 * @param string $resourceId
	 * @param TaskParam $param
	 * @return TaskResult The result of the request.
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	function revise(string $resourceId, TaskParam $param);
}
?>