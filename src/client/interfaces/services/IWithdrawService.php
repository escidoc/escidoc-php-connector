<?php
namespace escidoc\services;

use escidoc\TaskResult;

/**
 * Interface for HandlerClients, which support resource, which can be withdrawn.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface IWithdrawService {

	/**
	 * Withdraw the specified resource.
	 *
	 * @param string $resourceId
	 * @param TaskParam $param
	 * @return TaskResult The result of the request.
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	public function withdraw(string $resourceId, TaskParam $param);
}
?>