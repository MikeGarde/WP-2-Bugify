<h2>Select A Project</h2>

<p>Please select the project you want reports to be filed under.</h2>

<script type="text/javascript">
	window.onload=function(){
	var tfrow = document.getElementById('wp2b_table_hover').rows.length;
	var tbRow=[];
	for (var i=1;i<tfrow;i++) {
		tbRow[i]=document.getElementById('wp2b_table_hover').rows[i];
		tbRow[i].onmouseover = function(){
		  this.style.backgroundColor = '#ffffff';
		};
		tbRow[i].onmouseout = function() {
		  this.style.backgroundColor = '#d4e3e5';
		};
	}
};
</script>

<style type="text/css">
table.wp2b_table {font-size:12px;color:#333333;border-width: 1px;border-color: #729ea5;border-collapse: collapse;}
table.wp2b_table th {font-size:12px;background-color:#acc8cc;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;text-align:left;}
table.wp2b_table tr {background-color:#d4e3e5;}
table.wp2b_table td {font-size:12px;border-width: 1px;padding: 8px;border-style: solid;border-color: #729ea5;}
table.wp2b_table td.name {min-width: 185px;}
table.wp2b_table td select {min-width: 140px;}
</style>

<table id="wp2b_table_hover" class="wp2b_table" border="1">
	<thead>
		<tr>
			<th colspan="2">Name</th>
			<th>Categories</th>
		</tr>
	</thead>
	<tbody>
<?php 		$default_categories = '';

			foreach($projects->projects as $project) : 

				$print_categories = '';
				foreach($project->categories as $category) {
					$project_categories[$category->id] = addslashes($category->name); 
					$print_categories .= $category->name.', '; 
				}

				$print_categories = rtrim($print_categories, ', ');

				if($this->options['project'] == $project->id)
					$default_categories = json_encode($project_categories);
?>
		<tr>
			<td><input 	type="radio" 
						name="<?php echo $this->opt_name; ?>_project" 
						id="project_<?php echo $project->id; ?>" 
						value="<?php echo $project->id; ?>"
						data-cat='<?php echo json_encode($project_categories); ?>'
						<?php if($this->options['project'] == $project->id) echo ' checked="checked"'; ?> /></td>
			<td class="name"><label for="project_<?php echo $project->id; ?>"><?php echo $project->name; ?></label></td>
			<td>
<?php 			echo $print_categories; ?>
			</td>
		</tr>
<?php 		endforeach; // projects ?>

	</tbody>
</table>

<input type="hidden" class="category_target" name="<?php echo $this->opt_name; ?>_categories" value="<?php echo $default_categories; ?>" />

<script>
	jQuery('#wp2b_table_hover input[type="radio"').change(function() {
		var cat_value = jQuery(this).attr('data-cat');
		console.log('cat_value: '+cat_value);
		jQuery('.category_target').val( cat_value );
	});
</script>

<?php submit_button(); ?>

<?php
if($this->ready)
	echo '<p style="color: LimeGreen; font-size: 26px;">Setup Complete!</p>';
