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

require_once "resources/GenericResource.php";
require_once "resources/aa/useraccount/GrantProperties.php";

class Role extends GenericResource{
    public function __construct($resource, $copy=true) {
        parent::__construct($resource, $copy);
    }
    /**
     *
     * @return GrantProperties
     */
    public function getProperties (){
        $values=$this->xpath("/role:properties");
        //if ($values->length<1) throw new Exception ("Resource does not contain properties");
        
        throw new Exception ("Role properties not yet implemented");
        
        return new RoleProperties($values->item(0),false);
    }
//    public function getReference (){//        GrantRef }
}

?>
