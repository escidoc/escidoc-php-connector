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
require_once 'resources/common/reference/Reference.php';

class UserAccountProperties extends CommonProperties{
    public function __construct($resource, $copy=true) {
        parent::__construct($resource, $copy);
    }
    /**
     *
     * @return string
     */
    public function getName (){
        $values=$this->xpath('/prop:name');
        if ($values->length!=1) throw new Exception ("Resource does not contain name");
        return $values->item(0)->nodeValue;
    }
    /**
     *
     * @param string
     */
    public function setName ($name){
        $values=$this->xpath('/prop:name');
        if ($values->length!=1) throw new Exception ("Resource does not contain name");
        $values->item(0)->nodeValue=$name;
    }
    /**
     *
     * @return string
     */
    public function isActive (){
        $values=$this->xpath('/prop:active');
        if ($values->length!=1) throw new Exception ("Resource does not contain active");
        return $values->item(0)->nodeValue;     //   boolean
    }
    /**
     *
     * @param string
     */
    public function setActive ($isActive){
        $values=$this->xpath('/prop:login-name');
        if ($values->length!=1) throw new Exception ("Resource does not contain active");
        $values->item(0)->nodeValue=$istActive;
    }
    /**
     *
     * @return UserAccountRef
     */
    public function getModifiedBy (){
        $values=$this->xpath('/srel:modified-by');
        if ($values->length!=1) throw new Exception ("Resource does not contain modified-by");
        return new UserAccountRef($values->item(0),false);
    }
    /**
     *
     * @return string
     */
    public function getLoginName (){
        $values=$this->xpath('/prop:login-name');
        if ($values->length!=1) throw new Exception ("Resource does not contain login-name");
        return $values->item(0)->nodeValue;
    }
    /**
     *
     * @param string
     */
    public function setLoginName ($loginName){
        $values=$this->xpath('/prop:login-name');
        if ($values->length!=1) throw new Exception ("Resource does not contain login-name");
        $values->item(0)->nodeValue=$loginName;
    }
}

?>
