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

use \Exception as Exception;

class ComponentProperties extends CommonProperties{
    // Description was discarded in 2008
    // void 	setDescription (final String description)
    // String 	getDescription ()
    public function __construct($resource, $copy=true) {
        parent::__construct($resource, $copy);
    }
    /**
     *
     * @return string
     */
    public function getContentCategory (){
        $value=$this->xpath("/prop:content-category");
        if ($value->length<1) throw new Exception("Component has no content category");
        return $value->item(0)->nodeValue;
    }
    /**
     *
     * @param string $contentCategory
     */
    public function setContentCategory ($contentCategory){
        $value=$this->xpath("/prop:content-category");
        if ($value->length<1) throw new Exception("Component has no content category");
        $value->item(0)->nodeValue=$contentCategory;
    }
    /**
     *
     * @return string
     */
    public function getFileName (){
        $value=$this->xpath("/prop:file-name");
        if ($value->length<1) throw new Exception("Component has no file name");
        return $value->item(0)->nodeValue;
    }
    /**
     *
     * @return string
     */
    public function getMimeType (){
        $value=$this->xpath("/prop:mime-type");
        if ($value->length<1) throw new Exception("Component has no mime type");
        return $value->item(0)->nodeValue;
    }
    /**
     *
     * @param string $mimeType
     */
    public function setMimeType ($mimeType){
        $value=$this->xpath("/prop:mime-type");
        if ($value->length<1) throw new Exception("Component has no mime type");
        $value->item(0)->nodeValue=$mimeType;
    }
    /**
     *
     * @param string $validStatus
     */
    public function setValidStatus ($validStatus){
        $value=$this->xpath("/prop:valid-status");
        if ($value->length<1) throw new Exception("Component has no valid status");
        $value->item(0)->nodeValue=$validStatus;
    }
    /**
     *
     * @return string
     */
    public function getValidStatus (){
        $value=$this->xpath("/prop:valid-status");
         if ($value->length<1) throw new  Exception("Component has no valid status");
        return $value->item(0)->nodeValue;
    }
    /**
     *
     * @return string
     */
    public function getVisibility (){
        $value=$this->xpath("/prop:visibility");
        if ($value->length<1) throw new Exception("Component has no visibility");
        return $value->item(0)->nodeValue;
    }
    /**
     *
     * @param string $visibility
     */
    public function setVisibility ($visibility){
        $value=$this->xpath("/prop:visibility");
        if ($value->length<1) throw new Exception("Component has no visibility");
        $value->item(0)->nodeValue=$visibility;
    }
    /**
     *
     * @return string
     */
    public function getChecksum (){
        $value=$this->xpath("/prop:checksum");
        if ($value->length<1) throw new Exception("Component has no checksum");
        return $value->item(0)->nodeValue;
    }
    /**
     *
     * @return string
     */
    public function getChecksumAlgorithm (){
        $value=$this->xpath("/prop:checksum-algorithm");
        if ($value->length<1) throw new Exception("Component has no checksum algorithm");
        return $value->item(0)->nodeValue;
    }
    /**
     *
     * @return string
     */
    public function getPid (){
        $values=$this->xpath("/prop:pid");
        if ($values->length!=1) throw new Exception ("Component does not contain pid");
        return $values->item(0)->nodeValue;
    }
    /**
     *
     * @param string $pid
     */
    public function setPid ($pid){
        $values=$this->xpath("/prop:pid");
        if ($values->length!=1) throw new Exception ("Component does not contain pid");
         $values->item(0)->nodeValue=$pid;
    }
}

?>
