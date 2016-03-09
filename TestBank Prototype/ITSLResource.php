<?php

include "LMSResource.php";

/** Base class for the different resource-types the LMS ITSL supports */
class ITSLResource extends LMSResource {
	protected $xml;

	public function __construct() {
		$this->xml = new DOMDocument("1.0", "UTF-8");
		echo '<br/> Created ITSL Resource Object';
	}
}

class ITSLResourceEitherOr extends ITSLResource {
	public $identifier = "itemEitherOr"; //Eventually will be something else
	public $title = "EitherOr"; //Titular description of the type of question item
	public $adaptive = "false"; //No idea what this attribute does
	public $timeDependent = "false";
	public $toolName = "itslearning"; //toolName i.e. "itslearning", "fronter", ...
	public $toolVersion = "3.47";

	private $filename;

	/** Tags for the given item */
	private $assessmentItem;

	private $responseDeclaration;
	private $correctResponse;
	private $mapping;

	private $itemBody;
	private $questionParagraph;
	private $choiceInteraction;
	private $responseProcessing;

	public function __construct() {
		parent::__construct();
		echo '<br/><b>Type > ITSLResourceEitherOr</b>';
	}

	/** Requires responseDeclaration, itemBody & responseProcessing to be set! */
	public function setAssessmentItem() {
		$this->assessmentItem = $this->xml->createElement("assessmentItem");
		$this->assessmentItem->setAttribute("xmlns", "http://www.imsglobal.org/xsd/imsqti_v2p1");
		$this->assessmentItem->setAttribute("xmlns:xsi", "http://www.w3.org/2001/XMLSchema-instance");
		$this->assessmentItem->setAttribute("xmlns:qti", "http://www.imsglobal.org/xsd/imsqti_v2p1");
		$this->assessmentItem->setAttribute("xsi:schemaLocation", "http://www.imsglobal.org/xsd/imscp_v1p1 http://www.imsglobal.org/xsd/imscp_v1p1.xsd http://www.imsglobal.org/xsd/imsmd_v1p2 http://www.imsglobal.org/xsd/imsmd_v1p2p2.xsd http://www.imsglobal.org/xsd/imsqti_v2p1 http://www.imsglobal.org/xsd/imsqti_v2p1.xsd");
		$this->assessmentItem->setAttribute("identifier", $this->identifier);
		$this->assessmentItem->setAttribute("title", $this->title);
		$this->assessmentItem->setAttribute("adaptive", $this->adaptive);
		$this->assessmentItem->setAttribute("timeDependent", $this->timeDependent);
		$this->assessmentItem->setAttribute("toolName", $this->toolName);
		$this->assessmentItem->setAttribute("toolVersion", $this->toolVersion);

		$this->assessmentItem->appendChild($this->responseDeclaration);
		$this->assessmentItem->appendChild($this->itemBody);
		$this->assessmentItem->appendChild($this->responseProcessing);
		$this->xml->appendChild($this->assessmentItem);
	}

	/** set the response declaration */
	public function setResponseDeclaration(array $attributes) {
		$this->responseDeclaration = $this->xml->createElement("responseDeclaration");
		$this->responseDeclaration->setAttribute("cardinality", $attributes[0]);
		$this->responseDeclaration->setAttribute("baseType", $attributes[1]);
		$this->responseDeclaration->setAttribute("identifier", $attributes[2]);

		$this->responseDeclaration->appendChild($this->correctResponse);
		$this->responseDeclaration->appendChild($this->mapping);
	}

	/** set the correct response */
	public function setCorrectResponse($valueID) {
		$this->correctResponse = $this->xml->createElement("correctResponse");
		$value = $this->xml->createElement("value", $valueID);
		$this->correctResponse->appendChild($value);
	}

	/** set the mapping */
	public function setMapping(array $attributes) {
		$this->mapping = $this->xml->createElement("mapping");
		$this->mapping->setAttribute("lowerBound", $attributes[0]);
		$this->mapping->setAttribute("upperBound", $attributes[1]);
		$this->mapping->setAttribute("defaultValue", $attributes[2]);
	}

	/** set the map entries, requires mapping to have been set */
	public function setMapEntry(array $attributes) {
		$mapEntry = $this->xml->createElement("mapEntry");
		$mapEntry->setAttribute("mapKey", $attributes[0]);
		$mapEntry->setAttribute("mappedValue", $attributes[1]);
		$this->mapping->appendChild($mapEntry);
	}

	/** set outcome declaration, requires assessmentItem to have been set */
	public function setOutcomeDeclaration($attributes) {
		$outcomeDeclaration = $this->xml->createElement("outcomeDeclaration");
		$outcomeDeclaration->setAttribute("cardinality", $attributes[0]);
		$outcomeDeclaration->setAttribute("baseType", $attributes[1]);
		$outcomeDeclaration->setAttribute("identifier", $attributes[2]);
		$outcomeDeclaration->setAttribute("view", $attributes[3]);
		$outcomeDeclaration->setAttribute("normalMaximum", $attributes[4]);
		$outcomeDeclaration->setAttribute("normalMinimum", $attributes[5]);
		$outcomeDeclaration->setAttribute("masteryValue", $attributes[6]);
		$this->assessmentItem->appendChild($outcomeDeclaration);
	}
	
	/** set the question paragraph */
	public function setQuestionParagraph($questionParagraph) {
		$this->questionParagraph = $this->xml->createElement("p", $questionParagraph);
	}

	/** set the item body, requires questionParagraph and choiceInteraction to have been set */
	public function setItemBody() {
		$this->itemBody = $this->xml->createElement("itemBody");
		$this->itemBody->appendChild($this->questionParagraph);
		$this->itemBody->appendChild($this->choiceInteraction);
	}

	/** set the choice interaction */
	public function setChoiceInteraction(array $attributes) {
		$this->choiceInteraction = $this->xml->createElement("choiceInteraction");
		$this->choiceInteraction->setAttribute("responseIdentifier", $attributes[0]);
		$this->choiceInteraction->setAttribute("shuffle", $attributes[1]);
		$this->choiceInteraction->setAttribute("maxChoices", $attributes[2]);
		$this->choiceInteraction->setAttribute("minChoices", $attributes[3]);
	}

	/** set simple choice, requires choice interaction to have been set */
	public function setSimpleChoice(array $attributes, $paragraph) {
		$simpleChoice = $this->xml->createElement("simpleChoice");
		$simpleChoice->setAttribute("fixed", $attributes[0]);
		$simpleChoice->setAttribute("showHide", $attributes[1]);
		$simpleChoice->setAttribute("identifier", $attributes[2]);
		
		$p = $this->xml->createElement("p", $paragraph);
		$simpleChoice->appendChild($p);
		
		$this->choiceInteraction->appendChild($simpleChoice);
	}
	
	public function setResponseProcessing() {
		$this->responseProcessing = $this->xml->createElement("responseProcessing");
	}
	
	public function saveResource($filename) {
		echo '<br/>Saved to ' . $filename . '.xml';
		$this->xml->save($filename . '.xml');
	}

	public function __toString() {
		return 'ITSL Resource Item > ' . $identifier . ', ' . $title;
	}
	
	public function buildResource($question, $responseID1, $responseID2, $responseText1, $responseText2, $correctResponseID, $shuffle, $maxChoices, $minChoices) {
		$this->setCorrectResponse($correctResponseID);
		$this->setMapping(array("-1", "1", "0"));
		$this->setMapEntry(array($responseID1, "1"));
		$this->setMapEntry(array($responseID2, "-1"));
		$this->setResponseDeclaration(array("single", "identifier", "RESPONSE"));
		
		$questionParagraph = mb_convert_encoding($question, "UTF-8");
		$this->setQuestionparagraph($questionParagraph);
		$this->setChoiceInteraction(array("RESPONSE", $shuffle, $maxChoices, $minChoices));
		$this->setSimpleChoice(array("false", "show", $responseID1), $responseText1);
		$this->setSimpleChoice(array("false", "show", $responseID2), $responseText2);
		$this->setItemBody();
		
		$this->setResponseProcessing();
		
		$this->setAssessmentItem();
		
		$this->setOutcomeDeclaration(array("single", "identifier", "FEEDBACK", "", "0", "0", "0"));
		$this->setOutcomeDeclaration(array("single", "identifier", "INTEGRATEDFEEDBACK", "", "0", "0", "0"));
	}
}

$ITSLEitherOr = new ITSLResourceEitherOr();
/*
//Build the responseDeclaration first
$ITSLEitherOr->setCorrectResponse("A0");
$ITSLEitherOr->setMapping(array("-1", "1", "0"));
$ITSLEitherOr->setMapEntry(array("A0", "1"));
$ITSLEitherOr->setMapEntry(array("A1", "-1"));
$ITSLEitherOr->setResponseDeclaration(array("single", "identifier", "RESPONSE"));

//Build the itemBody
$questionParagraph = mb_convert_encoding("Er dette et enten eller spørsmål?", "UTF-8");
$ITSLEitherOr->setQuestionParagraph($questionParagraph);
$ITSLEitherOr->setChoiceInteraction(array("RESPONSE", "false", "1", "0"));
$ITSLEitherOr->setSimpleChoice(array("false", "show", "A0"), "Ja");
$ITSLEitherOr->setSimpleChoice(array("false", "show", "A1"), "Nei");
$ITSLEitherOr->setItemBody();

//Build the responseProcessing
$ITSLEitherOr->setResponseProcessing();

//Build the assessmentItem
$ITSLEitherOr->setAssessmentItem();

//Build the outcomeDeclaration(s)
$ITSLEitherOr->setOutcomeDeclaration(array("single", "identifier", "FEEDBACK", "", "0", "0", "0"));
$ITSLEitherOr->setOutcomeDeclaration(array("single", "identifier", "INTEGRATEDFEEDBACK", "", "0", "0", "0"));
*/

/** Builds ITSLResourceEitherOr with arguments: question, responseID1, responseID2, responseText1, responseText2, shuffle, maxChoices, minChoices 
 *  Saves resource to $filename . 'xml'.
 * */
$ITSLEitherOr->buildResource("Er dette et enten eller spørsmål?", "A0", "A1", "Ja", "Nei", "A0", "false", "1", "0");
$ITSLEitherOr->saveResource("itemEitherOr");

?>