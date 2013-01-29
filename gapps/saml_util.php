<?php

/**
 * Copyright (C) 2007 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

/**
 * Creates a 40-character string containing 160-bits of pseudorandomness.
 * @return string
 */
function samlCreateId() {
  $rndChars = 'abcdefghijklmnop';
  $rndId = '';
  
  for ($i = 0; $i < 40; $i++ ) {
    $rndId .= $rndChars[rand(0,strlen($rndChars)-1)];
  }
  
  return $rndId;
}

/**
 * Returns a unix timestamp in xsd:dateTime format.
 * @param timestamp int UNIX Timestamp to convert to xsd:dateTime 
          ISO 8601 format.
 * @return string
 */
function samlGetDateTime($timestamp) {
  return gmdate('Y-m-d\TH:i:s\Z', $timestamp);
}

/**
 * Attempts to check whether a SAML date is valid.  Returns true or false.
 * @param string $samlDate
 * @return bool
 */
function validSamlDateFormat($samlDate) {
  if ($samlDate == "") return false;
  $indexT = strpos($samlDate, 'T');
  $indexZ = strpos($samlDate, 'Z');
  
  if (($indexT != 10) || ($indexZ != 19)) {
    return false;
  }
  
  $dateString = substr($samlDate, 0, 10);
  $timeString = substr($samlDate, $indexT + 1, 8);
  
  list($year, $month, $day) = explode('-', $dateString);
  list($hour, $minute, $second) = explode(':', $timeString);
  $parsedDate = mktime($hour, $minute, $second, $month, $day, $year);
  if (($parsedDate === FALSE) || ($parsedDate == -1)) return false;

  if (!checkdate($month, $day, $year)) return false;
  
  return true;
  
}
/**
 * Generates an encoded and compressed string from the specified 
 * string. The string is encoded in the following order:
 *
 * 1. Deflate
 * 2. Base64 encode
 * 3. URL encode
 * @param string $msg
 * @return string
 */
function samlEncodeMessage($msg) {
  $encmsg = gzdeflate($msg);
  $encmsg = base64_encode($encmsg);
  $encmsg = urlencode($encmsg);
  return $encmsg;
}

/**
 * Decodes an encoded and compressed string in the following order:
 *
 * 1. Base64 decode
 * 2. Deflate
 *
 * Returns FALSE if the string could not be decoded.
 * @param string $msg
 * @return string
 */
function samlDecodeMessage($msg) {
  $decmsg = base64_decode($msg);
  $infmsg = gzinflate($decmsg);
  if ($infmsg === FALSE) {
    // gzinflate failed, try gzuncompress
    $infmsg = gzuncompress($decmsg);
  };
  return $infmsg;
}

/**
 * Returns an array contianing some of the attributes from the SAML request.
 * @param string $xmlString
 * @return array
 */
function getRequestAttributes($xmlString) {

  if (class_exists("SimpleXMLElement")) {
    // Try PHP5 SimpleXML parsing
    $xml = new SimpleXMLElement($xmlString);
    $attr['issueInstant'] = $xml['IssueInstant'];
    $attr['acsURL'] = $xml['AssertionConsumerServiceURL'];
    $attr['providerName'] = $xml['ProviderName'];
    $attr['requestID'] = $xml['ID'];
    
    return $attr;
  } else {
    // Try expat XML parsing extension
    $p = xml_parser_create();    
    $result = xml_parse_into_struct($p, $xmlString, $vals, $index);
    $attr['issueInstant'] = $vals[0]['attributes']['ISSUEINSTANT'];
    $attr['acsURL'] = $vals[0]['attributes']['ASSERTIONCONSUMERSERVICEURL'];
    $attr['providerName'] = $vals[0]['attributes']['PROVIDERNAME'];
    $attr['requestID'] = $vals[0]['attributes']['ID'];
    
    return $attr;
  }
}
?>
