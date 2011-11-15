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

/*
 * Changed by FIZ Karlsruhe 2011
*/

namespace escidoc;

require_once "transport/Authentication.php";
require_once "EscidocException.php";
require_once "resources/Resource.php";
require_once "resources/TaskResult.php";

use \HTTP_Request as HTTP_Request;
use \PEAR as PEAR;
use \InvalidArgumentException as InvalidArgumentException;
use \Exception as Exception;
use escidoc\Authentication as Authentication;

class EscidocHTTPSender{
	/* @var $authobject Authentication*/
	protected $authobject;
	/* @var $url sting*/
	protected $url;

	/**
	 * @param Authentication $authobject
	 * @throws InvalidArgumentException if $authobject is no instance of Authentication
	 */
	public function __construct($authobject) {
		if ($authobject instanceOf Authentication)
			$this->authobject=$authobject;
		else
			throw new InvalidArgumentException("EscidocHTTPSender needs a valid Authentication object");
	}
	/**
	 * @param string $url the url the content should be sent to
	 * @param sting $method one of 'GET', 'PUT', 'POST' or 'DELETE'
	 * @param sting $data the content
	 * @return string the response
	 */
	protected function send($url,$method,$data){

		if (!strcasecmp($method,'GET') && !strcasecmp($method,'PUT') &&
			!strcasecmp($method,'DELETE') && !strcasecmp($method,'POST')
		)
		throw new InvalidArgumentException ("Illegal http method \"".$method."\"!");

		$resource = str_replace($this->url."/".$this->url,$this->url,$url);

		$httpconn = new HTTP_Request($this->authobject->getServiceAddress().$resource);

		try{
			$cookie=$this->authobject->getUserHandle();
			$httpconn->addCookie('escidocCookie', $cookie);
		}catch (Exception $e){
			//not authenticated throws an exception - simply don't set the cookie
		}

		$httpconn->setBody($data);
		$httpconn->setMethod($method);
		$req_err=$httpconn->sendRequest();

		if (PEAR::isError($req_err))
			throw new Exception($this->authobject->getServiceAddress()." : ".$req_err->getMessage(),$req_err->getCode());


		$body=$httpconn->getResponseBody();
		$code=$httpconn->getResponseCode();

		if (!($code>=200 && $code<=299))
			eSciDocExceptionMapper::eSciDocExceptionMapper ($body);

		return $body;
	}
}

class OMBase extends EscidocHTTPSender{
	/**
	 * @param Authentication $authobject
	 */
	public function __construct($authobject) {
		parent::__construct($authobject);
	}
	/**
	 * @param string $url
	 * @param string $criteria full querystring
	 * @param array $criteria array("operation"=> "searchRetrieve|explain",
	 *       "query"=>"SRU compiant Query",
	 *       "startRecord" => "int",
	 *       "maximumRecords" => "int")
	 *
	 * @return SearchRetrieveResponse
	 */
	protected function filter($url,$criteria=''){

		if (is_string($criteria))
		$body=$criteria;
		else if (is_array($criteria)){
			$body="operation=".$criteria["operation"];
			$body.="&query=".urlencode($criteria["query"]);
			if (isset($criteria["startRecord"]))
			$body.="&startRecord=".$criteria["startRecord"];
			if (isset($criteria["maximumRecords"]))
			$body.="&maximumRecords=".$criteria["maximumRecords"];
		}
		$response=$this->send($url."?".$body,'GET','');

		return EscidocClassFactory::getClass($response);

	}

	/**
	 * @param string $data
	 * @param XMLNode $data
	 * @return Resource
	 */
	public function create($data){
		if (is_a($data, "XMLNode"))
		$data=$data->__toString();
		return ($this->send($this->url,'PUT',$data));
	}
	/**
	 * @param string $id
	 * @param Resource $id
	 * @return Resource
	 */
	public function retrieve($id){
		if ($id instanceof Resource)
		$id=$id->getObjid();
		return ($this->send($this->url."/".$id,'GET',''));
	}
	/**
	 * @param string $id
	 * @param Resource $id
	 */
	public function delete($id){
		if ($id instanceof Resource)
		$id=$id->getObjid();
		$this->send($this->url."/".$id,'DELETE','');
	}
	/**
	 * @param string $id
	 * @param Resource $id
	 * @param string $data
	 * @param XMLNode $data
	 * @return Resource
	 */
	public function update($id,$data){
		if ($id instanceof Resource)
		$id=$id->getObjid();
		if (is_a($data, "XMLNode"))
		$data=$data->__toString();
		return ($this->send($this->url."/".$id,'PUT',$data));
	}

}


class OMBaseWithState extends OMBase{

	/**
	 * @param Authentication $authobject
	 */
	public function __construct($authobject) {
		parent::__construct($authobject);
	}

	/**
	 * @param GenericResource $resource
	 * @param string $comment
	 * @return string
	 */
	private function generateComment($lastmoddate,$comment){

		$body ="<param last-modification-date=\"".$lastmoddate."\">";
		$body.="<comment>".$comment."</comment>";
		$body.="</param>";

		return $body;
	}
	/**
	 * @param GenericResource $resource
	 * @param array $resource array("id"=>"escidoc....","last-modification-date"=>"2011...time...")
	 * @param string $comment
	 * @return TaskResult
	 */
	public function submit($resource,$comment){

		if (is_array($resource)){
			$id=$resource["id"];
			$lastmodificationdate=$resource["last-modification-date"];
		}else{
			$resource=new GenericResource($resource,false);
			$id=$resource->getObjid();
			$lastmodificationdate=$resource->getLastModificationDate();
		}
		$body=$this->generateComment($lastmodificationdate,$comment);
		return new TaskResult($this->send($this->url."/".$id."/submit",'POST',$body),false);
	}
	/**
	 * @param GenericResource $resource
	 * @param array $resource array("id"=>"escidoc....","last-modification-date"=>"2011...time...")
	 * @param string $comment
	 * @return TaskResult
	 */
	public function revise($resource,$comment){
		if (is_array($resource)){
			$id=$resource["id"];
			$lastmodificationdate=$resource["last-modification-date"];
		}else{
			$resource=new GenericResource($resource,false);
			$id=$resource->getObjid();
			$lastmodificationdate=$resource->getLastModificationDate();
		}
		$body=$this->generateComment($lastmodificationdate,$comment);
		return new TaskResult($this->send($this->url."/".$id."/revise",'POST',$body),false);
	}
	/**
	 * @param GenericResource $resource
	 * @param array $resource array("id"=>"escidoc....","last-modification-date"=>"2011...time...")
	 * @param string $comment
	 * @return TaskResult
	 */
	public function release($resource,$comment){
		if (is_array($resource)){
			$id=$resource["id"];
			$lastmodificationdate=$resource["last-modification-date"];
		}else{
			$resource=new GenericResource($resource,false);
			$id=$resource->getObjid();
			$lastmodificationdate=$resource->getLastModificationDate();
		}
		$body=$this->generateComment($lastmodificationdate,$comment);
		return new TaskResult($this->send($this->url."/".$id."/release",'POST',$body),false);
	}
	/**
	 * @param GenericResource $resource
	 * @param array $resource array("id"=>"escidoc....","last-modification-date"=>"2011...time...")
	 * @param string $comment
	 * @return TaskResult
	 */
	public function withdraw($resource,$comment){
		if (is_array($resource)){
			$id=$resource["id"];
			$lastmodificationdate=$resource["last-modification-date"];
		}else{
			$resource=new GenericResource($resource,false);
			$id=$resource->getObjid();
			$lastmodificationdate=$resource->getLastModificationDate();
		}
		$body=$this->generateComment($lastmodificationdate,$comment);
		return new TaskResult($this->send($this->url."/".$id."/withdraw",'POST',$body),false);
	}
	/**
	 * @param GenericResource $resource
	 * @param array $resource array("id"=>"escidoc....","last-modification-date"=>"2011...time...")
	 * @param string $comment
	 * @return TaskResult
	 */
	public function lock($resource,$comment){
		if (is_array($resource)){
			$id=$resource["id"];
			$lastmodificationdate=$resource["last-modification-date"];
		}else{
			$resource=new GenericResource($resource,false);
			$id=$resource->getObjid();
			$lastmodificationdate=$resource->getLastModificationDate();
		}
		$body=$this->generateComment($lastmodificationdate,$comment);
		return new TaskResult($this->send($this->url."/".$id."/lock",'POST',$body),false);
	}
	/**
	 * @param GenericResource $resource
	 * @param array $resource array("id"=>"escidoc....","last-modification-date"=>"2011...time...")
	 * @param string $comment
	 * @return TaskResult
	 */
	public function unlock($resource){
		if (is_array($resource)){
			$id=$resource["id"];
			$lastmodificationdate=$resource["last-modification-date"];
		}else{
			$resource=new GenericResource($resource,false);
			$id=$resource->getObjid();
			$lastmodificationdate=$resource->getLastModificationDate();
		}
		$body=$this->generateComment($lastmodificationdate,$comment);
		return new TaskResult($this->send($this->url."/".$id."/unlock",'POST',$body),false);
	}
}
?>
