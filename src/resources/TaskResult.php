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

require_once 'resources/XMLNode.php';

class TaskResult extends XMLNode{

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
}

?>
