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
 * 
 * this file contains the REST-Interface to the eSciDoc object-manager
 * methods based on eSciDoc documentation files of the object-manager
 * (Rest_api_doc_OM_*.pdf)
 *
 */
namespace escidoc;

require_once "transport/BaseClasses.php";
require_once "resources/TaskResult.php";
require_once "resources/om/container/Container.php";

class ContainerHandler extends OMBaseWithState{
    /**
     * @param Authentication $authobject
     */
    public function __construct($authobject){
        parent::__construct($authobject);
        $this->url="/ir/container";
    }
    public function create($data) {
        return new Container(parent::create($data),false);
    }
    public function retrieve($id) {
        return new Container(parent::retrieve($id),false);
    }
    public function update($id, $data) {
        return new Container(parent::update($id, $data),false);
    }
    /** 
     * @param array $criteria array("operation"=> "searchRetrieve|explain","query"=>"SRU compiant Query","startRecord" => "int","maximumRecords" => "int")
     * @return SearchRetrieveResponse
     */    
    public function retrieveContainers($criteria=''){
        return ($this->filter($this->url."s",$criteria));
    }
    public function retrieveProperties($id){

        if ($id instanceof Container)
            $escidocid=$id->getObjid ();

        return new ContainerProperties($this->send($this->url."/".$id."/properties",'GET',''),false);
    }
    /**
     *
     * @param string $id
     * @param GenericResource $id
     * @return StructMap 
     */
    
    public function retrieveStructMap($id){
        
        if ($id instanceof Container)
            $id=$id->getObjid ();

        return new StructMap(
                $this->send($this->url."/".$id."/struct-map",'GET',''),
                false);
    }
    public function retrieveTocs($id,$criteria){
        return ($this->filter($this->url."/".$id."/tocs",$criteria));
    }
    /** 
     * @param array $criteria array("operation"=> "searchRetrieve|explain","query"=>"SRU compiant Query","startRecord" => "int","maximumRecords" => "int")
     * @return SearchRetrieveResponse
     */     
    public function retrieveMembers ($id,$criteria){
        return ($this->filter($this->url."/".$id."/resources/members",$criteria));
    }
    public function retrieveMdRecords($id){
        return new MetadataRecords ($this->send($this->url."/".$id."/md-records",'GET',''),false);
    }
    public function retrieveMdRecord($id,$recordid){
        return new MetadataRecord($this->send($this->url."/".$id."/md-records/mdrecord/".$recordid,'GET',''),false);
    }
    public function retrieveVersionHistory($id){
        return new VersionHistory($this->send($this->url."/".$id."/resources/version-history",'GET',''),false);
    }
    //$parameters geht aus der Doku nicht hervor??
    public function retrieveResource($id,$resourcename,$parameters){
        return ($this->send($this->url."/".$id."/resources/".$resourcename,'GET',''));
    }
    public function retrieveResources($id){
        return ($this->send($this->url."/".$id."/resources",'GET',''));
    }
    public function retrieveRelations($id){
        return ($this->send($this->url."/".$id."/relations",'GET',''));
    }
    public function addContentRelations($id,$body){
        return ($this->send($this->url."/".$id."/content-relations/add",'POST',$body));
    }
    public function removeContentRelations($id,$body){
        return ($this->send($this->url."/".$id."/content-relations/remove",'POST',$body));
    }
    public function assignObjectPid($id,$body){
        return ($this->send($this->url."/".$id."/assign-object-pid",'POST',$body));
    }
    public function assignVersionPid($id,$body){
        return ($this->send($this->url."/".$id."/assign-version-pid",'POST',$body));
    }
    public function addTocs(){
        return ($this->send($this->url."/".$id."/tocs/add",'POST',$body));
    }
    /**
     * @param Container $resource
     * @param array $resource array("id"=>"escidoc....","last-modification-date"=>"2011...time...")
     * @param array $members array ("escidoc:1", "escidoc:2", ...)
     * @return TaskResult
     */    
    public function addMembers ($resource,$members){
        if (is_array($resource)){
            $id=$resource["id"];
            $lastmodificationdate=$resource["last-modification-date"];
        }else{
            $resource=new GenericResource($resource,false);
            $id=$resource->getObjid();
            $lastmodificationdate=$resource->getLastModificationDate();
        }
        $body ="<param last-modification-date=\"".$lastmodificationdate."\">";
        foreach ($members as $memberid)
            $body.="<id>".$memberid."</id>"; 
        $body.="</param>"; 

        return new TaskResult($this->send($this->url."/".$id."/members/add",'POST',$body));
    }
    /**
     * @param Container $resource
     * @param array $resource array("id"=>"escidoc....","last-modification-date"=>"2011...time...")
     * @param array $members array ("escidoc:1", "escidoc:2", ...)
     * @return TaskResult
     */  
    public function removeMembers($resource,$members){
        if (is_array($resource)){
            $id=$resource["id"];
            $lastmodificationdate=$resource["last-modification-date"];
        }else{
            $resource=new GenericResource($resource,false);
            $id=$resource->getObjid();
            $lastmodificationdate=$resource->getLastModificationDate();
        }
        $body ="<param last-modification-date=\"".$lastmodificationdate."\">";
        foreach ($members as $memberid)
            $body.="<id>".$memberid."</id>"; 
        $body.="</param>"; 
        return new TaskResult($this->send($this->url."/".$id."/members/remove",'POST',$body));
    }
/*
 * Deprecated
 *   public function createItem($id, $item){
        return ($this->send($this->url."/".$id."/create-item",'POST',$item));
    }
    public function createContainer($id, $container){
        return ($this->send($this->url."/".$id."/create-container",'POST',$container));
    }
*/
}
?>
