<?php
namespace escidoc\services;

use escidoc\TaskResult;

/**
 * Interface for HandlerClients, which support resources, which can be locked/unlocked.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface ILockingService {

	/**
	 * Locks the resource.
	 *
	 * @param string $resourceId
	 * @param TaskParam $param
	 * @return TaskResult The result of the lock request.
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	public function lock(string $resourceId, TaskParam $param);

	/**
	 * Unlocks the resource.
	 *
	 * @param string $resourceId
	 * @param TaskParam $param
	 * @return TaskResult The result of the unlock request.
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	public function unlock(string $resourceId, TaskParam $param);
}
?>