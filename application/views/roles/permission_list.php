<div class="page-header">
    <h1>Permission List</h1>
</div>

<?php
if(!empty($permissions)){
?>
<table class="table table-striped table-condensed table-bordered">
	<thead>
		<tr>
			<th>Serial No.</th>
			<th>Permission Name</th>
			<th>Permission Alias</th>
			<th>Group Name</th>
		</tr>
	</thead>
	<tbody>
	{permissions}
		<tr>
			<td>{sl}</td>
			<td>{permission}</td>
			<td>{permission_alias}</td>
			<td>{group}</td>
		</tr>
	{/permissions}
	</tbody>
</table>

<?php
}else{
?>
<div class="NoDataFound"><center>No Data Found</center></div>
<?php
}
?>
