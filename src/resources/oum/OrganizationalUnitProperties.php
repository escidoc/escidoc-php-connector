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

require_once '/resources/common/reference/Reference.php';
require_once '/resources/common/properties/CommonProperties.php';

class OrganizationalUnitProperties extends CommonProperties{
    /**
     *
     * @return UserAccountRef
     */
    public function getModifiedBy(){
        $values=$this->xpath('/srel:modified-by');
        if ($values->length!=1) throw new Exception ("Resource does not contain created-by");
        return new UserAccountRef($values->item(0),false);
    }
    /**
     *
     * @return string
     */
    public function getName(){
        $values=$this->xpath('/prop:name');
        if ($values->length!=1) throw new Exception ("container does not contain name");
        return $values->item(0)->nodeValue;
    }
    /**
     *
     * @param string $name
     */
    public function setName($name){
        $values=$this->xpath('/prop:name');
        if ($values->length!=1) throw new Exception ("container does not contain name");
        $values->item(0)->nodeValue=$name;
    }
    /**
     *
     * @return string
     */
    public function getPublicStatus (){
        $values=$this->xpath('/prop:public-status');
        if ($values->length!=1) throw new Exception ("Resource does not contain public-status");
        return $values->item(0)->nodeValue;
    }
    /**
     *
     * @return string
     */
    public function getPublicStatusComment (){
        $values=$this->xpath('/prop:public-status-comment');
        if ($values->length!=1) throw new Exception ("Resource does not contain public-status-comment");
        return $values->item(0)->nodeValue;
    }
    /**
     *
     * @return string
     */
    public function getDescription (){
        $value=$this->xpath('/prop:description');
        if ($value->length<1) throw Exception("Context has no description");
        return $value->item(0)->nodeValue;
    }
 //   String 	getExternalIds ()
 //   Boolean 	getHasChildren ()
 //   String 	getHasChildrenAsString ()
}
?>
