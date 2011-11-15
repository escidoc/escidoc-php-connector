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


require_once "resources/ResourceList.php";
require_once 'resources/common/MetadataRecord.php';

class MetadataRecords extends ResourceList{
    public function __construct($resource, $copy=true) {
        parent::__construct($resource, $copy);
    }

    /**
     *
     * @param string $name
     */
    public function get($name){
        $value=$this->xpath('/escidocMetadataRecords:md-record[@name="'.$name.'"]');
        return new MetadataRecord($value->item(0), false);
    }
    /**
     *
     * @param string $name
     */
    public function del($name){
        $this->importResource(".", null, './escidocMetadataRecords:md-record[@name="'.$name.'"]');        
    }
    /**
     *
     * @param MetadataRecord $mdrecord
     */
    public function add($mdrecord){
        $record=new MetadataRecord($mdrecord,false);
        $this->importResource(".", $record,'./escidocMetadataRecords:md-record[@name="'.$record->getName().'"]');
    }
      
    /**
     *return item at index $index beginning from 0
     * @param int $index
     * @return MetadataRecord
     */

    public function item($index){
        return parent::item($index);
    }

    /**
     *
     * @return MetadataRecord[]
     */
    public function getArray(){
        return parent::getArray();
    }
}

?>
