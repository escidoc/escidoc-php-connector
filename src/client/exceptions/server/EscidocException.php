<?php
namespace escidoc\client\exceptions\server;

class EscidocException extends \RuntimeException {

	protected  $fullxmlmessage;

	public function  __construct($fullxmlmessage, $code=null, $previous=null) {
		$this->fullxmlmessage=$fullxmlmessage;

		$dom= DOMDocument::loadXML($fullxmlmessage);
		$xpath=new DOMXPath($dom);

		if ($xpath->query('//exception/title')->length <1
		|| $xpath->query('//exception/message')->length <1
		//            || $xpath->query('//exception/stack-trace')->length <1
		)
		throw new Exception("Could not map Exception from Escidoc-messages");

		$title=$xpath->query('//exception/title')->item(0)->nodeValue;
		$message=$xpath->query('//exception/message')->item(0)->nodeValue;
		//        $stacktrace=$xpath->query('//exception/stack-trace')->item(0)->nodeValue;

		$errmsg=substr($title,4);
		$errcode=intval(substr($title,0,3));

		parent::__construct($errmsg."<br>".$message, $errcode, $previous);
	}

	public function getFullEscidocMessage(){
		return $this->fullxmlmessage;
	}

}
?>