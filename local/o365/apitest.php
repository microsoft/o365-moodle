<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * @package local_o365
 * @author James McQuillan <james.mcquillan@remote-learner.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @copyright (C) 2014 onwards Remote-Learner.net Inc (http://www.remote-learner.net)
 */

require(__DIR__.'/../../config.php');
?>
<html>
<body>
<style>
	html, body {
		padding: 0;
		margin: 0;
	}
	header {
		background-color: #222;
		color: #ccc;
		padding: 0.25rem 0.5rem;
		font-weight: bold;
	}
	#wrapper {
		position: relative;
		font-family: sans-serif;
	}
	#forms {
		padding: 1rem;
		position: relative;
	}
	h4 {
		margin: 0;
	}
	input[type="text"], textarea, select {
		padding: 0.5rem;
		margin: 0.25rem 0.1rem;
	}
	input[type="submit"] {
		padding: 0.5rem 1rem;
		margin: 0.25rem 0.1rem;
	}
	label {
		min-width: 5rem;
		display: inline-block;
		font-weight: bold;
		text-align: right;
		padding-right: 0.5rem;
	}
	div.switchers {
		background-color: #333;
		display: inline-block;
		width: 100%;
	}
	div.switchers > span {
		color: #fff;
		display: inline-block;
		padding: 0 1.5rem;
		line-height: 2.5rem;
		cursor: pointer;
		float: left;
	}
	div.switchers > span:hover {
		background-color: #D35400;
	}
	span.selected {
		background-color: #C0392B;
		font-weight: bold;
	}
	.scratchwrapper {
		position:absolute;top:1rem;right:1rem;width:40%;
	}
	.output {
		padding: 1rem;
	}
</style>
<script>
function switchform(switchto, switcher) {
	var e = document.getElementsByClassName('apiform');
	for(i=0;i<e.length;i++) {
		e[i].style.display='none';
	}
	document.getElementById('api_'+switchto).style.display='block';
	var e = document.getElementsByClassName('switcher');
	for(i=0;i<e.length;i++) {
		e[i].className='switcher';
	}
	switcher.className='switcher selected';
}
</script>

<?php
if (!empty($_POST)) {
	function apiresult_examine($result) {
		if (is_array($result)) {
			print_r($result);
		} else {
			$jsondecode = @json_decode($result, true);
			if (empty($jsondecode)) {
				var_dump($result);
			} else {
				print_r($jsondecode);
			}
		}
	}
	echo '<pre class="output">';
	if ($_POST['api'] === 'sharepoint') {
		$tokenparams = ['user_id' => $USER->id, 'resource' => \local_o365\rest\sharepoint::get_resource()];
		if (empty($tokenparams['resource'])) {
			throw new \Exception('Not configured');
		}
		$tokenrec = $DB->get_record('local_o365_token', $tokenparams);
		if (empty($tokenrec)) {
			throw new \Exception('No token');
		}
		$oidcconfig = get_config('auth_oidc');
		$httpclient = new \local_o365\httpclient();
		$clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret, $oidcconfig->authendpoint, $oidcconfig->tokenendpoint);
		$token = new \local_o365\oauth2\token($tokenrec->token, $tokenrec->expiry, $tokenrec->refreshtoken, $tokenrec->scope, $tokenrec->resource, $clientdata, $httpclient);
		$apiclient = new \local_o365\rest\sharepoint($token, $httpclient);
		if (isset($_POST['site'])) {
			$apiclient->set_site($_POST['site']);
		}
		if (isset($_POST['raw']['submit'])) {
			$params = ($_POST['raw']['method'] !== 'get' && isset($_POST['raw']['postdata'])) ? $_POST['raw']['postdata'] : '';
			$response = $apiclient->apicall($_POST['raw']['method'], $_POST['raw']['endpoint'], $params);
			apiresult_examine($response);
		} elseif(isset($_POST['readdir']['submit'])) {
			$response = $apiclient->get_files($_POST['readdir']['directory']);
			apiresult_examine($response);
		} elseif(isset($_POST['createsite']['submit'])) {
			$response = $apiclient->create_site($_POST['createsite']['title'], $_POST['createsite']['url'], $_POST['createsite']['description']);
			apiresult_examine($response);
		}
	} elseif ($_POST['api'] === 'aad') {
		$systemtokens = get_config('local_o365', 'systemtokens');
		$systemtokens = unserialize($systemtokens);
		$aadresource = \local_o365\rest\azuread::get_resource();
		if (!isset($systemtokens[$aadresource])) {
			throw new \Exception('No token');
		}
		$tokenrec = (object)$systemtokens[$aadresource];
		$oidcconfig = get_config('auth_oidc');
		$httpclient = new \local_o365\httpclient();
		$clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret, $oidcconfig->authendpoint, $oidcconfig->tokenendpoint);
		$token = new \local_o365\oauth2\token($tokenrec->token, $tokenrec->expiry, $tokenrec->refreshtoken,
				$tokenrec->scope, $tokenrec->resource, $clientdata, $httpclient);
		$apiclient = new \local_o365\rest\azuread($token, $httpclient);
		if (isset($_POST['raw']['submit'])) {
			$params = ($_POST['raw']['method'] !== 'get' && isset($_POST['raw']['postdata'])) ? $_POST['raw']['postdata'] : '';
			$response = $apiclient->apicall($_POST['raw']['method'], $_POST['raw']['endpoint'], $params);
			apiresult_examine($response);
		} elseif(isset($_POST['users']['submit'])) {
			$response = $apiclient->get_users();
			apiresult_examine($response);
		} elseif(isset($_POST['user']['submit'])) {
			$response = $apiclient->get_user($_POST['user']['oid']);
			apiresult_examine($response);
		} elseif(isset($_POST['sync']['submit'])) {
			$response = $apiclient->sync_users();
			apiresult_examine($response);
		}
	} elseif ($_POST['api'] === 'onedrive') {
		$tokenparams = ['user_id' => $USER->id, 'resource' => \local_o365\rest\onedrive::get_resource()];
		if (empty($tokenparams['resource'])) {
			throw new \Exception('Not configured');
		}
		$tokenrec = $DB->get_record('local_o365_token', $tokenparams);
		if (empty($tokenrec)) {
			throw new \Exception('No token');
		}
		$oidcconfig = get_config('auth_oidc');
		$httpclient = new \local_o365\httpclient();
		$clientdata = new \local_o365\oauth2\clientdata($oidcconfig->clientid, $oidcconfig->clientsecret, $oidcconfig->authendpoint, $oidcconfig->tokenendpoint);
		$token = new \local_o365\oauth2\token($tokenrec->token, $tokenrec->expiry, $tokenrec->refreshtoken, $tokenrec->scope, $tokenrec->resource, $clientdata, $httpclient);
		$apiclient = new \local_o365\rest\onedrive($token, $httpclient);
		if (isset($_POST['readdir']['submit'])) {
			$response = $apiclient->get_contents($_POST['readdir']['directory']);
			apiresult_examine($response);
		} else if (isset($_POST['createfile']['submit'])) {
			$response = $apiclient->create_file($_POST['createfile']['folderpath'], $_POST['createfile']['filename'], $_POST['createfile']['contents']);
			apiresult_examine($response);
		}

	}

	echo '</pre>';
}
?>

<div id="wrapper">

<header>AzureAD/O365 Rest Sandbox</header>
<div class="switchers">
<span onclick="switchform('aad', this)" class="switcher">AzureAD</span>
<span onclick="switchform('sharepoint', this)" class="switcher">Sharepoint</span>
<span onclick="switchform('onedrive', this)" class="switcher selected">OneDrive</span>
<span onclick="switchform('calendar', this)" class="switcher">Calendar</span>
</div>

<div id="forms">
<form id="api_aad" class="apiform" method="post" style="display:none">
	<input type="hidden" name="api" value="aad">
	<div class="scratchwrapper">
		<h4>Scratch</h4>
		<textarea name="scratch" style="width:100%;height:40rem;"><?php echo (isset($_POST['scratch'])) ? $_POST['scratch'] : ''; ?></textarea>
	</div>
	<h4>Raw API Call</h4>
	<select name="raw[method]">
		<?php
		foreach (['get', 'post', 'patch', 'merge', 'delete'] as $method) {
			$select = ($method === $_POST['raw']['method']) ? 'selected="selected"' : '';
			echo '<option value="'.$method.'" '.$select.'>'.$method.'</option>';
		}
		?>
	</select>
	<input type="text" name="raw[endpoint]" size="60" value="<?php if (!empty($_POST['raw']['endpoint'])) { echo $_POST['raw']['endpoint']; } ?>"/><br />
	<textarea name="raw[postdata]" placeholder="postdata" cols="58" rows="10"><?php echo (isset($_POST['raw']['postdata'])) ? $_POST['raw']['postdata'] : '';?></textarea><br />
	<input type="submit" name="raw[submit]"/>
	<br />
	<h4>Get All Users</h4>
	<input type="submit" name="users[submit]" value="Get All Users"/><br /><br />
	<h4>Get User Info</h4>
	<input type="text" name="user[oid]" size="60" value="<?php if (!empty($_POST['user']['oid'])) { echo $_POST['user']['oid']; } ?>"/><br />
	<input type="submit" name="user[submit]"/><br /><br />
	<h4>Sync Users</h4>
	<input type="submit" name="sync[submit]" value="Sync Users"/>
</form>

<form id="api_sharepoint" class="apiform" method="post" style="display:none">
	<input type="hidden" name="api" value="sharepoint">
	<div class="scratchwrapper">
		<h4>Scratch</h4>
		<textarea name="scratch" style="width:100%;height:40rem;"><?php echo (isset($_POST['scratch'])) ? $_POST['scratch'] : ''; ?></textarea>
	</div>
	Site: <input type="text" name="site" value="<?php echo (isset($_POST['site'])) ? $_POST['site'] : 'Moodle'; ?>" />
	<h4>Raw API Call</h4>
	<select name="raw[method]">
		<?php
		foreach (['get', 'post', 'patch', 'merge', 'delete'] as $method) {
			$select = ($method === $_POST['raw']['method']) ? 'selected="selected"' : '';
			echo '<option value="'.$method.'" '.$select.'>'.$method.'</option>';
		}
		?>
	</select>
	<input type="text" name="raw[endpoint]" size="60" value="<?php if (!empty($_POST['raw']['endpoint'])) { echo $_POST['raw']['endpoint']; } ?>"/><br />
	<textarea name="raw[postdata]" placeholder="postdata" cols="58" rows="10"><?php echo (isset($_POST['raw']['postdata'])) ? $_POST['raw']['postdata'] : '';?></textarea><br />
	<input type="submit" name="raw[submit]"/>
	<br />

	<h4>Read directory</h4>
	<input type="text" name="readdir[directory]" size="60" value="<?php if (!empty($_POST['readdir']['directory'])) { echo $_POST['readdir']['directory']; } ?>"/>
	<input type="submit" name="readdir[submit]"/>
	<br />

	<h4>Create Site</h4>
	<?php
	$params = [
		'title' => 'Title',
		'url' => 'URL',
		'description' => 'Description'
	];
	foreach ($params as $param => $label) {
		$value = (isset($_POST['createsite'][$param])) ? $_POST['createsite'][$param] : '';
		echo "<label for=\"createsite_{$param}\">{$label}</label><input type=\"text\" id=\"createsite_{$param}\" name=\"createsite[{$param}]\" size=\"60\" value=\"{$value}\"/><br />";
	}
	?>
	<input type="submit" name="createsite[submit]"/>
</form>

<form id="api_onedrive" class="apiform" method="post">
	<input type="hidden" name="api" value="onedrive">
	<h4>Read directory</h4>
	<input type="text" name="readdir[directory]" size="60" value="<?php if (!empty($_POST['readdir']['directory'])) { echo $_POST['readdir']['directory']; } ?>"/>
	<input type="submit" name="readdir[submit]"/>
	<br />

	<h4>Create File</h4>
	Path: <input type="text" name="createfile[folderpath]" value="<?php if (!empty($_POST['createfile']['folderpath'])) { echo $_POST['createfile']['folderpath']; } ?>"/><br />
	Filename: <input type="text" name="createfile[filename]" value="<?php if (!empty($_POST['createfile']['filename'])) { echo $_POST['createfile']['filename']; } ?>"/><br />
	Content: <br /><textarea name="createfile[contents]"><?php echo (isset($_POST['createfile']['contents'])) ? $_POST['createfile']['contents'] : '';?></textarea><br />
	<input type="submit" name="createfile[submit]"/>
</form>

</div>
</div>
</body>
</html>