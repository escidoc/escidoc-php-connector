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

require_once "resources/interfaces/common/Version.php";

class VersionImpl extends XMLNode implements Version{
    public function __construct($resource, $copy=true) {
        parent::__construct($resource, $copy);
    }
    /**
     *
     * @return string
     */
    public function getDate(){
        $value=$this->xpath("/prop:version/version:date");
        if ($value->length!=1) throw new Exception ("Resource has no version date");
        return $value->item(0)->nodeValue;
    }
    /**
     *
     * @return string
     */
    public function getNumber(){
        $value=$this->xpath("/prop:version/version:number");
        if ($value->length!=1) throw new Exception ("Resource has no version number");
        return $value->item(0)->nodeValue;
    }
    /**
     *
     * @return string
     */
    public function getPid(){
        $values=$this->xpath('/prop:pid');
        if ($values->length!=1) throw new Exception ("Resource does not contain pid");
        return $values->item(0)->nodeValue;
    }
    /**
     *
     * @return UserAccountRef
     */
    public function getModifiedBy(){
        $value=$this->xpath("/prop:version/srel:modified-by");
        if ($value->length!=1) throw new Exception ("Resource has no modifier information");
        return new UserAccountRef($value->item(0),false);
    }
    /**
     *
     * @return string
     */
    public function getComment(){
        $value=$this->xpath("/prop:version/version:comment");
        if ($value->length!=1) throw new Exception ("Resource has no comment");
        return $value->item(0)->nodeValue;
    }
    /**
     *
     * @return string
     */
    public function getStatus(){
        $value=$this->xpath("/prop:version/version:status");
        if ($value->length!=1) throw new Exception ("Resource has no status");
        return $value->item(0)->nodeValue;
    }
}

?>
