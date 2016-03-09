<?php

class Parser {
	/** Create XML item from plain text and the resource specification */
	function parsePlain_ITSL($text, $resource) {
		$domDocument = new DOMDocument("1.0", "UTF-8");
		$xml_item = $domDocument->createElement("assessmentItem");
		$xml_item->setAttribute("xmlns", "http://www.imsglobal.org/xsd/imsqti_v2p1");
		$xml_item->setAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
		$xml_item->setAttribute("xmlns:qti", "http://www.imsglobal.org/xsd/imsqti_v2p1");
		$xml_item->setAttribute("xsi:schemaLocation", "http://www.imsglobal.org/xsd/imscp_v1p1 http://www.imsglobal.org/xsd/imscp_v1p1.xsd http://www.imsglobal.org/xsd/imsmd_v1p2 http://www.imsglobal.org/xsd/imsmd_v1p2p2.xsd http://www.imsglobal.org/xsd/imsqti_v2p1 http://www.imsglobal.org/xsd/imsqti_v2p1.xsd");
		$xml_item->setAttribute("identifier", $resource->identifier);
		$xml_item->setAttribute("title", $resource->title);
		$xml_item->setAttribute("adaptive", $resource->adaptive);
		$xml_item->setAttribute("timeDependent", $resource->timeDependent);
		$xml_item->setAttribute("toolName", $resource->LMS);
		$xml_item->setAttribute("toolVersion", $resource->toolVersion);
		
		$responseDeclaration = $domDocument->createElement("responseDeclaration");
		$responseDeclaration->setAttribute("cardinality", $resource->cardinality);
		$responseDeclaration->setAttribute("baseType", $resource->baseType);
		$responseDeclaration->setAttribute("identifier", $resource->responseIdentifier);
		
		$correctResponse = $domDocument->createElement("correctResponse", $resource->correctResponse);
		for($i = 0; $i < count($resource->correctValues); $i++) {
			$correctResponse->appendChild("value", $resource->correctValue[$i]);
		}
		$responseDeclaration->appendChild($correctResponse);		
		
	}
	
	function parseXML_ITSL($xmlfile) {
	}
}

?>