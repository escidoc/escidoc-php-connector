<?php
namespace escidoc\client\interfaces\services;

/**
 * Interface for HandlerClients, which support ContentStream services for their resources.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface IContentStreamService {

	/**
	 * Retrieves a ContentStream of a resource.
	 *
	 * @param string $resourceId
	 * @param string $contentStreamName
	 * @return ContentStream The ContentStream of the resource.
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	function retrieveContentStream(string $resourceId, string $contentStreamName);

	/**
	 * Retrieves all ContentStreams of a resource.
	 *
	 * @param string $resourceId
	 * @return ContentStreams The ContentStreams of the resource.
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	function retrieveContentStreams(string $resourceId);

	/**
	* Retrieves the content of a ContentStream of a resource.
	*
	* @param string $resourceId
	* @param string $contentStreamName
	*
	* TODO: return type of an http stream
	*
	* @throws EscidocException
	* @throws InternalClientException
	* @throws TransportException
	*/
	function retrieveContentStreamContent(string $resourceId, string $contentStreamName);
}
?>