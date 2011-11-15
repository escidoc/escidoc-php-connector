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

class AdminDescriptor extends NamedSubResource{

    public function __construct($resource, $copy=true) {
        parent::__construct($resource, $copy);
    }
    /**
     * @return XMLNode
     */
    public function getContent (){
        $value=$this->xpath("./*");
        if ($value->length<1) throw Exception("Context has no admin-descriptor");
        return new XMLNode($value->item(0),false);
    }
    /**
     *
     * @return string
     */
    public function getContentAsString () {
        return $this->getContent()->__toString();
    }
    /**
     *
     * @param [DOMNode,DOMElement,DOMDocument,string] $content
     */
    public function setContent ($content){
        $this->importResource(".",$content,"./*");        
    }
}

?>
