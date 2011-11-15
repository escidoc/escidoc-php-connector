<?php
namespace escidoc\services;

use escidoc\MetadataRecord;
use escidoc\MetadataRecords;

/**
 * Interface for HandlerClients, which support resources, which themlselves support MdRecords.
 *
 * @author Marko Voss (marko.voss@fiz-karlsruhe.de)
 *
 */
interface IMdRecordService {

	/**
	 * Retrieve all MdRecords of the specified resource.
	 *
	 * @param string $resourceId
	 * @return MetadataRecords
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	public function retrieveMdRecords(string $resourceId);

	/**
	 * Retrieve the specified MdRecord of the specified resource.
	 *
	 * @param string $resourceId
	 * @param string $mdRecordId
	 * @return MetadataRecord
	 *
	 * @throws EscidocException
	 * @throws InternalClientException
	 * @throws TransportException
	 */
	public function retrieveMdRecord(string $resourceId, string $mdRecordId);
}
?>