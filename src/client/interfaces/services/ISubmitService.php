<?php
namespace escidoc\client\interfaces\services;

use escidoc\TaskResult;

/**
 * Interface for HandlerClients, which support resource, which can be submitted.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface ISubmitService {

	/**
	 * Submit the specified resource.
	 *
	 * @param string $resourceId
	 * @param TaskParam $param
	 * @return TaskResult The result of the request.
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	function submit(string $resourceId, TaskParam $param);
}
?>