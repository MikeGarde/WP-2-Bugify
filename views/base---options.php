<?php

global $bugify;

?>
<div class="wrap">
<?php screen_icon('bugify'); ?>
<h2>Bugify Options</h2>

<form method="post" action="options.php">

<?php

settings_fields('bugify');
do_settings_sections('bugify');

submit_button();


if(isset($bugify->options['url']) && isset($bugify->options['key'])) :

?>

<h3>Connection Info</h3>
<p>Based on the above URL I see the following</p>
<pre>
  scheme : <?php echo $bugify->request['scheme']; ?> 
  host   : <?php echo $bugify->request['host']; ?> 
  path   : <?php echo $bugify->request['path']; ?>

  <?php 
  	if($bugify->request['path'] != '/api')
  		echo PHP_EOL.'<strong style="color: red;">WARNING:</strong> The path indicated was not expected.';
  ?>
</pre>

<?php

	$test = $bugify->ping_system();
	
?>

<h3>Testing Connection</h3>

<?php

	if(isset($test->version))
		echo '<p><span style="color: LimeGreen;">Success!</span> Your server is running Bugify version: <strong>'. $test->version .'</strong></p>';
	else
		echo '<p>Unable to communicate with your Bugify server</p>';

endif;

?>

</div>

<?php $bugify->select_project(); ?>

</form>

<pre>
<?php

//print_r($bugify->options);

//print_r( $projects );

?>
</pre>
