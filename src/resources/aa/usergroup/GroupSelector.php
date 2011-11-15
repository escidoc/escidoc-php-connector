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


require_once "resources/NamedSubResource.php";
use \Exception as Exception;

class GroupSelector extends NamedSubResource{
    public function __construct($resource=null, $copy=true) {
        if ($resource !=null) parent::__construct($resource, $copy);
        else parent::__construct (file_get_contents(dirname(__FILE__)."/../../../templates/groupselector.xml"));
    }
    /**
     *
     * @return string
     */
    public function getType(){
        return $this->getRootNode()->getAttribute("type");
    }
    /**
     *
     * @param string $type
     * @return void
     */
    public function setType($type){
        $this->getRootNode()->setAttribute("type",$type);
    }
        /**
     *
     * @return string
     */
    public function getSelector(){
        $values=$this->xpath('./user-group:selector');
        if ($values->length!=1) throw new Exception ("Resource does not contain a selector");
        return $values->item(0)->nodeValue;        
    }
    /**
     *
     * @param string $selector
     * @return void
     */
    public function setSelector($selector){
        $values=$this->xpath('./user-group:selector');
        if ($values->length!=1) throw new Exception ("Resource does not contain a selector");
        $values->item(0)->nodeValue=$selector;        

    }   
}


?>
