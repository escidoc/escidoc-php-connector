<?php
/*
 Copyright [2010] [GFZ German Research Centre for Geosciences]
 Licensed under the Apache License, Version 2.0 (the "License");
 you may not use this file except in compliance with the License.
 You may obtain a copy of the License at

 http://www.apache.org/licenses/LICENSE-2.0

 Unless required by applicable law or agreed to in writing, software
 distributed under the License is distributed on an "AS IS" BASIS,
 WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 See the License for the specific language governing permissions and
 limitations under the License.
 */
namespace escidoc\client\exceptions;
use \DOMDocument as DOMDocument;
use \DOMXPath as DOMXPath;
use \ReflectionClass as ReflectionClass;
use \ReflectionException as ReflectionException;
use \Exception as Exception;

class eSciDocExceptionMapper {

	static public function eSciDocExceptionMapper($exceptionmessage){

		if (strlen($exceptionmessage)==0)
		return;

		$dom = DOMDocument::loadXML($exceptionmessage);
		$xpath = new DOMXPath($dom);

		if ($xpath->query('//exception/class')->length <1)
		throw new Exception("Could not map Exception from Escidoc-messages");

		$class = $xpath->query('//exception/class')->item(0)->nodeValue;

		//$class is something like "de.escidoc.exception.ItemNotFoundException"
		//and we want the string after the last dot
		$classname = array_pop(preg_split("/\./",$class));
		try{
			$object = new ReflectionClass('escidoc\\'.$classname);
			if($object->isInstantiable()) {
				$exception=$object->newInstance($exceptionmessage);
				if($exception!=null && $object->isInstance($exception))
				throw $exception;
			}
			throw new Exception("Could not map Exception from Escidoc-messages");
		} catch (ReflectionException $e){
			throw new Exception($e->getMessage(),$e->getCode(),$e->getPrevious());
		}

	}
}
class EscidocException extends \RuntimeException {

	protected  $fullxmlmessage;

	public function  __construct($fullxmlmessage, $code=null, $previous=null) {
		$this->fullxmlmessage=$fullxmlmessage;

		$dom= DOMDocument::loadXML($fullxmlmessage);
		$xpath=new DOMXPath($dom);

		if ($xpath->query('//exception/title')->length <1
		|| $xpath->query('//exception/message')->length <1
		//            || $xpath->query('//exception/stack-trace')->length <1
		)
		throw new Exception("Could not map Exception from Escidoc-messages");

		$title=$xpath->query('//exception/title')->item(0)->nodeValue;
		$message=$xpath->query('//exception/message')->item(0)->nodeValue;
		//        $stacktrace=$xpath->query('//exception/stack-trace')->item(0)->nodeValue;

		$errmsg=substr($title,4);
		$errcode=intval(substr($title,0,3));

		parent::__construct($errmsg."<br>".$message, $errcode, $previous);
	}

	public function getFullEscidocMessage(){
		return $this->fullxmlmessage;
	}

}
/*
 * Exception-hierarchy extracted from Java-Client Library by FIZ Karlsruhe
 */

class MethodNotFoundException extends EscidocException{}

class ApplicationException  extends EscidocException {}

class ResourceNotFoundException  extends ApplicationException  {}
class ActionNotFoundException  extends ResourceNotFoundException{}
class WorkflowInstanceNotFoundException  extends ResourceNotFoundException{}
class WorkflowTypeNotFoundException  extends ResourceNotFoundException  {}
class RelationPredicateNotFoundException  extends ResourceNotFoundException {}
class WorkflowTemplateNotFoundException  extends ResourceNotFoundException  {}
class FileNotFoundException  extends ResourceNotFoundException  {}
class WorkflowDefinitionNotFoundException  extends ResourceNotFoundException {}
class ContainerNotFoundException  extends ResourceNotFoundException  {}
class TransitionNotFoundException  extends ResourceNotFoundException  {}
class AggregationTypeNotFoundException  extends ResourceNotFoundException{}
class StructuralMapEntryNotFoundException  extends ResourceNotFoundException{}
class ReferencedResourceNotFoundException  extends ResourceNotFoundException  {}
class AggregationDefinitionNotFoundException  extends ResourceNotFoundException {}
class SearchNotFoundException  extends ResourceNotFoundException  {}
class IngestionSourceNotFoundException  extends ResourceNotFoundException{}
class ItemNotFoundException  extends ResourceNotFoundException  {}
class IngestionDefinitionNotFoundException  extends ResourceNotFoundException{}
class ComponentNotFoundException  extends ResourceNotFoundException  {}
class TargetBasketNotFoundException  extends ResourceNotFoundException {}
class UserNotFoundException  extends ResourceNotFoundException  {}
class ReportDefinitionNotFoundException  extends ResourceNotFoundException{}
class PidNotFoundException  extends ResourceNotFoundException  {}
class IndexNotFoundException  extends ResourceNotFoundException  {}
class ContentStreamNotFoundException  extends ResourceNotFoundException{}
class IngestionTaskNotFoundException  extends ResourceNotFoundException  {}
class RelationTypeNotFoundException  extends ResourceNotFoundException {}
class ContentModelNotFoundException  extends ResourceNotFoundException  {}
class TaskListNotFoundException  extends ResourceNotFoundException  {}
class MdRecordNotFoundException  extends ResourceNotFoundException  {}
class XmlSchemaNotFoundException  extends ResourceNotFoundException  {}
class RoleNotFoundException  extends ResourceNotFoundException  {}
class ContextNotFoundException  extends ResourceNotFoundException {}
class UserGroupNotFoundException  extends ResourceNotFoundException {}
class ItemReferenceNotFoundException  extends ResourceNotFoundException{}
class StagingFileNotFoundException  extends ResourceNotFoundException  {}
class ContentRelationNotFoundException  extends ResourceNotFoundException{}
class PreferenceNotFoundException  extends ResourceNotFoundException  {}
class GrantNotFoundException  extends ResourceNotFoundException  {}
class AdminDescriptorNotFoundException  extends ResourceNotFoundException {}
class ScopeNotFoundException  extends ResourceNotFoundException  {}
class RelationNotFoundException  extends ResourceNotFoundException {}
class UserAccountNotFoundException  extends ResourceNotFoundException {}
class VersionNotFoundException  extends ResourceNotFoundException  {}
class RevisionNotFoundException  extends ResourceNotFoundException  {}
class OrganizationalUnitNotFoundException  extends ResourceNotFoundException {}
class TaskNotFoundException  extends ResourceNotFoundException  {}
class UserAttributeNotFoundException  extends ResourceNotFoundException {}

class SecurityException  extends EscidocException{}
class AuthorizationException  extends SecurityException  {}
class AuthenticationException  extends SecurityException {}

class ValidationException  extends ApplicationException{}
class ReferenceCycleException  extends ValidationException{}
class InvalidContextStatusException  extends ValidationException{}
class XmlCorruptedException  extends InvalidXmlException  {}
class InvalidItemStatusException  extends ValidationException {}
class XmlSchemaValidationException  extends InvalidXmlException {}
class InvalidResourceException  extends ValidationException  {}
class InvalidXmlException  extends ValidationException  {}
class InvalidAggregationTypeException  extends ValidationException{}
class InvalidStatusException  extends ValidationException  {}


class TmeException  extends ApplicationException  {}


class ContextNotEmptyException  extends ValidationException {}
class InvalidContentModelException  extends ValidationException{}
class InvalidTripleStoreOutputFormatException  extends ValidationException{}
class InvalidWorkflowDefinitionException  extends ValidationException  {}
class InvalidContextException  extends ValidationException  {}
class InvalidRelationPropertiesException  extends ValidationException{}
class InvalidSearchQueryException  extends ValidationException  {}
class InvalidTripleStoreQueryException  extends ValidationException  {}
class InvalidWorkflowTypeException  extends ValidationException  {}
class InvalidContentException  extends ValidationException  {}
class InvalidSqlException  extends ValidationException  {}
class InvalidPidException  extends ValidationException  {}

class MissingParameterException  extends ApplicationException{}
class MissingMethodParameterException  extends MissingParameterException{}
class MissingMdRecordException  extends MissingParameterException  {}
class MissingUserListException  extends MissingParameterException  {}
class MissingContentException  extends MissingParameterException  {}
class MissingLicenceException  extends MissingParameterException  {}
class MissingWorkflowVariableException  extends MissingParameterException{}
class MissingAttributeValueException  extends MissingParameterException  {}
class MissingElementValueException  extends MissingParameterException  {}


class ResourceInUseException  extends ApplicationException {}

class RuleViolationException  extends ApplicationException {}
class UniqueConstraintViolationException  extends RuleViolationException{}
class ScopeContextViolationException  extends RuleViolationException  {}
class OrganizationalUnitNameNotUniqueException  extends RuleViolationException{}
class RoleInUseViolationException  extends RuleViolationException  {}
class AdminDescriptorViolationException  extends RuleViolationException{}
class TimeFrameViolationException  extends RuleViolationException  {}
class AlreadyPublishedException  extends RuleViolationException  {}
class AlreadyDeletedException  extends RuleViolationException  {}
class OrganizationalUnitHierarchyViolationException  extends RuleViolationException{}
class AlreadyWithdrawnException  extends RuleViolationException  {}
class LockingException  extends RuleViolationException{}
class AlreadyRevokedException  extends RuleViolationException{}
class AlreadyExistsException  extends RuleViolationException  {}
class PidAlreadyAssignedException  extends RuleViolationException {}
class UserGroupHierarchyViolationException  extends RuleViolationException{}
class ReadonlyViolationException  extends RuleViolationException  {}
class WorkflowViolationException  extends RuleViolationException{}
class AlreadyDeactiveException  extends RuleViolationException  {}
class NotPublishedException  extends RuleViolationException  {}
class OptimisticLockingException  extends RuleViolationException {}
class AlreadyActiveException  extends RuleViolationException  {}
class ReadonlyVersionException  extends RuleViolationException  {}
class ReadonlyAttributeViolationException  extends ReadonlyViolationException {}
class ReadonlyElementViolationException  extends ReadonlyViolationException  {}
class WorkflowTaskViolationException  extends RuleViolationException  {}
class ContextNameNotUniqueException  extends RuleViolationException  {}
class RelationRuleViolationException  extends RuleViolationException  {}
class OrganizationalUnitHasChildrenException  extends RuleViolationException{}

class SystemException  extends EscidocException{}
class SqlDatabaseSystemException  extends SystemException{}
class WebserverSystemException  extends SystemException{}
class TripleStoreSystemException  extends SystemException{}
class FedoraSystemException  extends SystemException{}
class ApplicationServerSystemException  extends SystemException{}
class XmlParserSystemException  extends SystemException{}
class IntegritySystemException  extends SystemException{}
class FileSystemException  extends SystemException{}
class WorkflowEngineSystemException  extends SystemException{}
class StatisticPreprocessingSystemException  extends SystemException{}

class StreamNotFoundException  extends EscidocException{}
?>