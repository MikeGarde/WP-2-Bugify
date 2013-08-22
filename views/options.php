<div class="wrap">
<?php screen_icon('bugify'); ?>
<h2>Bugify Options</h2>

<form method="post" action="options.php">
    <table class="form-table">
        <tr valign="top">
        <th scope="row">API URL</th>
        <td><input type="text" name="bugify_url" value="<?php echo get_option('new_option_name'); ?>" /></td>
        </tr>

        <tr valign="top">
        <th scope="row">API Key</th>
        <td><input type="text" name="bugify_key" value="<?php echo get_option('some_other_option'); ?>" /></td>
        </tr>
    </table>

    <?php submit_button(); ?>

</form>
</div>