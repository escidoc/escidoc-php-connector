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

require_once "resources/common/reference/Reference.php";
require_once 'resources/common/properties/CommonProperties.php';

class GrantProperties extends CommonProperties{
    public function __construct($resource, $copy=true) {
        parent::__construct($resource, $copy);
    }
    /**
     *
     * @return GrantedTo
     */
    public function getGrantedTo (){
        $values=$this->xpath("/srel:granted-to");
        if ($values->length<1) throw new Exception ("Resource does not contain GrantedTo");
        return new GrantedTo($values->item(0),false);
    }
    /**
     *
     * @return string
     */
    public function getRevocationDate (){
        $values=$this->xpath("/prop:revocation-date");
        if ($values->length<1) throw new Exception ("Resource does not contain revocation-date");
        return $values->item(0)->nodeVale;
    }
    /**
     *
     * @return UserAccountRef
     */
    public function getRevokedBy (){
        $values=$this->xpath("/srel:revoked-by");
        if ($values->length<1) throw new Exception ("Resource does not contain revoke");
        return new UserAccountRef($values->item(0),false);
    }
    /**
     *
     * @return string
     */
    public function getGrantRemark (){
        $values=$this->xpath("/grant-remark");
        if ($values->length<1) throw new Exception ("Resource does not contain grant-remark");
        return $values->item(0)->nodeVale;
    }
    /**
     *
     * @return string
     */
    public function getRevocationRemark (){
        $values=$this->xpath("/revocation-remark");
        if ($values->length<1) throw new Exception ("Resource does not contain revocation-remark");
        return $values->item(0)->nodeVale;
    }
    /**
     *
     * @return RoleRef
     */
    public function getRole (){
        $values=$this->xpath("/srel:role");
        if ($values->length<1) throw new Exception ("Resource does not contain Role");
        return new RoleRef($values->item(0),false);
    }
    /**
     * @param RoleRef $role
     */
    public function setRole ($role){
        $this->getRole()->setXLinkHref($role->getXLinkHref());
    }
    /**
     *
     * @return Reference
     */
    public function getAssignedOn (){
         $values=$this->xpath("/srel:assigned-on");
        if ($values->length<1) throw new Exception ("Resource does not contain assigned-on");
        return new Reference($values->item(0),false);
    }
    /**
     * @param Reference $assignedOn
     * @param Resource  $assignedOn
     * @param null      $assignedOn
     */
    public function setAssignedOn ($assignedOn=null){
        
        if ($assignedOn==null){
            $this->importResource(".", null , "./srel:assigned-on");
            return;
        }

        $values=$this->xpath("/srel:assigned-on");
        if ($values->length=0){
                $nodes=$this->xpath(".",$this->getRootNode());
                $node=$nodes->item(0);
                $uri=$this->dom->lookupNamespaceUri("srel");
                $newnode=$this->dom->createElementNS($uri,"srel:assigned-on");
                $node->appendChild($newnode);
        }
        $this->getAssignedOn()->setXLinkHref($assignedOn->getXLinkHref());
    }
}
?>
