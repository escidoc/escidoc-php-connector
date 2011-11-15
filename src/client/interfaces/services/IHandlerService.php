<?php
namespace escidoc\services;

use escidoc\util\Url;

/**
 * General interface for all HandlerClients.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface IHandlerService {

	/**
	 * Returns the handle for authentication.
	 *
	 * @return string The handle for authentication.
	 */
	public function getHandle();

	/**
	 * Sets the handle to use for authentication.
	 *
	 * @param string $handle
	 */
	public function setHandle(string $handle);

	/**
	 * Returns the serviceAddress to use for this HandlerClient implementation.
	 *
	 * @return Url The serviceAddress to use.
	 */
	public function getServiceAddress();
}
?>