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

require_once 'resources/common/reference/Reference.php';


class VersionHistoryElement extends Reference {    
    
    /**
     *
     * @return string 
     */
    public function getObjid(){
        return $this->getRootNode()->getAttribute("objid");
    }
    /**
     *
     * @return string 
     */
    public function getTimeStamp(){
        return $this->getRootNode()->getAttribute(objid);
    }
}                                
?>