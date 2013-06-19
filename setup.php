<?php

require_once('functions.php');

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