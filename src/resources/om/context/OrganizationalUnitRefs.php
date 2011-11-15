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

require_once 'resources/ResourceList.php';
require_once 'resources/common/reference/Reference.php';

class OrganizationalUnitRefs extends ResourceList{
    public function __construct($resource, $copy=true) {
        parent::__construct($resource, $copy);
    }

    /**
     *
     * @return OrganizationalUnitRef[]
     */
    public function getArray(){
        return parent::getArray();
    }
     /**
     *
     * @param string $objid
     * @return OrganizationalUnitRef
     */
    public function get($objid){
        $this->xpath('/srel:organizational-unit[@xlink:href="'.$objid.'"]');
        return new OrganizationalUnitRef($node->item(0),false);
    }
    /**
     *
     * @param string $objid
     */
    public function del($objid){
        $this->importResource(".", null, '/srel:organizational-unit[@xlink:href="/oum/organizational-unit/'.$objid.'"]');        
    }
    /**
     *
     * @param OrganizationalUnitRef
     */
    public function add($component){
        $record=new OrganizationalUnitRef($component,false);
        $this->importResource(".", $record,'./srel:organizational-unit[@xlink:href="/oum/organizational-unit/'.$record->getObjid().'"]');
    }
    /**
     *return item at index $index beginning from 0
     * @param int $index
     * @return OrganizationalUnitRef
     */
    public function item($index){
        return parent::item($index);
    }

}



?>
