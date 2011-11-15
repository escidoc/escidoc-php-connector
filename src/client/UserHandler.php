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

class UserHandler extends OMBase{
     /**
     * @param Authentication $authobject
     */

    public function __construct($authobject) {
        parent::__construct($authobject);
        $this->url="/aa/user-account";
    }
    public function create($data) {
        return new UserAccount(parent::create($data),false);
    }
    public function retrieve($id) {
        return new UserAccount(parent::retrieve($id));
    }
    public function update($id, $data) {
        return new UserAccount(parent::update($id, $data));
    }

    public function retrieveCurrentUser(){
        return new UserAccount($this->send($this->url."/current",'GET',''),false);
    }

    public function retrieveResources($id){
        return ($this->send($this->url."/".$id."/resources",'GET',''));
    }
    /*
    createResources
    retrievePreference
    updatePreference
    deletePreference
    retrievePreverences
    updatePreferences*/

    public function retrieveCurrentGrants($id){
        return ($this->send($this->url."/".$id."/resources/current-grants",'GET',''));
    }
    public function createGrant($id,$body){
        return ($this->send($this->url."/".$id."/resources/grants/grant",'PUT',$body));
    }
    public function retrieveGrant($id,$grantid){
        return new Grant($this->send($this->url."/".$id."/resources/grants/grant".$grantid,'GET',''));
    }
    /** 
     * @param array $criteria array("operation"=> "searchRetrieve|explain","query"=>"SRU compiant Query","startRecord" => "int","maximumRecords" => "int")
     * @return SearchRetrieveResponse
     */
    public function retrieveUserAccounts($criteria){
        return ($this->filter($this->url."s",$criteria));
    }
    /*
    activate
    deactivate*/
    
    /**
     * @param GenericResource $resource
     * @param array $resource array("id"=>"escidoc....","last-modification-date"=>"2011...time...")
     * @param string $password
     */    
    public function updatePassword($resource,$password){
        if (is_array($resource)){
            $id=$resource["id"];
            $lastmodificationdate=$resource["last-modification-date"];
        }else{
            $resource=new GenericResource($resource,false);
            $id=$resource->getObjid();
            $lastmodificationdate=$resource->getLastModificationDate();
        }       
        $body='<param last-modification-date="'.$lastmodificationdate.'">'; 
        $body.='<password>'.$password.'</password>';
        $body.='</param>';            
        $this->send($this->url."/".$id."/update-password",'POST',$body);
    }
    /**
     * @param GenericResource $resource
     * @param array $resource array("id"=>"escidoc....","last-modification-date"=>"2011...time...")
     * @param GenericResource $grantid
     * @param string $grantid
     * @param string $revocationmark
     */
    public function revokeGrant ($resource, $grantid, $revocationmark){
         if (is_array($resource)){
            $id=$resource["id"];
            $lastmodificationdate=$resource["last-modification-date"];
        }else{
            $resource=new GenericResource($resource,false);
            $id=$resource->getObjid();
            $lastmodificationdate=$resource->getLastModificationDate();
        }       
        $body='<param last-modification-date="'.$lastmodificationdate.'">'; 
        $body.='<revocation-mark>'.$revocationmark.'</revocation-mark>';
        $body.='</param>';        
        $this->send($this->url."/".$userid."/resources/grants/grant/".$grantid."/revoke-grant",'POST',$body);
    }
    /*    
    revokeGrants*/
    
     /** 
     * @param array $criteria array("operation"=> "searchRetrieve|explain","query"=>"SRU compiant Query","startRecord" => "int","maximumRecords" => "int")
     * @return SearchRetrieveResponse
     */
    public function retrieveGrants($criteria){
        return ($this->filter("/aa/grants",$criteria));
    }
    
    /**
     *
     * @param GenericResource $resource
     * @param Attribute $attribute
     * @return Attribute 
     */
    public function createAttribute($id,$attribute){
        if ($id instanceof Resource) $id=$id->getObjid ();
        if (is_a($attribute, "XMLNode"))
            $body=$attribute->__toString();
        return new Attribute($this->send($this->url."/".$id."resources/attributes/attribute","PUT",$body));
    }
    /**
     *
     * @param string $userid
     * @param Resource $userid
     * @param string $attid
     * @param Resource $attid
     * @return Attribute 
     */
    public function retrieveAttribute($userid,$attid){
        if ($userid instanceof Resource) $userid=$userid->getObjid ();
        if ($attid instanceof Resource) $attid=$attid->getObjid ();
        return new Attribute($this->send($this->url."/".$userid."resources/attributes/attribute/".$attid,"GET",""));
    }
    /**
     *
     * @param string $userid
     * @param Resource $userid
     * @param string $attid
     * @param Resource $attid
     * @param Resource $newattribute
     * @return Attribute 
     */
    public function updateAttribute($user,$attribute,$newattribute) {
        if ($userid instanceof Resource) $userid=$userid->getObjid ();
        if ($attid instanceof Resource) $attid=$attid->getObjid ();
        if (is_a($attribute, "XMLNode"))
            $body=$attribute->__toString();      
        return new Attribute($this->send($this->url."/".$userid."resources/attributes/attribute/".$attid,"PUT",$body));
    }
    /**
     *
     * @param string $userid
     * @param Resource $userid
     * @param string $attid
     * @param Resource $attid
     */
    public function deleteAttributes($userid,$attid){
        //Hmm Documentation -> is 204 Success?
        if ($userid instanceof Resource) $userid=$userid->getObjid ();
        if ($attid instanceof Resource) $attid=$attid->getObjid ();        
        $this->send($this->url."/".$userid."resources/attributes/attribute/".$attid,"DELETE","");
    }
    /**
     *
     * @param string $userid
     * @return ResourceList 
     */
    public function retrieveAttributes($userid){
        return new ResourceList($this->send($this->url."/".$userid."/resources/attributes","GET",""),false);
    }
    public function retrieveNamedAttributes($userid,$attname){
        return ($this->send($this->url."/".$userid."/resources/attributes".$attname,"GET",""));
    }
}
?>
