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

require_once 'resources/XLinkResource.php';
require_once 'resources/common/reference/Reference.php';

class CommonProperties extends XLinkResource{

    public function __construct($resource, $copy=true) {
        parent::__construct($resource, $copy);
    }
    /**
     *
     * @return string
     */
    public function getCreationDate (){
        $values=$this->xpath('/prop:creation-date');
        if ($values->length!=1) throw new Exception ("Resource does not contain creation-date");
        return $values->item(0)->nodeValue;
    }
    /**
     *
     * @return UserAccountRef 
     */
    public function getCreatedBy (){
        $values=$this->xpath('/srel:created-by');
        if ($values->length!=1) throw new Exception ("Resource does not contain created-by");
        return new UserAccountRef($values->item(0),false);
    }
}


?>
