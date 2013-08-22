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
?>
</form>
</div>