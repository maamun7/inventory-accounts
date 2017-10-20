<script src="<?php echo base_url(); ?>my-assets/js/admin_js/json/product.js.php" ></script>
<div class="page-header">
    <h1>Users list</h1>
</div>

<?php
if(!empty($lists)){
?>
<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Email</th>
			<th>First Name</th>
			<th>Last Name</th>
			<th>Role</th>
			<th>Status</th>
			<th>Can Login</th>
			<th>User Type</th>
			<th><center>Actions</center></th>
		</tr>
	</thead>
	<tbody>
	{lists}
		<tr>
			<td>{sl}</td>
			<td>{username}</td>
			<td>{first_name}</td>
			<td>{last_name}</td>
			<td>{role}</td>
			<td>{is_active}</td>
			<td>{can_login}</td>
			<td>{user_type}</td>
			<td>
				<center>
					<a href="<?php echo base_url().'cuser/edit/{user_id}'; ?>"><i title="Edit User" class="icon-edit"></i></a>
				</center>
			</td>
		</tr>
	{/lists}
	</tbody>
</table>
<div id="pagin"><center><?php if(isset($links)){echo $links;} ?></center></div>

<?php
}else{
?>
<div class="NoDataFound"><center>No Data Found</center></div>
<?php
}
?>
