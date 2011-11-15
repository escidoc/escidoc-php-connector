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

require_once 'resources/Resource.php';

class Reference extends Resource{
    public function __construct($resource, $copy=true) {
        parent::__construct($resource, $copy);
    }
    /**
     *
     * @param string $href
     */
    public function setXLinkHref($href) {
        parent::setXLinkHref($href);
    }
    /**
     *
     * @param string $title
     */
    public function setXLinkTitle($title) {
        parent::setXLinkTitle($title);
    }
    /**
     *
     * @param string $type
     */
    public function setXLinkType($type) {
        parent::setXLinkType($type);
    }
}
class AggregationDefinitionRef extends Reference{}
class ReportDefinitionRef extends Reference{}
class RoleRef extends Reference{}
class ScopeRef extends Reference{}
class GrandRef extends Reference{}
class ItemRef extends Reference{}
class OrganizationalUnitRef extends Reference{}
class ContainerRef extends Reference{}
class UserAccountRef extends Reference{}
class GrantedTo extends Reference{}
class ContentModelRef extends Reference{}
class ContextRef extends Reference{}
class GrantRef extends Reference{}

?>
