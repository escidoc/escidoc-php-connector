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
require_once 'resources/om/item/component/Component.php';

class Components extends ResourceList{
    public function __construct($resource, $copy=true) {
        parent::__construct($resource, $copy);
    }
    /**
     *
     * @return Component[]
     */
    public function getArray(){
        return parent::getArray();
    }
    /**
     *
     * @param string $objid 
     */
    public function get($objid){
        $value=$this->xpath('/escidocComponents:component[contains(@xlink:href,"'.$objid.'")]');
        return new Component($value->item(0), false);
    }
    /**
     *
     * @param string $objid
     */
    public function del($objid){
        $this->importResource(".", null, './escidocComponents:component[contains(@xlink:href,"'.$objid.'")]');
    }
    /**
     *
     * @param Component
     */
    public function add($component){
        $this->importResource('.', $component);
    }
    /**
     *return item at index $index beginning from 0
     * @param int $index
     * @return Component
     */
    public function item($index){
        return parent::item($index);
    }
}

?>
