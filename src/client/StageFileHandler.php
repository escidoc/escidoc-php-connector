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


/*
 * 
 * this file contains the REST-Interface to the eSciDoc object-manager
 * methods based on eSciDoc documentation files of the object-manager
 * (Rest_api_doc_OM_*.pdf)
 *
 */
namespace escidoc;

require_once "resources/st/StageFile.php";
require_once "transport/BaseClasses.php";

class StageFileHandler extends EscidocHTTPSender{
    /**
     * @param Authentication $authobject
     */
    public function __construct($authobject) {
        parent::__construct($authobject);
           $this->url="/st/staging-file";
    }
    /**
     * @param ?binary? $data the data to upload
     * @return StageFile
     */
    public function upload ($data){ //using a reference (i.e. &$data) does _not_ save memory!
        return new StageFile($this->send($this->url,"PUT",$data),false);
    }

}
?>
