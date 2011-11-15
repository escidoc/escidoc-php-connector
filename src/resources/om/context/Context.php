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

require_once "resources/GenericResource.php";
require_once "resources/om/context/ContextProperties.php";

class Context extends GenericResource{

    public function __construct($resource, $copy=true) {
        parent::__construct($resource, $copy);
    }
    /**
     *
     * @return ContextProperties
     */
    public function getProperties (){
        $value=$this->xpath("/context:properties");
        if ($value->length<1) throw Exception("Context has no properties");
        return new ContextProperties($value->item(0),false);
    }
    /**
     *
     * @return AdminDescriptors
     */
    public function getAdminDescriptors (){
        $value=$this->xpath("/context:admin-descriptors");
        if ($value->length<1) throw Exception("Context has no properties");
        return new AdminDescriptors($value->item(0),false);
    }
    /**
     *
     * @param AdminDescriptors $adminDescriptors
     */
    public function setAdminDescriptors ($adminDescriptors){
        $this->importResource(".", $adminDescriptors,"./context:admin-descriptors");
    }
    /**
     *
     * @return string
     */
    protected function getResourceType() {
        return "context";
    }
}

?>
