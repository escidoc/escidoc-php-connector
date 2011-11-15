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
use \DOMDocument as DOMDocument;

require_once 'resources/common/properties/CommonProperties.php';
require_once 'resources/common/properties/VersionImpl.php';

class VersionableResourceProperties extends CommonProperties{
    public function __construct($resource, $copy=true) {
        parent::__construct($resource, $copy);
    }
    /**
     *
     * @return string
     */
    public function getPublicStatus (){
        $values=$this->xpath('/prop:public-status');
        if ($values->length!=1) throw new Exception ("Resource does not contain public-status");
        return $values->item(0)->nodeValue;
    }
    /**
     *
     * @return string
     */
    public function getPublicStatusComment (){
        $values=$this->xpath('/prop:public-status-comment');
        if ($values->length!=1) throw new Exception ("Resource does not contain public-status-comment");
        return $values->item(0)->nodeValue;
    }
    /**
     *
     * @return ContentModelRef
     */
    public function getContentModel (){
        $values=$this->xpath('/srel:content-model');
        if ($values->length!=1) throw new Exception ("Resource does not contain content-model");
        return new ContentModelRef($values->item(0),false);
    }
    /**
     *
     * @return string
     */
    public function getLockDate (){
        $values=$this->xpath('/prop:lock-date');
        if ($values->length!=1) throw new Exception ("Resource does not contain lock-date");
        return $values->item(0)->nodeValue;
    }
    /**
     *
     * @return VersionImpl
     */
    public function getVersion (){
        return new VersionImpl($this->getRootNode(),false);
    }
    /**
     *
     * @return LatestVersion
     */
    public function getLatestVersion (){
        return $this->getVersion();
    }
    /**
     *
     * @return LatestRelease
     */
    public function getLatestRelease (){
        return $this->getVersion();
    }
    /**
     *
     * @return ContextRef
     */
    public function getContext (){
        $values=$this->xpath('/srel:context');
        if ($values->length!=1) throw new Exception ("Resource does not contain context");
        return new ContextRef($values->item(0),false);
    }
    /**
     *
     * @return string
     */
    public function getLockStatus (){
        $values=$this->xpath('/prop:lock-status');
        if ($values->length!=1) throw new Exception ("Resource does not contain lock-status");
        return $values->item(0)->nodeValue;
    }
    /**
     *
     * @return UserAccountRef
     */
    public function getLockOwner (){
        $values=$this->xpath('/srel:lock-owner');
        if ($values->length!=1) throw new Exception ("Resource does not contain lock-owner");
        return new UserAccountRef($values->item(0),false);
    }
    /**
     *
     * @return string
     */
    public function getPid (){
        $values=$this->xpath('/prop:pid');
        if ($values->length!=1) throw new Exception ("Resource does not contain pid");
        return $values->item(0)->nodeValue;
    }
    /**
     *
     * @param string $pid
     */
    public function setPid ($pid){
        $values=$this->xpath('/prop:pid');
        if ($values->length!=1) throw new Exception ("Resource does not contain pid");
        $values->item(0)->nodeValue=$pid;
    }
    /**
     * @param urlstring $context
     * @param ContextRef $context
     */
    public function setContext ($context){
        if (preg_match("|^/|",$context))
            $this->getContext()->setXLinkHref($context);
        else 
            $this->getContext()->setXLinkHref($context->getXLinkHref());
    }
    /**
     * @param urlstring $contentModel
     * @param ContentModelRef $contentModel
     */
    public function setContentModel ($contentModel){
        if (preg_match("|^/|",$contentModel))
            $this->getContentModel()->setXLinkHref($contentModel);
        else 
            $this->getContentModel()->setXLinkHref($contentModel->getXLinkHref());
    }
    //deprecated
    //    public function getContentModelSpecific (){  //    ContentModelSpecific }
    //    public function setContentModelSpecific ($contentModelSpecific){}
}

?>
