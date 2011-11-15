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

require_once "resources/VersionableResource.php";
require_once "resources/om/item/component/Components.php";
require_once "resources/om/item/ItemProperties.php";
require_once "resources/common/MetadataRecords.php";
require_once "resources/common/reference/Reference.php";

use \Exception as Exception;

class Item extends VersionableResource{

    public function __construct($resource=null, $copy=true) {
        if ($resource !=null) parent::__construct($resource, $copy);
        else parent::__construct (file_get_contents(dirname(__FILE__)."../../../../templates/item.xml"));
        
        if ($this->getRootNode()->localName != "item")
            throw new Exception ("localName ".$this->getRootNode()->localName." does not look like an item" );
    }
    /**
     *
     * @return ItemProperties
     */
    public function getProperties (){
        $values=$this->xpath("/escidocItem:properties");
        if ($values->length!=1) throw new Exception ("Item does not contain properties".$this->__toString());
        return new ItemProperties($values->item(0),false);
    }
    /**
     *
     * @return Components
     */
    public function getComponents (){
        $values=$this->xpath('/*[local-name()="components"]');
        if ($values->length!=1) throw new Exception ("Item does not contain components");
        return new Components($values->item(0),false);
    }
    /**
     *
     * @return MetadataRecords
     */
    public function getMetadataRecords (){
        $values=$this->xpath("/escidocMetadataRecords:md-records");
        if ($values->length!=1) throw new Exception ("Item does not contain md-records");
        return new MetadataRecords($values->item(0),false);
    }
    /**
     *
     * @return Relations
     */
    public function getRelations (){
        $values=$this->xpath("/relations:relations");
        if ($values->length!=1) throw new Exception ("Item does not contain relations");
        return new Relations($values->item(0),false);
    }
    /**
     *
     * @param Components $components
     */
    public function setComponents ($components){
        $this->importResource('.', $components,'./*[local-name()="components"]');
    }
    /**
     *
     * @param MetadataRecords $metadataRecords
     */
    public function setMetadataRecords ($metadataRecords){
        $this->importResource(".",$metadataRecords,"./escidocMetadataRecords:md-records");
    }
    /**
     *
     * @param Relations $relations
     */
    public function setRelations ($relations){
        $this->importResource(".",$relations,"./relations:relations");
    }
/*    ContentStreams 	getContentStreams ()
    public funcion setContentStreams ($contentStreams)
    */

    protected function getResourceType(){
        return "item";
    }
}

?>
