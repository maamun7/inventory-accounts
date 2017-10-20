<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/product.js.php" ></script>
<div class="page-header">
    <h1>Users Role List</h1>
</div>

<?php
if(!empty($role_lists)){
?>
<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th>Serial No</th>
			<th>Role Name</th>
			<th><center>Actions</center></th>
		</tr>
	</thead>
	<tbody>
	{role_lists}
		<tr>
			<td>{sl}</td>
			<td>{role}</td>
			<td>
				<center>
					<a href="<?php echo base_url().'crole/edit_role/{role_id}'; ?>"><i title="Edit Role" class="icon-edit"></i></a>&nbsp; | &nbsp;
					<a title="Permission change" href="<?=base_url()?>crole/permission/{role_id}">Change permissions</a>
				</center>
			</td>
		</tr>
	{/role_lists}
	</tbody>
</table>

<?php
}else{
?>
<div class="NoDataFound"><center>No Data Found</center></div>
<?php
}
?>
