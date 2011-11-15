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
require_once "resources/om/container/ContainerProperties.php";
require_once 'resources/common/MetadataRecords.php';
require_once "resources/common/structmap/StructMap.php";

use \Exception as Exception; 

class Container extends VersionableResource{
    public function __construct($resource=null, $copy=true) {
        if ($resource!=null)
            parent::__construct($resource, $copy);
        else
            parent::__construct(file_get_contents(dirname(__FILE__)."../../../../templates/container.xml"));
        
        if ($this->getRootNode()->localName != "container")
            throw new Exception ("localName ".$this->getRootNode()->localName." does not look like an container" );        
        
    }
    /**
     *
     * @return ContainerProperties
     */
    public function getProperties (){
        $values=$this->xpath("/container:properties");
        if ($values->length!=1) throw new Exception ("container does not contain properties");
        return new ContainerProperties($values->item(0),false);
    }

    //Relations 	getRelations ()

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
     * @param MetadataRecords $metadataRecords
     * @return void
     */
    public function setMetadataRecords ($metadataRecords){
        $this->importResource(".",$metadataRecords,"./escidocMetadataRecords:md-records");
    }
    /**
     *
     * @return StructMap 
     */
    public function getStructMap (){
        $values=$this->xpath("/struct-map:struct-map");
        if ($values->length==0) return new StructMap();
        if ($values->length==1) return new StructMap($values->item(0),false);
        throw new Exception ("container does contain more than one struct map");
    }
 
    protected function getResourceType(){
        return "container";
    }
}

?>
