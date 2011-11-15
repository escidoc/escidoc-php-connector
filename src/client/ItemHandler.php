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
require_once 'resources/om/item/Item.php';
require_once 'resources/common/versionhistory/VersionHistory.php';

class ItemHandler extends OMBaseWithState{

    /**
     * @param Authentication $authobject
     */
    public function __construct($authobject) {
        parent::__construct($authobject);
        $this->url="/ir/item";
    }
    /**
     *
     * @param string $data
     * @param Resource $data
     * @return Item 
     */
    public function create($data) {
        return new Item (parent::create($data),false);
    }
    /**
     * @param string $id
     * @param Resource $id
     * @return Item 
     */
    public function retrieve($id) {
        return new Item (parent::retrieve($id),false);
    }
    /**
     * @param string $id
     * @param Resource $id
     * @param string $data
     * @param XMLNode $data
     * @return Item 
     */
    public function update($id, $data) {
        return new Item (parent::update($id, $data),false);
    }
    /** 
     * @param array $criteria array("operation"=> "searchRetrieve|explain","query"=>"SRU compiant Query","startRecord" => "int","maximumRecords" => "int")
     * @return SearchRetrieveResponse
     */
    public function retrieveItems($criteria){
        return ($this->filter($this->url."s",$criteria));
    }

    public function assignObjectPid($id,$lastmodification,$pidurl){
        $body=$this->moddatewithxmltag($lastmodification,"url",$pidurl);
        $body=$this->moddatewithxmltag($lastmodification,"pid",$pidurl);
        //check for url?
        $this->send($this->url."/".$id."/assign-object-pid",'POST',$body);
    }
    public function assignVersionPid($id,$lastmodification,$pidurl){
        $body=$this->moddatewithxmltag($lastmodification,"url",$pidurl);
        $body=$this->moddatewithxmltag($lastmodification,"pid",$pidurl);
        //check for url?
        $this->send($this->url."/".$id."/assign-version-pid",'POST',$body);
    }
    public function assignContentPid($id,$lastmodification,$pidurl){
        $body=$this->moddatewithxmltag($lastmodification,"url",$pidurl);
        $body=$this->moddatewithxmltag($lastmodification,"pid",$pidurl);
        //check for url?
        $this->send($this->url."/".$id."/assign-content-pid",'POST',$body);
    }

    public function retrieveVersionHistory($id){
        return new VersionHistory(
                $this->send($this->url."/".$id."/resources/version-history",'GET',''),
                false);
    }
    public function retrieveResources($id){
        return ($this->send($this->url."/".$id."/resources",'GET',''));
    }
    public function retrieveRelations($id){
        return ($this->send($this->url."/".$id."/relations",'GET',''));
    }
    
    public function retrieveContent($id,$componentid){
        return ($this->send($this->url."/".$id."/components/component/".$componentid."/content",'GET',''));
    }
    /*
     * retrieveContent    --- binary with transformation
     * retrieveContentService
     * retrieveContentStreams
     * retrieveContentStream
     * retrieveContentStreamContent
     * addContentRelations
     * removeContentRelations
     */
}
?>
