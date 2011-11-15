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

use \Exception as Exception;

require_once 'resources/GenericResource.php';
require_once 'resources/common/MetadataRecords.php';
require_once 'resources/oum/OrganizationalUnitProperties.php';

class OrganizationalUnit extends GenericResource{
    public function  	getProperties (){
        $values=$this->xpath("/organizational-unit:properties");
        if ($values->length!=1) throw new Exception ("Item does not contain properties");
        return new OrganizationalUnitProperties($values->item(0),false);
    }

    //public function getParents (){ Parents }

    public function getMetadataRecords (){
        $values=$this->xpath("/escidocMetadataRecords:md-records");
        if ($values->length!=1) throw new Exception ("Organizational-Unit does not contain md-records");
        return new MetadataRecords($values->item(0),false);
    }

//    public function getPredecessors (){      Predecessors 	    }

    public function setMetadataRecords ($metadataRecords){
        $this->importResource(".",$metadataRecords,"./escidocMetadataRecords:md-records");
    }


    protected function 	getResourceType (){
        return "organizational-unit";
    }
}
?>
