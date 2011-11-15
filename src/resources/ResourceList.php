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


require_once "resources/XMLNode.php";
require_once 'resources/Resource.php';

class ResourceList extends XMLNode{
    
    public function __construct($resource, $copy=true) {
        parent::__construct($resource, $copy);
    }
    
    public function clear (){
        $nodelist=array();
        foreach ($this->xpath('/*') as $childnode)
                $nodelist[]=$childnode;
        foreach ($nodelist as $node)
            $node->parentNode->removeChild($node); 
    }

    /**
     * number of items
     * @return int
     */
    public function size(){
        return $this->xpath('/*')->length;
    }
    /**
     *return item at index $index beginning from 0
     * @param int $index
     * @return Resource
     */

    public function item($index){
        $items=$this->xpath('/*');
        if ($index < $items->length )
            return EscidocClassFactory::getClass($items->item($index));
        else
            return null;
    }

    /**
     *
     * @return Resoure[]
     */
    public function getArray(){
        $refs=array();
        foreach ($this->xpath("/*") as $mdrecord) 
            $refs[]=EscidocClassFactory::getClass($mdrecord);
        return $refs;
    }   
}

?>
