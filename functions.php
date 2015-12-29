<?php
##########################################################################################################
###                            Created by Rick Melara 							           			                   ###
##########################################################################################################

###Include our XMLRPC Library###
include("xmlrpc-2.0/lib/xmlrpc.inc");
###Set our Infusionsoft application as the client###
$client = new xmlrpc_client("https://cy210.infusionsoft.com/api/xmlrpc");
###Return Raw PHP Types###
$client->return_type = "phpvals";
###Dont bother with certificate verification###
$client->setSSLVerifyPeer(FALSE);
###Our API Key###
$key = "8849a6ffcd760cc6b34a218412dcf944";

### POST VARIABLES
$action = $_POST['action'];
$userId = $_POST['user'];
$tag = $_POST['tag'];

### START
$start = start($action);
$end = "Success";

var_dump($end);
### FUNCTIONS

function start($action){
	global $action, $userId, $tag;

	switch ($action) {
		case "addTag":
				return addTag($userId, $tag);
				break;
		case "removeTag":
				return removeTag($userId, $tag);
				break;
		case "getTagId":
				return getTagId($tag);
				break;
		}
}

function addTag($userId, $tagName){
	global $client, $key;

	$RickUserId = 394728;
	$tagPAYF = 576;
	$tagRickTest = 392;

	$tagId = getTagId($tagName);

	$call = new xmlrpcmsg("ContactService.addToGroup",array(
		php_xmlrpc_encode($key),
		php_xmlrpc_encode($userId),
		php_xmlrpc_encode($tagId)
	));

	$result=$client->send($call);

	return $action;
}

function removeTag($userId, $tagName){
	global $client, $key;

	$tagId = getTagId($tagName);

  $call = new xmlrpcmsg("ContactService.removeFromGroup",array(
  	php_xmlrpc_encode($key),
  	php_xmlrpc_encode($userId),
  	php_xmlrpc_encode($tagId)
  	));

  	$result=$client->send($call);
}

function getTagId($tag){
	global $client, $key;

  $call = new xmlrpcmsg("DataService.query",array(
    php_xmlrpc_encode($key),
    php_xmlrpc_encode("ContactGroup"),
    php_xmlrpc_encode(5000),
    php_xmlrpc_encode(0),
    php_xmlrpc_encode(array('Id' => '%')),
    php_xmlrpc_encode(array('Id','GroupName')),
    php_xmlrpc_encode('GroupName'),
    php_xmlrpc_encode(true)
  ));

  ###Send the call###
  $result=$client->send($call);

  $tagArray = $result->val;

	for ($i = 0; $i < count($tagArray); ++$i) {
			if($tagArray[$i]["GroupName"] == $tag){
				$tagId = $tagArray[$i]["Id"];
			}
  }

	return $tagId;

}

?>
