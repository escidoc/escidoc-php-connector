<?php
namespace escidoc\util;

use \InvalidArgumentException;

/**
 * A utility class to check for preconditions of functions.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
class Preconditions {

	private final function __construct() {}

	/**
	 * Check whether the specified $param is null or not.
	 *
	 * @param mixed $param The parameter to evaluate.
	 * @param string $msg The message to use for the InvalidArgumentException, if $param is null.
	 * @return mixed The specified $param will be returned if not null.
	 *
	 * @throws InvalidArgumentException
	 */
	public static final function checkNotNull($param, $msg=null) {
		if (is_null($param)) {
			if (is_string($msg)) {
				throw new InvalidArgumentException($msg);
			} else {
				throw new InvalidArgumentException("The parameter should not be null.");
			}
		}
		return $param;
	}
}
?>