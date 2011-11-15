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

require_once "resources/common/properties/CommonProperties.php";
require_once "resources/common/reference/Reference.php";
require_once 'resources/om/context/OrganizationalUnitRefs.php';

class ContextProperties extends CommonProperties{
    public function __construct($resource, $copy=true) {
        parent::__construct($resource, $copy);
    }
    /**
     *
     * @return UserAccountRef
     */
    public function getModifiedBy (){
        $value=$this->xpath("/srel:modified-by");
        if ($value->length<1) throw Exception("Context has no modifier");
        return new UserAccountRef($value->item(0),false);
    }
    /**
     *
     * @return string
     */
    public function getName (){
        $value=$this->xpath("/prop:name");
        if ($value->length<1) throw Exception("Context has no name");
        return $value->item(0)->nodeValue;
    }
    /**
     *
     * @return string
     */
    public function getPublicStatusComment (){
        $value=$this->xpath("/prop:public-status-comment");
        if ($value->length<1) throw Exception("Context has no public-status-comment");
        return $value->item(0)->nodeValue;
    }
    /**
     *
     * @return string
     */
    public function getPublicStatus (){
        $value=$this->xpath("/prop:public-status");
        if ($value->length<1) throw Exception("Context has no public-status");
        return $value->item(0)->nodeValue;
    }
    /**
     *
     * @return string
     */
    public function getDescription (){
        $value=$this->xpath("/prop:description");
        if ($value->length<1) throw Exception("Context has no description");
        return $value->item(0)->nodeValue;
    }
    /**
     *
     * @return string
     */
    public function getType (){
        $value=$this->xpath("/prop:type");
        if ($value->length<1) throw Exception("Context has no type");
        return $value->item(0)->nodeValue;
    }
    /**
     *
     * @return OrganizationalUnitRefs 
     */
    public function getOrganizationalUnitRefs (){
        $value=$this->xpath("/prop:organizational-units");
        if ($value->length<1) throw Exception("Context has no organizational-units");
        return new OrganizationalUnitRefs($value->item(0),false);
    }
}

?>
