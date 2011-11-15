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

require_once "resources/XLinkResource.php";
require_once "resources/common/reference/Reference.php";

class StructMap extends XLinkResource{

    public function __construct($resource=null, $copy=true) {
        if ($resource!=null)
            parent::__construct($resource, $copy);
        else
            parent::__construct(file_get_contents(dirname(__FILE__)."/../../../templates/structmap.xml"));
    }
    /**
     *
     * @return ItemRef[]
     */
    public function getItems (){
        $refs=array();
        foreach ($this->xpath("/srel:item") as $item)
            $refs[]=new ItemRef ($item,false);
        return $refs;
    }
    /**
     *
     * @return ContainerRef[]
     */
    public function getContainers (){
        $refs=array();
        foreach ($this->xpath("/srel:container") as $container)
            $refs[]=new ContainerRef($container,false);
        return $refs;
    }
    /**
     * is more a getAllRefs-function
     * 
     * @return Reference[]
     */
    public function iterator(){
        $refs=array();
        foreach ($this->xpath("/*") as $reference)
            $refs[]=new Reference ($reference,false);
        return $refs;
    }
}
?>
