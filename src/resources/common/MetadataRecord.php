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


class MetadataRecord extends NamedSubResource{
    public function __construct($resource=null, $copy=true) {
        if ($resource !=null) parent::__construct($resource, $copy);
        else parent::__construct (file_get_contents(dirname(__FILE__)."/../../templates/MetadataRecord.xml"));
    }
    /**
     *
     * @return XMLNode
     */
    public function getContent(){
        $values=$this->xpath("/*");
        if ($values->length!=1)
            return "";
        return new XMLNode($values->item(0),false);
    }
    /**
     *
     * @param XMLNode|string $content anything, that can be converted in an XMLNode
     * @return void
     */
    public function setContent($content){
        $this->importResource(".",$content,"./*");
    }


    /**
     *
     * @return string
     */
    public function getMdType(){
        return $this->getRootNode()->getAttribute("md-type");
    }
    /**
     *
     * @param string $type
     * @return void
     */
    public function setMdType($type){
        $this->getRootNode()->setAttribute("md-type",$type);
    }
        /**
     *
     * @return string
     */
    public function getSchema(){
        return $this->getRootNode()->getAttribute("schema");
    }
    /**
     *
     * @param string $type
     * @return void
     */
    public function setSchema($schema){
        $this->getRootNode()->setAttribute("schema",$schema);
    }
    
}


?>
