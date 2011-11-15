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

require_once 'resources/Resource.php';
require_once 'resources/common/reference/Reference.php';

class GenericResource extends Resource{

    public function __construct($resource, $copy=true) {
        parent::__construct($resource, $copy);
    }
    /**
     *
     * @return string
     */
    public function getLastModificationDate (){
        return $this->getRootNode()->getAttribute("last-modification-date");
    }
    /**
     *
     * @return bool
     */
    public function isLocked (){
        $values=$this->xpath('/*[local-name()="properties"]/prop:lock-status');
        if ($values->length>0){
            $status=$values->item(0)->nodeValue;
            if ($status=="locked")
               return true;
        }
        return true;
    }
    /**
     *
     * @return UserAccountRef
     */
    public function getLockOwner (){
        $values=$this->xpath('/*[local-name()="properties"]/prop:lock-date');
        if ($values->length==0)
             return false;
        return new UserAccountRef($values->item(0));
    }
    /**
     *
     * @return string
     * @return false  not locked
     */
    public function getLockDate (){
        $values=$this->xpath('/*[local-name()="properties"]/prop:lock-date');
        if ($values->length==0)
             return false;
        return $values->item(0)->nodeValue;
    }
    /**
     *
     * @return string
     */
    public function getObjectPid (){
        $values=$this->xpath('/*[local-name()="properties"]/prop:pid');
        if ($values->length==0)
             return false;
        return $values->item(0)->nodeValue;
    }
}

?>
