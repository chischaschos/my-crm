<?php

$xp = new XsltProcessor();

$xsl = new DomDocument();
$xsl->load('table.xsl');

$xp->importStylesheet($xsl);


$xml_doc = new DomDocument;
$xml_doc->load('uploadResult.xml');

if ($html = $xp->transformToXML($xml_doc)) {
    echo $html;
} else {
    trigger_error('XSL transformation failed.', E_USER_ERROR);
} 

