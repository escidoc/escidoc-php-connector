<?php
/*
 *  Copyright [2010] [GFZ German Research Centre for Geosciences]
 *  Licensed under the Apache License, Version 2.0 (the "License");
 *  you may not use this file except in compliance with the License.
 *  You may obtain a copy of the License at
 *
 *  http://www.apache.org/licenses/LICENSE-2.0
 *
 *  Unless required by applicable law or agreed to in writing, software
 *  distributed under the License is distributed on an "AS IS" BASIS,
 *  WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  See the License for the specific language governing permissions and
 *  limitations under the License.
 */
//    require_once "Net/LDAP2.php";
    namespace escidoc;
    require_once "HTTP/Request.php";
    require_once "EscidocException.php";

    use \HTTP_Request as HTTP_Request;
    use \PEAR as PEAR;
    use \DOMDocument as DOMDocument;
    use \DOMXPath as DOMXpath;
    use \Exception as Exception;
    
class Authentication{
    /**
     *
     * @var string
     */
    protected $service;
     /**
     *
     * @var string
     */
    private $escidochandle;
    /**
     *
     * @param string $user loginname or escidoc-handle of the user or leave blank to get information about your current session
     * @return array array with some Information about the user "CREATION"=>"prop:creation-date","EMAIL"=>"prop:email","NAME"=>"prop:name","LOGIN"=>"prop:login-name","STATUS"=>"prop:active"
     */
    function getUserData($user=null){
        if (isset($user)){
            $username=$user;
        }else{
            $username=$this->getUserHandle();
        }
        $httpconn=new HTTP_Request($this->getServiceAddress().'/aa/user-account/'.$username);
        $httpconn->addCookie('escidocCookie', $this->getUserHandle());
        $httpconn->sendRequest();

        if (strlen($httpconn->getResponseBody())==0)
                throw new Exception("eSciDoc-coreservice (".$this->service.") did not answer. Is it offline?");

        $domdoc=new DOMDocument();
        $domdoc->loadXML($httpconn->getResponseBody());

        $is_exception=$domdoc->getElementsByTagName("exception");
        $is_validdata=$domdoc->getElementsByTagNameNS($domdoc->lookupNamespaceURI("user-account"),"user-account");

        if ($is_exception->length > 0){
            //exception from coreservice;
            eSciDocExceptionMapper::eSciDocExceptionMapper($domdoc->saveXML());
        }elseif ($is_validdata->length != 1){
            //core service should return exactly one representation of an user account
            if ($is_validdata->length == 0){
                throw new Exception("eSciDoc-coreservice (".$this->service.") did not return any valid XML-data for the user-account during login process.");
            }else{
                throw new Exception("eSciDoc-coreservice (".$this->service.") did return more than one XML-representation of an user-account during login process.");
            }
        }else{
            $userdata=array("CREATION"=>"prop:creation-date","EMAIL"=>"prop:email","NAME"=>"prop:name","LOGIN"=>"prop:login-name","STATUS"=>"prop:active");
            //will fill the array in $userdata with returned values - e.g. ("CREATION"=>"2010-09-22 10:00 ...","EMAIL"=>"ulbricht@gfz-potsdam.de",...)
            foreach ($userdata as $key => $value){
                list($prefix,$name)=preg_split("/:/",$value);
                $nsuri=$domdoc->lookupNamespaceURI($prefix);
                $nodelist=$domdoc->getElementsByTagNameNS($nsuri,$name);
                $userdata[$key]=$nodelist->item(0)->nodeValue;
            }
            $userdata["USERID"]=preg_filter("|/aa/user-account/|","",$is_validdata->item(0)->getAttributeNS($domdoc->lookupNamespaceURI("xlink"), "href"));
        }
        return $userdata;
    }

    /**
     *
     * @return string the service address eg. "http://localhost:8080"
     */
    function getServiceAddress(){
        return $this->service;
    }

    /**
     *
     * @param string $targetpage the page where escidoc will redirect
     * @return string the link that should be used for logout
     */
    function getLogoutLink($targetpage){
        return ($this->getServiceAddress().'/aa/logout?target='.$targetpage);
    }

    /**
     *
     * @param string $targetpage the page where escidoc will redirect
     * @return string the link that should be used for login
     */
    function getLoginLink($targetpage){
        return ($this->getServiceAddress().'/aa/login?target='.$targetpage);
    }

    /**
     *
     * @param string $escidochandle 
     */
    function setUserHandle($escidochandle){
        $this->escidochandle=$escidochandle;
    }


    /**
     *
     * @return bool success
     */
    function logout(){
        $httpconn=new HTTP_Request($this->getServiceAddress()."/aa/logout?target=http://localhost");
        $httpconn->sendRequest(); 
	return true;        
    }

    /**
     *
     * @param string $username
     * @param string $password
     * @return bool success 
     */
   function login($username,$password){

        $oursite="http://localhost";//value is not important

	$cookies=array();

        //ask for auth redirect 
        $httpconn=new HTTP_Request($this->getServiceAddress()."/aa/login?target=".urlencode($oursite));
        $req_err=$httpconn->sendRequest();
        if (PEAR::isError($req_err))
            throw new Exception($this->getServiceAddress()." : ".$req_err->getMessage(),$req_err->getCode());
	if (is_array($httpconn->getResponseCookies()))
            foreach ($httpconn->getResponseCookies() as $cookie) 
                $cookies[$cookie["name"]]=$cookie["value"];

	//get the login page
        $httpconn->setURL($httpconn->getResponseHeader("location"));
	foreach ($cookies as $name=>$value) 
            $httpconn->addCookie($name,$value);
        $req_err=$httpconn->sendRequest();
        if (PEAR::isError($req_err))
            throw new Exception($this->getServiceAddress()." : ".$req_err->getMessage(),$req_err->getCode());
        if (is_array($httpconn->getResponseCookies()))
            foreach ($httpconn->getResponseCookies() as $cookie) 
                $cookies[$cookie["name"]]=$cookie["value"];
        
	//parse & verify form
	$formelements=array("text","password","submit");
	$dom=DOMDocument::loadHTML($httpconn->getResponseBody());
	if ($dom==false)
		return false;
	$xpath=new DOMXpath($dom);
	$form=$xpath->query('//form');
	if ($form->length !=1 || !$form->item(0)->hasAttributes())
		return false;
	$formarray["url"]=$form->item(0)->getAttribute("action");
	foreach ($formelements as $formelement){
		$nodes=$xpath->query('//input[@type="'.$formelement.'"]',$form->item(0));
		if ($nodes->length != 1  || !$nodes->item(0)->hasAttributes())
			return false;
		$formarray[$formelement]=$nodes->item(0)->getAttribute("name");
	}
	foreach ($formarray as $formelement)
		if (strlen($formelement)==0)
			return false;

	//fill formular
        $httpconn->setURL($this->getServiceAddress().$formarray["url"]);
        $httpconn->setMethod(HTTP_REQUEST_METHOD_POST);
        $httpconn->setBody($formarray["text"]."=".$username."&".$formarray["password"]."=".$password);
	foreach ($cookies as $name=>$value) 
            $httpconn->addCookie($name,$value);
        $req_err=$httpconn->sendRequest();
        if (PEAR::isError($req_err))
            throw new Exception($this->getServiceAddress()." : ".$req_err->getMessage(),$req_err->getCode());
	if (is_array($httpconn->getResponseCookies()))
            foreach ($httpconn->getResponseCookies() as $cookie) 
                $cookies[$cookie["name"]]=$cookie["value"];

        //we will be redirected to the requested target ($oursite) and get the cookie
        $httpconn->setURL($httpconn->getResponseHeader("location"));
        $httpconn->setMethod(HTTP_REQUEST_METHOD_GET);
	foreach ($cookies as $name=>$value) 
            $httpconn->addCookie($name,$value);
        $req_err=$httpconn->sendRequest();
        if (PEAR::isError($req_err))
            throw new Exception($this->getServiceAddress()." : ".$req_err->getMessage(),$req_err->getCode());

        $cookies=$httpconn->getResponseCookies();
	foreach ($cookies as $cookie)
		if ($cookie["name"]=="escidocCookie"){
			$this->setUserHandle ($cookie["value"]);
                        return true;
                }

	return false;
    }

    /**
     *
     * @return string
     */
    function getUserHandle(){
        if (!isset($this->escidochandle))
            throw new Exception("User is not authenticated.");
        return $this->escidochandle;
    }

    /**
     *
     * @param string $service url of the core service must be provided and should be in the form http://localhost:8080
     */
    function __construct($service){
        $this->service=$service;
    }


}
?>
