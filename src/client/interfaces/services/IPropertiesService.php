<?php
namespace escidoc\services;

/**
 * Interface for HandlerClients, which support resources, whose properties can be retrieved separately.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface IPropertiesService {

	/**
	 * Retrieve the properties of the specified resource.
	 *
	 * TODO: Maybe create a base class for all properties-implementation and use this one here as the return type.
	 *
	 * <i>Implementations should declare the concrete return type.</i>
	 *
	 * @param string $resourceId
	 * @return mixed
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	public function retrieveProperties(string $resourceId);
}
?>