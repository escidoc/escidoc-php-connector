<?php
namespace escidoc\client\interfaces\services;

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
	function getHandle();

	/**
	 * Sets the handle to use for authentication.
	 *
	 * @param string $handle
	 */
	function setHandle(string $handle);

	/**
	 * Returns the serviceAddress to use for this HandlerClient implementation.
	 *
	 * @return Url The serviceAddress to use.
	 */
	function getServiceAddress();
}
?>