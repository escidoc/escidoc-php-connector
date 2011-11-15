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


class AdminDescriptors extends ResourceList{

    public function __construct($resource, $copy=true) {
        parent::__construct($resource, $copy);
    }

    /**
     *
     * @return Admindescriptor[]
     */
    public function getArray(){
        parent::getArray();
    }
    /**
     *
     * @param string $name
     */
    public function get($name){
        $value=$this->xpath('/context:admin-descriptor[@name="'.$name.'"]');
        return new AdminDescriptor($value->item(0), false);
    }
    /**
     *
     * @param string $name
     */
    public function del($name){        
        $this->importResource(".", null, './context:admin-descriptor[@name="'.$name.'"]');                
    }
    /**
     *
     * @param AdminDescriptor
     */
    public function add($component){
        $record=new AdminDescriptor($component,false);
        $this->importResource(".", $record,'./context:admin-descriptor[@name="'.$record->getName().'"]');
    }
    /**
     *return item at index $index beginning from 0
     * @param int $index
     * @return AdminDescriptor
     */

    public function item($index){
        return parent::item($index);
    }

}

?>
