<?php

require('email_conf.php');
require('saml_util.php');
require('../config.php');

global $USER;

/* Main brancing Switch Statement */

require_login();

//if(preg_match("/\@email.wosc.edu/",$USER->email))
if(true)
{
	echo "Display Main";
	displayMain();
}
else
{
	displayError();
}

/**
* Displays an error for anyone who does not have a wosc.edu email address
* @return null
*/
function displayError()
{
	echo '<html><body><center><h2>We\'re sorry but this page is only available to WOSC students</h2>';
	echo '<a href="http://moodle.wosc.edu">Return to the portal</a>';
	echo '</body></html>';
}


/**
* Displays the main page before any action is taken.
* @return null
*/
function displayMain()
{
	global $USER, $GCFG;
echo "Blah";
$debug = $GCFG->debug;

if(isset($_GET['SAMLRequest']))
{

	if($debug)
	{ 
		echo "Received SAML Request"; 
	}

	$notBefore = samlGetDateTime(strtotime('-5 minutes'));
	$notOnOrAfter = samlGetDateTime(strtotime('+10 minutes'));
	$keyType = "dsa";

	$samlMessage = samlDecodeMessage($_GET['SAMLRequest']);
	$relayUrl = preg_replace('/&lt/','%60',$_GET['RelayState']);
	$attrib = getRequestAttributes($samlMessage);
	echo '<html><head><title>Redirecting</title></head><body';
	echo ' onLoad="acsForm.submit();"';
        echo '>';	
  if($debug){
	echo '<p><b>$attrib[\'issueInstant\']:</b> ' . $attrib['issueInstant'];
	echo '<p><b>$attrib[\'acsURL\']:</b> ' . $attrib['acsURL'];
	echo '<p><b>$attrib[\'providerName\']:</b> ' . $attrib['providerName'];
	echo '<p><b>$attrib[\'requestID\']:</b> ' . $attrib['requestID'];
	echo '<p><b>$USER->username: </b>' . $USER->username;
	echo '<p><b>$notBefore: </b>' . $notBefore;
	echo '<p><b>$keyType: </b>' . $keyType;
	echo '<p><b>$notOnOrAfter: </b>' . $notOnOrAfter;
	echo '<html><body>';
	echo '<p><b>$relayUrl: </b>' . $relayUrl;
	}
	$samlResponse = createSamlResponse($USER->username, $notBefore, $notOnOrAfter, $keyType, $attrib['requestID'], $attrib['acsURL']);
	if($debug) echo '<p><b>SAML Response: </b>' . $samlResponse;

	$signedResponse = signSamlResponse($samlResponse);
	echo "\n" . '<form name="acsForm" action="' . $attrib['acsURL'] . 
	     '" method="post">' . "\n";
	echo '<div style="display: none">' . "\n";
	echo '<textarea name="SAMLResponse">' . $signedResponse . 
	     '</textarea>' . "\n";
	echo '<textarea rows=10 cols=80 name="RelayState">' . $relayUrl . 
	     '</textarea>' . "\n";
	echo '</div>' . "\n";
	echo 'You should be redirected to Google apps. If you are seeing this page, click to <input type="submit" value="Proceed">' . "\n";
	echo '</form>' . "\n";
	if($debug) echo '<p><b>Signed Response: </b>' . $signedResponse;
	echo '</body></html>';

}
else
{
	echo '<html><body><p>This page is not accessable directly.</p></body></html>';
}
}

/**
 * Signs a SAML response with the given private key, and embeds the public key.
 * @param string $responseXmlString
 * @param string $pubKey
 * @param string $privKey
 * @return string
 */
function signSamlResponse($responseString)
{
	global $GCFG;
	$debug = $GCFG->debug;
	$pubKey = $GCFG->publicKey;
	$privKey = $GCFG->privateKey;

 	$tempFileName = $GCFG->tmpFileDir . 'saml-response-' . 
			samlCreateId() . '.xml';
	while(file_exists($tempFileName))
	{
		 $tempFileName = $GCFG->tmpFileDir . 'saml-response-' . 
				 samlCreateId() . '.xml';
	}
	
	if(!$handle = fopen($tempFileName, 'w'))
	{
		echo '<p><b>ERROR: Cannot open ' . 
		     $tempFileName . ' for writing.</b>';
		exit;
	}
	
	if(fwrite($handle, $responseString) === FALSE)
	{
		echo '<p><b>ERROR: Cannot write to ' . 
		     $tempFileName . '.'; 
		exit;
	}
	fclose($handle);

	// Lets sign the temporary file

	// Linux only command
	$cmd = $GCFG->xmlsecPath . ' --sign --privkey-pem ' . $privKey .
	       ' --pubkey-der ' . $pubKey . ' --output ' . $tempFileName .
	       '.out ' . $tempFileName;

	if($debug) echo '<p><b>Xmlsec Command: </b>' . $cmd . "<p>\n";	
	exec($cmd, $resp);
	if($debug) var_dump($resp);
	unlink($tempFileName);

	$xmlResult = @file_get_contents($tempFileName . '.out');
	if(!$xmlResult)
	{
		echo '<p><b>ERROR: unable to get signed xml response: ' . 
		     $tempFileName . '.out</b>';
		return false;
	}
	else
	{
		unlink($tempFileName . '.out');
		return $xmlResult;
	}


}


/**
 * Returns a SAML response with various elements filled in.
 * @param string $authenticatedUser The Google Apps username of the
                 authenticated user
 * @param string $notBefore The ISO 8601 formatted date before which the
                 response is invalid
 * @param string $notOnOrAfter The ISO 8601 formatted data after which the
                 response is invalid
 * @param string $rsadsa 'rsa' if the response will be signed with RSA keys,
                 'dsa' for DSA keys
 * @param string $requestID The ID of the request we're responding to
 * @param string $destination The ACS URL that the response is submitted to
 * @return string XML SAML response.
 */
function createSamlResponse($authenticatedUser, $notBefore, $notOnOrAfter,
                            $rsadsa, $requestID, $destination) {
  global $GCFG, $USER;
$debug = $GCFG->debug;
  $domainName = $GCFG->domain;
if(preg_match("/\@wosc.edu/",$USER->email))
{
        $domainName = $GCFG->domain;
}

if(preg_match("/\@post.wosc.edu/",$USER->email))
{
	$domainName = 'post.wosc.edu';
  //      die;
}
  if($debug) {echo '<p><b>Issuer Domain: </b>' . $domainName;}

  $samlResponse = file_get_contents('templates/SamlResponseTemplate.xml');
  $samlResponse = str_replace('<USERNAME_STRING>', $authenticatedUser,
                                  $samlResponse);
  $samlResponse = str_replace('<RESPONSE_ID>', samlCreateId(), $samlResponse);
  $samlResponse = str_replace('<ISSUE_INSTANT>', samlGetDateTime(time()),
                                  $samlResponse);
  $samlResponse = str_replace('<AUTHN_INSTANT>', samlGetDateTime(time()),
                                  $samlResponse);
  $samlResponse = str_replace('<NOT_BEFORE>', $notBefore, $samlResponse);
  $samlResponse = str_replace('<NOT_ON_OR_AFTER>', $notOnOrAfter,
                                  $samlResponse);
  $samlResponse = str_replace('<ASSERTION_ID>', samlCreateId(), $samlResponse);
  $samlResponse = str_replace('<RSADSA>', strtolower($rsadsa), $samlResponse);
  $samlResponse = str_replace('<REQUEST_ID>', $requestID, $samlResponse);
  $samlResponse = str_replace('<DESTINATION>', $destination, $samlResponse);
  $samlResponse = str_replace('<ISSUER_DOMAIN>', $domainName, $samlResponse);

  return $samlResponse;
}

?>
