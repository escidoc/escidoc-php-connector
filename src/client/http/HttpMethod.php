<?php
namespace escidoc\client\http;

/**
 * Enumeration for HTTP method types.
 *
 * Usage:
 *
 * function func(HttpMethod $method) {...}
 *
 * Call:
 *
 * func(HttpMethod::GET());
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
abstract class HttpMethod {

	/*
	 * Enum instance placeholders.
	 */
	private static $GET = NULL;
	private static $PUT = NULL;
	private static $POST = NULL;
	private static $DELETE = NULL;
	private static $OPTIONS = NULL;
	private static $TRACE = NULL;

	/**
	 * @return GET The GET enum value.
	 */
	public static final function GET() {
		if(NULL == self::$GET) {
			self::$GET = new GET();
		}
		return self::$GET;
	}

	/**
	 * @return POST The POST enum value.
	 */
	public static final function POST() {
		if(NULL == self::$POST) {
			self::$POST = new POST();
		}
		return self::$POST;
	}

	/**
	 * @return PUT The PUT enum value.
	 */
	public static final function PUT() {
		if(NULL == self::$PUT) {
			self::$PUT = new PUT();
		}
		return self::$PUT;
	}

	/**
	 * @return DELETE The DELETE enum value.
	 */
	public static final function DELETE() {
		if(NULL == self::$DELETE) {
			self::$DELETE = new DELETE();
		}
		return self::$DELETE;
	}

	/**
	 * @return OPTIONS The OPTIONS enum value.
	 */
	public static final function OPTIONS() {
		if(NULL == self::$OPTIONS) {
			self::$OPTIONS = new OPTIONS();
		}
		return self::$OPTIONS;
	}

	/**
	 * @return TRACE The TRACE enum value.
	 */
	public static final function TRACE() {
		if(NULL == self::$TRACE) {
			self::$TRACE = new TRACE();
		}
		return self::$TRACE;
	}

	/**
	 * @return string The string representation of the enum value.
	 */
	public function __toString() {
		return get_class($this);
	}
}

/*
 * Enum values.
 */
final class GET extends HttpMethod {
	protected function __construct(){}
}
final class POST extends HttpMethod {
	protected function __construct(){}
}
final class PUT extends HttpMethod {
	protected function __construct(){}
}
final class DELETE extends HttpMethod {
	protected function __construct(){}
}
final class OPTIONS extends HttpMethod {
	protected function __construct(){}
}
final class TRACE extends HttpMethod {
	protected function __construct(){}
}
?>