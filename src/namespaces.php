<?php
namespace escidoc;

require_once "resources/SearchRetrieveResponse.php";

use \ReflectionClass as ReflectionClass;
use \ReflectionException as ReflectionException;
use \Exception as Exception;

class EscidocNamespaces {

    
    protected static function getObjectMapping(){

            return array(
                
                //     "namespaceuri" => array("namespaces" => array("namespace1","namespace2"),
                //                             "objects"  => array("tagname1" => "class1",
                //                                                 "tagname2" => "class2"))
                //
        //oum
                "http://www.escidoc.de/schemas/organizationalunit/0.8"=>array("namespaces"=> array("organizational-unit"),
                                                                              "objects" => array("organizational-unit" =>"OrganizationalUnit")
                                                                             ),
        //stage-file
                "http://www.escidoc.de/schemas/stagingfile/0.3"       =>array("namespaces"=> array("staging-file"),
                                                                              "objects" => array("staging-file" => "StageFile")
                                                                             ),
        //search
                "http://www.loc.gov/zing/srw/"                        =>array("namespaces"=> array("zs","sru"),
                                                                              "objects" => array("searchRetrieveResponse"=>"SearchRetrieveResponse",
                                                                                                 "record"=> "SearchResult",
                                                                                                 "explainResponse"=> "ExplainResponse")
                                                                             ),
                "http://explain.z3950.org/dtd/2.1/"                   =>array("namespaces"=> array("zr"),
                                                                              "objects" => array("explain"=> "Explain")
                                                                             ),
                    
                "http://www.escidoc.de/schemas/item/0.9"              =>array("namespaces"=> array("escidocItem"),
                                                                              "objects" => array("item"=>"Item")
                                                                             ),
        //ir
                "http://www.escidoc.de/schemas/components/0.9"        =>array("namespaces"=> array("escidocComponents" ),
                                                                              "objects" => array("components"=>"Components",
                                                                                                 "component" =>"Component")
                                                                             ),
                "http://www.escidoc.de/schemas/container/0.8"         =>array("namespaces"=> array("container"),
                                                                              "objects" => array("container"=>"Container")
                                                                             ),
                "http://www.escidoc.de/schemas/structmap/0.4"         =>array("namespaces"=> array("struct-map"),
                                                                              "objects" => array("struct-map"=>"StructMap")
                                                                             ),


                "http://www.escidoc.de/schemas/relations/0.3"         =>array("namespaces"=> array("relations")),
                "http://www.escidoc.de/schemas/context/0.7"           =>array("namespaces"=> array("context"),
                                                                              "objects" => array("context"=>"Context")
                                                                             ),
                "http://www.escidoc.de/schemas/contentstreams/0.7"    =>array("namespaces"=> array("contentStreams")),

                "http://www.escidoc.de/schemas/content-relation/0.1"  =>array("namespaces"=> array("escidocContentRelation")),               
            
        //aa
                "http://www.escidoc.de/schemas/attributes/0.1"        =>array("namespaces"=> array("attributes"),
                                                                             "objects" => array("attribute"=>"Attribute")
                                                                              ),

                "http://www.escidoc.de/schemas/preferences/0.1"       =>array("namespaces"=> array("preferences")),
                
                "http://www.escidoc.de/schemas/useraccount/0.7"       =>array("namespaces"=> array("user-account"),
                                                                             "objects" => array("user-account"=>"UserAccount")
                                                                              ),
                "http://www.escidoc.de/schemas/usergroup/0.6"         =>array("namespaces"=> array("user-group"),
                                                                             "objects" => array("user-group"=>"UserGroup")
                                                                              ),
                "http://www.escidoc.de/schemas/grants/0.5"            =>array("namespaces"=> array("grants"),
                                                                             "objects" => array("grant"=>"Grant")
                                                                              ),
                "http://www.escidoc.de/schemas/role/0.4"              =>array("namespaces"=> array("role"),
                                                                             "objects" => array("role"=>"Role")
                                                                              ),
                "http://www.escidoc.de/schemas/metadatarecords/0.5"   =>array("namespaces"=> array("escidocMetadataRecords"),
                                                                              "objects" => array("escidocMetadataRecords"=>"MetadataRecords",
                                                                                                  "escidocMetadataRecord"=>"MetadataRecord"
                                                                                                 )
                                                                              ),
                
                "http://www.w3.org/1999/xlink"                        =>array("namespaces"=> array("xlink")),
                "http://escidoc.de/core/01/properties/"               =>array("namespaces"=> array("prop")),
                "http://escidoc.de/core/01/structural-relations/"     =>array("namespaces"=> array("srel")),
                "http://www.w3.org/XML/1998/namespace"                =>array("namespaces"=> array("xml")),
                "http://escidoc.de/core/01/properties/version/"       =>array("namespaces"=> array("version")),
                "http://escidoc.de/core/01/properties/release/"       =>array("namespaces"=> array("release")),
                "urn:oasis:names:tc:xacml:1.0:context"                =>array("namespaces"=> array("xacml-context")),
                "http://www.escidoc.de/schemas/pdp/0.3/requests"      =>array("namespaces"=> array("requests")),
                "http://www.escidoc.de/schemas/pdp/0.3/results"       =>array("namespaces"=> array("results")),
                "http://www.escidoc.de/schemas/contentmodel/0.1"      =>array("namespaces"=> array("escidocContentModel")),
                "http://www.escidoc.de/schemas/versionhistory/0.3"    =>array("namespaces"=> array("escidocVersions")),
                "http://www.loc.gov/standards/premis/v1"              =>array("namespaces"=> array("premis"))
                 );      
        }
        
    public static function getUris(){
        $ret=array();
        foreach (EscidocNamespaces::getObjectMapping() as $uri=>$mapping)
            if (array_key_exists("namespaces",$mapping)!==FALSE)
                foreach ($mapping["namespaces"] as $namespace)
                    $ret[$namespace]=$uri;   
        return $ret;
        
    }
        
}

class EscidocClassFactory extends EscidocNamespaces{
    
    /*constructs an object by using XML namspace-uri and tagname
     * 
     *@param string $objectcontent
     *@param XMLNode $objectcontent
     *@return Resource
     */
    public static function getClass($objectcontent){

        $content=new XMLNode($objectcontent,false);
        $tagname=$content->getRootNode()->localName;
        $uri=$content->getRootNode()->namespaceURI ;

        $classname=false;
        $objectmapping=EscidocNamespaces::getObjectMapping();
        if (array_key_exists($uri, $objectmapping)!==FALSE)
            if (array_key_exists("objects", $objectmapping[$uri])!==FALSE)
                if (array_key_exists($tagname, $objectmapping[$uri]["objects"])!==FALSE)
                        $classname=$objectmapping[$uri]["objects"][$tagname];
        try{
            $object=new ReflectionClass('escidoc\\'.$classname);
            if ($object->isInstantiable()){              
                  $resource=$object->newInstance($content,false);
                  if ($resource==null)
                      throw Exception("Classmapper: Failed to create new instance of escidoc\\".$classname);
                  if($object->isInstance($resource))
                    return $resource;
            }
        }catch (ReflectionException $e){
            throw "Classmapper:".$e;
//            throw new Exception ("ClassMapper: No Resource found for: <br><br> ".$uri.":".$tagname."<br><br><br>".$content->__toString());
        }
    }
}
?>