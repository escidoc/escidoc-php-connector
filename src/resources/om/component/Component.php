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
namespace escidoc;

require_once "resources/GenericResource.php";
require_once "resources/common/MetadataRecords.php";
require_once 'resources/om/item/component/ComponentProperties.php';
require_once 'resources/om/item/component/ComponentContent.php';


class Component extends GenericResource{
    public function __construct($resource=null, $copy=true) {
        if ($resource !=null) parent::__construct($resource, $copy);
        else parent::__construct (file_get_contents(dirname(__FILE__)."../../../../../templates/component.xml"));
    }
    public function getContent (){

        $values=$this->xpath("/escidocComponents:content");
        if ($values->length!=1) throw new Exception ("Component does not contain content");        
        return new ComponentContent($values->item(0),false);
    }
    /**
     *
     * @param ComponentContent $content
     */
    public function setContent ($content){
        $this->importResource(".",$content,"./escidocComponents:content");
    }
    /**
     *
     * @return MetadataRecords
     */
    public function getMetadataRecords (){
        $values=$this->xpath('/escidocMetadataRecords:md-records');
        if ($values->length!=1) throw new Exception ("Component does not contain md-records");
        return new MetadataRecords($values->item(0),false);
    }
    /**
     *
     * @param MetadataRecords $metadataRecords
     */
    public function setMetadataRecords ($metadataRecords){
        $this->importResource('.',$metadataRecords,'./escidocMetadataRecords:md-records');
    }
    /**
     *
     * @return ComponentProperties
     */
    public function getProperties (){
        $values=$this->xpath('/escidocComponents:properties');
        if ($values->length!=1) throw new Exception ("Component does not contain properties");
        return new ComponentProperties($values->item(0),false);
    }
}
?>
