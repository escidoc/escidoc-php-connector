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
require_once 'resources/aa/usergroup/UserGroup.php';
require_once 'resources/aa/usergroup/GroupSelector.php';
require_once 'resources/aa/useraccount/Grant.php';
require_once 'resources/ResourceList.php';

class GroupHandler extends OMBase{
    /**
     * @param Authentication $authobject
     */
    public function __construct($authobject) {
        parent::__construct($authobject);
        $this->url="/aa/user-group";
    }
    
    public function create($data) {
        return  new UserGroup(parent::create($data),false);
    }
    public function retrieve($id) {
        return new UserGroup(parent::retrieve($id),false);
    }
    public function update($id, $data) {
        return new UserGroup(parent::update($id, $data),false);
    }
    /** 
     * @param array $criteria array("operation"=> "searchRetrieve|explain","query"=>"SRU compiant Query","startRecord" => "int","maximumRecords" => "int")
     * @return SearchRetrieveResponse
     */    
    public function retrieveUserGroups($criteria){
        return ($this->filter($this->url."s",$criteria));
    }
    public function retrieveResources($id){
        return ($this->send($this->url."/".$id."/resources",'GET',''));
    }
    /**
     *
     * @param Group $id
     * @return ResourceList 
     */   
    public function retrieveCurrentGrants($id){
        if (is_a($id,"escidoc\Resource"))
                $id=$id->getObjid();
        return new ResourceList($this->send($this->url."/".$id."/resources/current-grants",'GET',''),false);
    }
    /**
     * @param UserGroup $id
     * @param string $id
     * @param string $body
     * @return Grant 
     */
    public function createGrant($id,$body){
        if ($id instanceof UserGroup)
            $id=$id->getObjid ();
        if (is_a($body, "escidoc\XMLNode"))
            $body=$body->__toString();
        return new Grant($this->send($this->url."/".$id."/resources/grants/grant",'PUT',$body),false);
    }    
    /**
     * @param Resource $id
     * @param string $id
     * @param Resource $grantid
     * @param string $grantid
     * @return Grant 
     */    
    public function retrieveGrant($id,$grantid){
        if ($id instanceof Resource)
            $id=$id->getObjid ();
        if ($grantid instanceof Resource)
            $grantid=$grantid->getObjid ();
        return new Grant($this->send($this->url."/".$id."/resources/grants/grant".$grantid,'GET',''),false);
    }
    /**
     * @param GenericResource $resource
     * @param array $resource array("id"=>"escidoc....","last-modification-date"=>"2011...time...")
     */
    public function activate($resource){
        if (is_array($resource)){
            $id=$resource["id"];
            $lastmodificationdate=$resource["last-modification-date"];
        }else{
            $resource=new GenericResource($resource,false);
            $id=$resource->getObjid();
            $lastmodificationdate=$resource->getLastModificationDate();
        }
        $body='<param last-modification-date"'.$lastmodificationdate.'"/>';
        $this->send($this-url."/".$id."activate",'POST',$body);
    }
    /**
     * @param GenericResource $resource
     * @param array $resource array("id"=>"escidoc....","last-modification-date"=>"2011...time...")
     */
    public function deactivate($resource){
        if (is_array($resource)){
            $id=$resource["id"];
            $lastmodificationdate=$resource["last-modification-date"];
        }else{
            $resource=new GenericResource($resource,false);
            $id=$resource->getObjid();
            $lastmodificationdate=$resource->getLastModificationDate();
        }
        $body='<param last-modification-date"'.$lastmodificationdate.'"/>';
        $this->send($this-url."/".$id."deactivate",'POST',$body);
    }
    /**
     *
     * @param GenericResource $id
     * @param array $id array("id"=>"escidoc:","last-modification-date"=>"201110....")
     * @param array $selector array(GroupSelector, GroupSelector,...)
     * @return type 
     */
    public function addSelectors($resource,$selectors){
        if (is_array($resource)){
            $id=$resource["id"];
            $lastmodificationdate=$resource["last-modification-date"];
        }else{
            $resource=new GenericResource($resource,false);
            $id=$resource->getObjid();
            $lastmodificationdate=$resource->getLastModificationDate();
        }
          $body='<param last-modification-date="'.$lastmodificationdate.'">';
          foreach ($selectors as $selector){
              if ($selector instanceof GroupSelector){
                $body.='<selector name="'.$selector->getName().'" type="'.$selector->getType().'">'.$selector->getSelector().'</selector>';                
              }
              else
                throw new IllegalArgumentException("only Group Selectors are allowed");
          }
          $body.='</param>';
                   
        return new TaskResult($this->send($this->url."/".$id."/selectors/add",'POST',$body),false);
    }
    /**
     *
     * @param GenericResource $id
     * @param array $id array("id"=>"escidoc:","last-modification-date"=>"201110....")
     * @param array $selector array(GroupSelector, GroupSelector,...)
     * @return type 
     */
    public function removeSelectors($resource,$selectors){
        if (is_array($resource)){
            $id=$resource["id"];
            $lastmodificationdate=$resource["last-modification-date"];
        }else{
            $resource=new GenericResource($resource,false);
            $id=$resource->getObjid();
            $lastmodificationdate=$resource->getLastModificationDate();
        }
          $body='<param last-modification-date="'.$lastmodificationdate.'">';
          foreach ($selectors as $selector)
            $body.='<id>'.$selector->getObjid().'</id>';
          $body.='</param>';
        return new TaskResult($this->send($this->url."/".$id."/selectors/remove",'POST',$body),false);
    }
    
    /**
     *
     * @param GenericResource $groupresource
     * @param string $groupresource
     * @param GenericResource $grantresource
     * @param array $grantresource array("id"=>"escidoc:","last-modification-date"=>"201110....")
     * @param string $revocationmark
     */
    public function revokeGrant($groupresource,$grantresource,$revocationmark){
        
        if (is_a($groupresource,"escidoc\Resource")){
            $groupresource=new GenericResource($groupresource,false);
            $id=$groupresource->getObjid();
        }else{
            $id=$groupresource;
        }  
        
        if (is_array($grantresource)){
            $grantid=$grantresource["id"];
            $lastmodificationdate=$grantresource["last-modification-date"];
        }else{
            $grantresource=new GenericResource($grantresource,false);
            $grantid=$grantresource->getObjid();
            $lastmodificationdate=$grantresource->getLastModificationDate();
        }        
       
        $remokemsg='<param last-modification-date="'.$lastmodificationdate.'">'.$revocationmark.'<revocation-remark/></param>';
        
        $this->send($this->url."/".$id."/resources/grants/grant/".$grantid."/revoke-grant",'POST',$remokemsg);
    }
    public function revokeGrants(){}

}
?>
