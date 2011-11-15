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

require_once "resources/NamedSubResource.php";

class Attribute extends NamedSubResource {
    public function __construct($resource, $copy=true) {
        parent::__construct($resource, $copy);
    }
    /**
     *
     * @param string $value
     */
    public function setValue ($value){
        $values=$this->xpath('/.');
        if ($values->length!=1) throw new Exception ("Resource does not contain attribute");
        $values->item(0)->nodeValue=$value;
    }
    /**
     *
     * @return string
     */
    public function getValue (){
        $values=$this->xpath('/.');//attributes:attribute
        if ($values->length!=1) throw new Exception ("Resource does not contain attribute");
        return $values->item(0)->nodeValue;
    }
    /**
     *
     * @return string
     */
    public function getLastModificationDate (){
        return $this->getRootNode()->getAttribute("last-modification-date");
    }
    /**
     * @return bool
     */
    public function isInternal (){
        if ($this->getRootNode()->getAttribute("internal")=="true")
            return true;
        return false;
    }
}

    ?>
