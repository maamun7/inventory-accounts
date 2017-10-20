<div class="form-container">
    <form class="form-vertical" action="<?=base_url()?>cbank/add_new_bank" id="insert_deposit" method="post"  name="add_bank" enctype="multypart/formdata">
		<div class="lblFieldContnr">
			<div class="lblContnr">Bank Name</div>
			<div class="fieldContnr">
				<input type="text" name="bank_name" id="bank_name" />
			</div>
		</div>
		<div class="lblFieldContnr">
			<div class="lblContnr"></div>
			<div class="fieldContnr">
				<input type="submit" id="add-deposit" class="btn btn-primary" name="add-deposit" value="Add Bank" />
			</div>
		</div>
    </form>
</div>
