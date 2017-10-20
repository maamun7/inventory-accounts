<h2>Bank list</h3>
<?php
if(!empty($bank_list)){
?>
<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th>#</th>
			<th>Bank Name</th>
		</tr>
	</thead>
	<tbody>
	{bank_list}
		<tr>
			<td>{sl}</td>
			<td>{bank_name}</td>
		</tr>
	{/bank_list}
	</tbody>
</table>
<?php
}else{
?>
<div class="NoDataFound"><center>No Data Found</center></div>
<?php
}
?>