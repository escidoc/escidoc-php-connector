<?php
namespace escidoc\client\interfaces\services;

use escidoc\TaskResult;

/**
 * Interface for HandlerClients, which support resources, which can be released.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface IReleaseService {

	/**
	 * Release the specified resource.
	 *
	 * @param string $resourcId
	 * @param TaskParam $param
	 * @return TaskResult
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	function release(string $resourcId, TaskParam $param);
}
?>