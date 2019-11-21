<div class="row">

		<div class="col-lg-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<form class="" name="formalipay" id="formalipay" action="" method="get" autocomplete="on">
					<h4 class="card-title">Search</h4>
					<div class="form-group row">
						
						
						<div class="col">
							<label for="payee_account">@lang('dingsu.member')</label>
							<div id="the-basics">
								<input type="text" class="form-control typeahead tt-input" name="payee_account" id="payee_account" placeholder="@lang('dingsu.member')">
							</div>
						</div>

						<div class="col">
							<label for="amount">@lang('dingsu.amount')</label>
							<div id="the-basics">
								<input type="text" class="form-control typeahead tt-input" name="amount" id="amount" placeholder="@lang('dingsu.amount')">
							</div>
						</div>
						
						

						<div class="col">
							<label>@lang('dingsu.action')</label>
							<div id="bloodhound">
								<button  type="submit" id="addpayment" class="btn btn-icons btn-rounded btn-outline-info btn-inverse-info addpayment"> <i class="  icon-magnifier  "></i> </button>
							</div>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	
</div>


