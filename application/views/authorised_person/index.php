<h2>Authorised Person list</h3>
<div class="row-fluid">
	<div>
		<form class="well form-inline" method="post" action="#">
			<label class="select">Search By Name: </label>
				<input type="text" name="supplier_name" class="span3 supplierSelection" placeholder='Type Name' id="" >
			<button type="submit" class="btn">Search</button>
		</form>
	</div>
</div>
<?php
if(!empty($authorised_persons_list)){
?>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Name</th>
			<th>Designation</th>
			<th>Mobile</th>
			<th>Phone</th>
			<th><center>Actions</center></th>
		</tr>
	</thead>
	<tbody>
	{authorised_persons_list}
		<tr>
			<td>{sl}</td>
			<td>{name}</td>
			<td>{designation}</td>
			<td>{mobile_no}</td>
			<td>{phone_no}</td>
			<td>
				<center>
					<a href="<?php echo base_url().'cauthorised_person/edit/{id}'; ?>"><i title="Edit" class="icon-edit"></i></a>&nbsp; | &nbsp;
					<span class="deleteAuthPerson" name="{id}"><i title="Delete" class="icon-trash"></i></span>
				</center>
			</td>
		</tr>
	{/authorised_persons_list}
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