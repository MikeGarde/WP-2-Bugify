<?php

require_once('functions.php');

$output = false;

$methods = array(
			'root'						=> array('GET',  ''),
			'all_issues'				=> array('GET',  '/issues'),
			'new_issue'					=> array('POST', '/issues'),
			'issues_mine'				=> array('GET',  '/issues/mine'),
			'issues_following'			=> array('GET',  '/issues/following'),
			'issues_following_manage'	=> array('POST', '/issues/following/{issue_id}'),
			'issue_overview'			=> array('GET',  '/issues/{issue_id}'),
			'update_issue'				=> array('POST', '/issues/{issue_id}'),
			'search'					=> array('GET',  '/issues/search'),
			'filters'					=> array('GET',  '/filters'),
			'filter_issues'				=> array('GET',  '/filters/{filter_id}/issues'),
			'groups'					=> array('GET',  '/groups'),
			'users'						=> array('GET',  '/users'),
			'new_user'					=> array('POST', '/users'),
			'user_details'				=> array('GET',  '/users/{username}'),
			'edit_user'					=> array('POST', '/users/{username}'),
			'users_issues'				=> array('GET',  '/users/{username}/issues'),
			'projects'					=> array('GET',  '/projects'),
			'projects_issues'			=> array('GET',  '/projects/{project_slug}/issues'),
			'milestones'				=> array('GET',  '/milestones'),
			'milestones_issues'			=> array('GET',  '/milestones/{milestone_id}/issues'),
			'history'					=> array('GET',  '/history'),
			'queue'						=> array('GET',  '/queue'),
			'system'					=> array('GET',  '/system'),
			'auth'						=> array('POST', '/auth')
		);

$formats = array(
			'txt'	=> 'TXT (useful for debugging) (.txt)',
			'json'	=> 'JSON (.json)',
			'jsonp' => 'JSON-P (JSON with padding) (.jsonp)',
			'php'	=> 'Serialised PHP (.php)',
			'xml'	=> 'XML (.xml)'
		);


$bugify['request'] = false;

if(isset($_POST['bugify_url'])) {
	$bugify['url'] = trim($_POST['bugify_url']);
	$bugify['key'] = trim($_POST['bugify_key']);

	if($_POST['bugify_url'] != $_COOKIE['bugify_url'])
		setcookie('bugify_url', $_POST['bugify_url'], time() + 604800);

	if($_POST['bugify_key'] != $_COOKIE['bugify_key'])
		setcookie('bugify_key', $_POST['bugify_key'], time() + 604800);

} elseif(isset($_COOKIE['bugify_url'])) {
	$bugify['url'] = $_COOKIE['bugify_url'];
	$bugify['key'] = $_COOKIE['bugify_key'];
} else {
	$bugify['url'] = '';
	$bugify['key'] = '';
}


if(isset($_POST['bugify_url'])) {

	$bugify['name']   = $_POST['method'];
	$bugify['method'] = $methods[$_POST['method']][0];
	$bugify['path']   = $methods[$_POST['method']][1];

	$bugify['format'] = $_POST['format'];

	$bugify['request'] = $bugify['url'].$bugify['path'].'.'.$bugify['format'].'?api_key='.$bugify['key'];

	if($bugify['method'] == 'GET') {
		$output = get_remote_file($bugify['request']);
	}

}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Bugify Setup</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
	<form action="http://localhost/wordpress/wp-content/plugins/WP-2-Bugify/wp-2-bugify.php" method="post">

	<label for="bugify_url">URL: </label>
	<input type="text" id="bugify_url" name="bugify_url" value="<?php echo $bugify['url']; ?>" />

	<label for="bugify_key">API Key: </label>
	<input type="text" id="bugify_key" name="bugify_key" value="<?php echo $bugify['key']; ?>" />

	<label for="method">API Method: </label>
	<select name="method">
<?php	foreach($methods as $method => $options) {
			$selected = ($bugify['name'] == $method) ? ' selected="selected"' : '';
			echo '<option value="'. $method .'"'.$selected.'>'. $options[0] .' '. $options[1] .'</option>';
		} //endforeach; ?>
	</select>

	<label for="format">Response Format: </label>
	<select name="format">
<?php	foreach($formats as $format => $name) {
			$selected = ($bugify['format'] == $format) ? ' selected="selected"' : '';
			echo '<option value="'. $format .'"'.$selected.'>'. $name .'</option>';
		} //endforeach; ?>
	</select>

	<input type="submit" value="Send" /> <input type="reset" />
	</form>

	<?php if($bugify['request']) echo '<h3>'. $bugify['request'] .'</h3>'; ?>

<?php if($output) : ?>

	<h2>RAW Output</h2>
	<div class="raw output">
<?php	echo $output; ?>
	</div>

	<h2>Formatted Output (soon)</h2>
	<div class="clean output">
<?php	//echo $output; ?>
	</div>

<?php endif; ?>
</body>
</html>
<?php
