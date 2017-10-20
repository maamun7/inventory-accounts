<div class="form-container">
    <form class="form-vertical" action="<?=base_url()?>cclosing/add_daily_closing" id="daily_closing" method="post"  name="daily_closing" enctype="multypart/formdata">
		<div class="lblFieldContnr">
			<div class="lblContnr">Last Day Closing</div>
			<div class="fieldContnr">
				<input type="text" name="last_day_closing" value="{last_closing_amount}" readonly="readonly" />
			</div>
		</div>
		<div class="lblFieldContnr">
			<div class="lblContnr">Sales in Cheque</div>
			<div class="fieldContnr">
				<input type="text" name="sales_in_cheque" value="{total_cheque_sales}" readonly="readonly" />
			</div>
		</div>
		<div class="lblFieldContnr">
			<div class="lblContnr">Cheque to Cash</div>
			<div class="fieldContnr">
				<input type="text" name="cheque_to_cash" value="{cheque_to_cash}" readonly="readonly" />
			</div>
		</div>
		<div class="lblFieldContnr">
			<div class="lblContnr">Sales in Cash</div>
			<div class="fieldContnr">
				<input type="text" name="sales_in_cash" value="{total_cash_sales}" readonly="readonly" />
			</div>
		</div>
		<div class="lblFieldContnr">
			<div class="lblContnr">Expense</div>
			<div class="fieldContnr">
				<input type="text" name="expense" value="{total_expense_amount}" readonly="readonly" />
			</div>
		</div>
		<div class="lblFieldContnr">
			<div class="lblContnr">Drawing</div>
			<div class="fieldContnr">
				<input type="text" name="drawing" value="{total_draw_amount}" readonly="readonly" />
			</div>
		</div>
		<div class="lblFieldContnr">
			<div class="lblContnr">Amount</div>
			<div class="fieldContnr">
				<input type="number" id="amount" name="amount" value="{final_amount}" readonly="readonly" required />
			</div>
		</div>
		<div class="lblFieldContnr">
			<div class="lblContnr">Adjusment</div>
			<div class="fieldContnr">
				<input type="number" id="adjusment" name="adjusment" />
			</div>
		</div>
		<div class="lblFieldContnr">
			<div class="lblContnr"></div>
			<div class="fieldContnr">
				<input type="submit" id="add-deposit" class="btn btn-primary" name="add-deposit" value="Day Closing" required />
			</div>
		</div>
    </form>
</div>
