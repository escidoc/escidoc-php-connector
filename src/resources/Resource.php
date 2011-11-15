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

require_once 'resources/XLinkResource.php';

class Resource extends XLinkResource{
    public function __construct($resource, $copy=true) {
        parent::__construct($resource, $copy);
    }
    /**
     *
     * @return string
     */
    public function getObjid (){
        return array_pop(preg_split("|/|",$this->getXLinkHref()));
    }
    /**
     *
     * @return Reference
     */
    public function getReference (){
        $dom=new DOMDocument($this->dom->version, $this->dom->xmlEncoding);
        $srel_uri=$this->dom->lookupNamespaceUri("srel");
        $xlink_uri=$this->dom->lookupNamespaceUri("xlink");
        $node=$dom->createElementNS($srel_uri, "srel:".$this->getResourceType());
        $node->setAttributeNS($xlink_uri, "xlink:href", $this->getXLinkHref());
        $dom->appendchild($node);
        return new Reference($dom);
    }

    /**
     * @return string
     */
    protected function getResourceType(){
        throw new Exception ("Resource type not implemented for this function.");
    }
}


?>
