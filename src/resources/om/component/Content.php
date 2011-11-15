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

class Content extends XLinkResource{
    public function __construct($resource=null, $copy=true) {

        if ($resource!=null) {
            parent::__construct($resource, $copy);
        }else{
            parent::__construct(file_get_contents(dirname(__FILE__)."../../../../../templates/content.xml"));
        }
    }
    /**
     *
     * @return string
     */
    public function getStorage(){
        return $this->getRootNode()->getAttribute("storage");
    }
    /**
     *
     * @param string $storagetype one of "internal-managed", "external-url", "external-managed"
     */
    public function setStorage($storagetype){
        $this->getRootNode()->setAttribute("storage",$storagetype);
    }
}

?>
