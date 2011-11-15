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

require_once "resources/Resource.php";

interface LatestVersion{
    /**
     * @return string
     */
    public function getDate();
    /**
     * @return number
     */
    public function getNumber();
}
interface LatestRelease extends LatestVersion{
    public function getPid();
}
interface Version extends LatestRelease{
    /**
     * @return UserAccountRef
     */
    public function getModifiedBy();
    /**
     * @return string
     */
    public function getComment();
    /**
     * @return string
     */
    public function getStatus();
}

?>
