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


require_once 'resources/XMLNode.php';

class Response extends XMLNode{
     public function __construct($resource, $copy=true) {
        parent::__construct($resource, $copy);
    }   
    public function getVersion (){
        return $this->xpath('/zs:version')->item(0)->nodeValue;
    }
}

class SearchRetrieveResponse extends Response{

    public function __construct($resource, $copy=true) {
        parent::__construct($resource, $copy);
    }
    /**
     * get the total number of records found (without paging)
     * @return int
     */
    public function getNumberOfMatchingRecords (){
        return $this->xpath("/zs:numberOfRecords")->item(0)->nodeValue;
    }
    /**
     * get the number of records in this page (is <=maximumRecords of the query)
     * @return int
     */
    public function getNumberOfResultingRecords (){
        return $this->xpath("/zs:records/zs:record")->length;
    }
    /**
     *
     * @return SearchResult[] 
     */
    public function getRecords (){
      $ret=array();
           
      foreach ($this->xpath("/zs:records/zs:record") as $node)
          $ret[]=new SearchResult($node,false);
      return $ret;
    }

//  final int 	getNumberOfRecords () ?????????????  
//  final String 	getResultSetId ()
//  final PositiveInteger 	getResultSetIdleTime ()
//  final PositiveInteger 	getNextRecordPosition ()
//  final Object 	getEchoedSearchRetrieveRequest ()
//  final Object 	getDiagnostics ()
//  final Object 	getExtraResponseData ()
}
class SearchResult extends XMLNode{
    public function __construct($resource, $copy = true) {
        parent::__construct($resource, $copy);
    }
//    String 	getBase ()
//Highlight 	getHighlight (){
//  search-result-record/highlight
    
    /**
     *
     * @return Resource 
     */
    public function getContent (){
        $content=new XMLNode($this->xpath("/zs:recordData/*")->item(0),false);       
        return EscidocClassFactory::getClass($content);
    }
//Float 	getScore () {
// search-result-record/score
//}
}

?>
