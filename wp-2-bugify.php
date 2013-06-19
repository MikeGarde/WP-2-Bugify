<?php

require_once('functions.php');

$output = false;

if(isset($_POST['bugify_url'])) {
	$bugify['url'] = rtrim($_POST['bugify_url'], '/');
	$bugify['key'] =  trim($_POST['bugify_key']);

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

	if(preg_match('/root|all_issues|issues_mine|issues_following|issue_overview|search|filters|filter_issues|groups|users|user_detailsusers_issues|projects|projects_issues|milestones|milestones_issues|history|queue|system/is', $_POST['method']))
		$bugify['method'] = 'GET';
	else
		$bugify['method'] = 'POST';

	$bugify['format'] = $_POST['format'];

	switch ($_POST['method']) {
		case 'root':
			//echo "GET /";
			$bugify['path'] = '';
			break;
		case 'all_issues':
			//echo "GET /issues";
			$bugify['path'] = '/issues';
			break;
		case 'new_issue':
			//echo "POST /issues";
			$bugify['path'] = '/issues';
			break;
		case 'issues_mine':
			//echo "GET /issues/mine";
			$bugify['path'] = '/issues/mine';
			break;
		case 'issues_following':
			//echo " GET /issues/following";
			$bugify['path'] = '/issues/following';
			break;
		case 'issues_following_manage':
			//echo " POST /issues/following/{issue_id}";
			$bugify['path'] = '/issues/following/{issue_id}';
			break;
		case 'issue_overview':
			//echo " GET /issues/{issue_id}";
			$bugify['path'] = '/issues/{issue_id}';
			break;
		case 'update_issue':
			//echo " POST /issues/{issue_id}";
			$bugify['path'] = '/issues/{issue_id}';
			break;
		case 'search':
			//echo " GET /issues/search";
			$bugify['path'] = '/issues/search';
			break;
		case 'filters':
			//echo " GET /filters";
			$bugify['path'] = '/filters';
			break;
		case 'filter_issues':
			//echo " GET /filters/{filter_id}/issues";
			$bugify['path'] = '/filters/{filter_id}/issues';
			break;
		case 'groups':
			//echo " GET /groups";
			$bugify['path'] = '/groups';
			break;
		case 'users':
			//echo " GET /users";
			$bugify['path'] = '/users';
			break;
		case 'new_user':
			//echo " POST /users";
			$bugify['path'] = '/users';
			break;
		case 'user_details':
			//echo " GET /users/{username}";
			$bugify['path'] = '/users/{username}';
			break;
		case 'edit_user':
			//echo " POST /users/{username}";
			$bugify['path'] = '/users/{username}';
			break;
		case 'users_issues':
			//echo " GET /users/{username}/issues";
			$bugify['path'] = '/users/{username}/issues';
			break;
		case 'projects':
			//echo " GET /projects";
			$bugify['path'] = '/projects';
			break;
		case 'projects_issues':
			//echo " GET /projects/{project_slug}/issues";
			$bugify['path'] = '/projects/{project_slug}/issues';
			break;
		case 'milestones':
			//echo "GET /milestones";
			$bugify['path'] = '/milestones';
			break;
		case 'milestones_issues':
			//echo "GET /milestones/{milestone_id}/issues";
			$bugify['path'] = '/milestones/{milestone_id}/issues';
			break;
		case 'history':
			//echo "GET /history";
			$bugify['path'] = '/history';
			break;
		case 'queue':
			//echo "GET /queue";
			$bugify['path'] = '/queue';
			break;
		case 'system':
			//echo "GET /system";
			$bugify['path'] = '/system';
			break;
		case 'auth':
			echo "POST /auth";
			$bugify['path'] = '/auth';
			break;
	}

	if($bugify['method'] == 'GET') {
		$output = get_remote_file($bugify['url'].$bugify['path'].'.'.$bugify['format'].'?api_key='.$bugify['key']);
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
		<option value="root">GET .{format}</option>
		<option value="all_issues">GET /issues.{format}</option>
		<option value="new_issue">POST /issues.{format}</option>
		<option value="issues_mine">GET /issues/mine.{format}</option>
		<option value="issues_following">GET /issues/following.{format}</option>
		<option value="issues_following_manage">POST /issues/following/{issue_id}.{format}</option>
		<option value="issue_overview">GET /issues/{issue_id}.{format}</option>
		<option value="update_issue">POST /issues/{issue_id}.{format}</option>
		<option value="search">GET /issues/search.{format}</option>
		<option value="filters">GET /filters.{format}</option>
		<option value="filter_issues">GET /filters/{filter_id}/issues.{format}</option>
		<option value="groups">GET /groups.{format}</option>
		<option value="users">GET /users.{format}</option>
		<option value="new_user">POST /users.{format}</option>
		<option value="user_details">GET /users/{username}.{format}</option>
		<option value="edit_user">POST /users/{username}.{format}</option>
		<option value="users_issues">GET /users/{username}/issues.{format}</option>
		<option value="projects">GET /projects.{format}</option>
		<option value="projects_issues">GET /projects/{project_slug}/issues.{format}</option>
		<option value="milestones">GET /milestones.{format}</option>
		<option value="milestones_issues">GET /milestones/{milestone_id}/issues.{format}</option>
		<option value="history">GET /history.{format}</option>
		<option value="queue">GET /queue.{format}</option>
		<option value="system">GET /system.{format}</option>
		<option value="auth">POST /auth.{format}</option>
	</select>

	<label for="format">Response Format: </label>
	<select name="format">
		<option value="txt">TXT (useful for debugging) (.txt)</option>
		<option value="json">JSON (.json)</option>
		<option value="jsonp">JSON-P (JSON with padding) (.jsonp)</option>
		<option value="php">Serialised PHP (.php)</option>
		<option value="xml">XML (.xml)</option>
	</select>

	<input type="submit" value="Send" /> <input type="reset" />
	</form>

<?php if($output) : ?>

	<div id="output">
<?php	echo $output; ?>
	</div>

<?php endif; ?>
</body>
</html>
<?php
