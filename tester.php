<?php

require_once('setup.php');

$output = false;

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
