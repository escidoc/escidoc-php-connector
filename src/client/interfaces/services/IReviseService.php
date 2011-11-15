<?php
namespace escidoc\services;

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
	public function revise(string $resourceId, TaskParam $param);
}
?>