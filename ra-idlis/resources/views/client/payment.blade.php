@extends('main')
@section('content')
@include('client.cmp.__payment')
<body>
	@include('client.cmp.nav')
	@include('client.cmp.__msg')

	<div class="container mt-5" style="min-height: 457px;">
		@isset($appCur)
		<h2>Select Application</h2><br>
		@if(count($appCur) > 0)
		@for($k = 0; $k < (ceil(count($appCur)/3)); $k++)
			<div class="row"><?php $inOf = ($k*(ceil(count($appCur)/3))); ?>
			@for($i = $inOf; $i < ((($inOf+3) > count($appCur)) ? count($appCur) : ($inOf+3)); $i++)
				<form method="post" action="{{asset('/client/payment')}}">
					{{csrf_field()}}
					<input type="hidden" name="pApt" value="{{$appCur[$i]->aptid}}">
					<input type="hidden" name="pApid" value="{{$appCur[$i]->appid}}">
					<input type="submit" name="pAptBtn" hidden>
				</form>
				<div class="col-md-4">
					<div class="card text-white bg-dark o-hidden h-100 dashboard-leave-menu">
		             <div class="card-body">
		               <div class="card-body-icon" style="opacity: 0.4;">
		                 <i class="fa fa-fw fa-check"></i>
		               </div>
		               <div class="text-uppercase" style="font-size: 27px;text-decoration: underline;"><strong>{{$appCur[$i]->hfser_desc}}</strong></div>
		               <div class="text-uppercase small">{{$appCur[$i]->aptdesc}} ({{$appCur[$i]->trns_desc}})</div>
		             </div>
		             <a class="card-footer text-white clearfix small z-1" onclick="document.getElementsByName('pAptBtn')[{{$i}}].click();" style="cursor: pointer;">
		               <span class="float-left text-uppercase">View Details</span>
		               <span class="float-right">
		                 <i class="fa fa-angle-right"></i>
		               </span>
		             </a>
		           	</div>
		        </div>
			@endfor
			</div><hr>
		@endfor
		@else
			<center><p>Application(s) applied may be payed or rejected.</p></center>
		@endif
		@endisset

		@isset($oopCur)
		<h2>Select Order of Payment</h2><br>
		@if(count($oopCur) > 0)
		@foreach($oopCur AS $oopRow)
		<form method="post" action="{{asset('/client/payment')}}">
			{{csrf_field()}}
			<input type="hidden" name="pOop" value="{{$oopRow->oop_id}}">
			<input type="submit" name="pOopBtn" class="btn btn-sm btn-light" value="{{$oopRow->oop_desc}}">@if($oopRow->bool_stat != NULL) <i class="fa fa-check"> new payment</i> @endif<hr>
		</form>
		@endforeach
		@else
			<center><p>No data for Order of Payment</p></center>
		@endif
		@endisset

		@isset($oapCur)
		<h2>Select Add-ons to Payment</h2>
		<div class="row">
			<div class="col-sm-7">
				@isset($usTbl)
					<h6>Health Facility: <strong>{{$usTbl[0]->hfser_desc}}</strong></h6>
					<h6>Order of Payment: <strong>{{$usTbl[0]->oop_desc}}</strong></h6>
					<small>Application Type:</small> <strong>{{$usTbl[0]->aptdesc}}</strong>
					<small>Status:</small> <u style="color: red;">{{$usTbl[0]->trns_desc}}</u>
				@endisset
				@if(count($catTbl) > 0) @foreach($catTbl AS $catRow)
				<div class="accordion" id="accordionExample">
				  <div class="card">
				    <div class="card-header" id="headingOne">
				      <h5 class="mb-0">
				        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne{{$catRow->cat_id}}" aria-expanded="true" aria-controls="collapseOne{{$catRow->cat_id}}">
				          {{$catRow->cat_desc}}
				        </button>
				      </h5>
				    </div>

				    <div id="collapseOne{{$catRow->cat_id}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
				      <div class="card-body table-responsive">
				      	<table class="table">
				      		<thead>
				      			<tr>
				      				<th>Name</th>
				      				<th>Amount</th>
				      				<th>Option</th>
				      			</tr>
				      		</thead>
				      		<tbody>
				      			@if(count($oapCur) > 0) @foreach($oapCur AS $oapRow)
						        @if($oapRow->cat_id == $catRow->cat_id)
						        <tr>
						        	<td>{{$oapRow->chg_desc}}</td>
						        	<td>&#8369; {{number_format($oapRow->amt, 2)}}</td>
						        	<td><i id="{{$oapRow->chgapp_id}}" class="fa fa-plus-circle" style="cursor: pointer;" onclick="_addCh(['{{$oapRow->chgapp_id}}', '{{$oapRow->chg_desc}}', '{{$oapRow->amt}}'])"></i></td>
						        </tr>
						        @endif
						        @endforeach @else
						        <tr><td colspan="2">None</td></tr>
						        @endif
				      		</tbody>
				      	</table>
				      </div>
				    </div>
				  </div>
				</div>
				@endforeach @else
				<p style="color: red;">No record.</p>
				@endif
			</div>

			<div class="col-sm-5">
				<div class="card" style="box-shadow: rgba(0, 0, 0, 0.25) -5px 5px 10px; height: 400px;">
					<div class="card-header bg-success text-white text-uppercase">Payment Summary</div>
					<div class="card-body table-responsive">
						<form id="_fPSub" method="post" action="{{asset('/client/payment')}}">
							{{csrf_field()}}
							@if(count($oapTbl) > 0) @foreach($oapTbl AS $oapRow)
							<input type="hidden" name="chgapp_id[]" value>
							<input type="hidden" name="desc[]" value="Charge: {{$oapRow->oop_desc}}">
							<input type="hidden" name="amt[]" value="{{$oapRow->amt}}">
							<small>Charge: <strong>{{$oapRow->oop_desc}}</strong></small><br>
							<small>Amount: &#8369; <strong>{{number_format($oapRow->amt, 2)}}</strong></small>
							@endforeach @endif
							<table class="table">
								<thead>
									<tr>
										<td>Name</td>
										<td>Amount</td>
										<td>Option</td>
									</tr>
								</thead>
								<tbody id="tBody">
									<tr> <td colspan="3">None</td> </tr>
								</tbody>
							</table>
							<input type="hidden" name="_fPSubBtn" value="Submit">
						</form>
					</div>
					<div class="card-footer">
						<div class="row">
							<div class="col-sm-8"><p>Total &#8369; <span id="tlPayment">0</span></p></div>
							<div class="col-sm-4">
								<button form="_fPSub" class="btn btn-sm btn-success" style="float: right;">Continue</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		@endisset

		@isset($fPGo)
		<h2>Select Payment Method</h2><br>
		<div class="row">
			<div class="col-sm-3 text-center">
				<img src="https://www.paypalobjects.com/digitalassets/c/website/logo/full-text/pp_fc_hl.svg" style="width: 130px; height: 130px; object-fit: contain; cursor: pointer;" onclick="_nxtCh(0)">
			</div>
			<div class="col-sm-3 text-center">
				<img src="https://www.dragonpay.ph/wp-content/themes/wp365_theme/img/logo_dragonpay.png" style="width: 130px; height: 130px; object-fit: contain; cursor: pointer;" onclick="_nxtCh(1)">
			</div>
			<div class="col-sm-3 text-center">
				<img src="https://www.landbank.com/sites/default/files/weblogo.png" style="width: 130px; height: 130px; object-fit: contain; cursor: pointer;" onclick="_nxtCh(2)">
			</div>
			<div class="col-sm-3 text-center">
				<img src="https://img.clipartxtras.com/309d45f487bcb8498d858f26ea011a18_walking-man-black-clip-art-at-clkercom-vector-clip-art-online-walking-clipart-png_744-1052.svg" style="width: 130px; height: 130px; object-fit: contain; cursor: pointer;" onclick="_nxtCh(3)">
			</div>			
		</div>
		<div class="row">
			<div class="col-sm-7 table-responsive">
				<table class="table">
					<thead>
						<tr><th>Name</th><th>Amount</th></tr>
					</thead>
					<tbody>
						<?php $_total = 0; ?> @if($fPGo['_fPAmt'] != NULL) @for($i = 0; $i < count($fPGo['_fPAmt']); $i++)
						<tr>
							<td>{{$fPGo['_fPDesc'][$i]}}</td>
							<td>&#8369; {{number_format($fPGo['_fPAmt'][$i], 2)}}</td>
						</tr>
						<?php $_total = $_total + intval($fPGo['_fPAmt'][$i]); ?> @endfor @else
						<tr><td colspan="2">No record</td></tr>
						@endif
					</tbody>
					<tfoot>
						<tr>
							<td><strong>TOTAL</strong></td>
							<td><strong>&#8369; {{number_format($_total, 2)}}</strong></td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="col-sm-5">
				<div class="pp1" hidden>
					<img src="https://www.paypalobjects.com/digitalassets/c/website/logo/full-text/pp_fc_hl.svg" style="width: 100px; height: 100px; object-fit: contain;">
					<p style="line-height: 1;"><small>PayPal Holdings, Inc. is an American company operating a worldwide online payments system that supports online money transfers and serves as an electronic alternative to traditional paper methods like cheques and money orders.</small></p>
					<hr>
					<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
	                    {{csrf_field()}}
	                 	<input type="hidden" name="cmd" value="_cart">
	                 	<input type="hidden" name="upload" value="1">
	                 	<input type="hidden" name="business" value="ra.janpaolocleotes-facilitator@gmail.com">
	                 	<input TYPE="hidden" NAME="currency_code" value="PHP">
	                  	@if($fPGo['_fPAmt'] != NULL) @for($i = 0; $i < count($fPGo['_fPAmt']); $i++)
	                        <input type="hidden" name="item_name_{{($i+1)}}" value="{{$fPGo['_fPDesc'][$i]}}">
	                        <input type="hidden" name="quantity_{{($i+1)}}" value="1">
	                        <input type="hidden" name="shipping_{{($i+1)}}" value="0.00">
	                        <input type="hidden" name="amount_{{($i+1)}}" value="{{$fPGo['_fPAmt'][$i]}}">
						@endfor @endif 
	                    {{-- <input type="hidden" name="return" id="return"> --}}
	                    <input type="hidden" name="cancel_return" id="cancel_return" value="{{asset('/client/payment')}}/{{csrf_token()}}/292">

	                    <button type="submit" class="btn btn-light" style="float: right;">Continue with PayPal <i class="fab fa-paypal"></i></button>
                 	</form>
				</div>
				<div class="pp1" hidden>
					<img src="https://www.dragonpay.ph/wp-content/themes/wp365_theme/img/logo_dragonpay.png" style="width: 100px; height: 100px; object-fit: contain;">
					<p style="line-height: 1;"><small>Dragonpay is a leading online payment service provider in the Philippines. We provide an easy and convenient way to pay for products and services online.</small></p>
					<hr>
					<button class="btn btn-light" style="float: right;">Continue with DragonPay</button>
				</div>
				<div class="pp1" hidden>
					<img src="https://www.landbank.com/sites/default/files/weblogo.png" style="width: 100px; height: 100px; object-fit: contain;">
					@if($fPGo['_fPAmt'] != NULL) <form id="_lndForm" method="POST" action="{{asset('client/payment')}}/{{csrf_token()}}/294" enctype="multipart/form-data">
                      {{csrf_field()}}
                      <div class="row">
                      	<div class="col-sm-6">
	                      <div class="form-group">
	                      	<label>Date of Payment:</label>
	                      	<input type="date" class="form-control form-control-sm" name="au_date">
	                      </div>
	                    </div>
	                    <div class="col-sm-6">
	                      <div class="form-group">
	                      	<label>Upload Official Receipt:</label>
	                      	<input type="file" class="form-control form-control-sm" name="au_file">
	                      </div>
	                    </div>
                      </div>
                      <div class="row">
                      	<div class="col-sm-6">
	                      <div class="form-group">
	                      	<label>Reference Number:</label>
	                      	<input type="text" class="form-control form-control-sm" name="au_ref">
	                      </div>
	                    </div>
	                    <div class="col-sm-6">
	                      <div class="form-group">
	                      	<label>Amount:</label>
	                      	<input type="number" class="form-control form-control-sm" name="au_amount">
	                      </div>
	                    </div>
                      </div>
	                </form> @else <p>No record(s) selected.</p> @endif
					<hr>
					<button form="_lndForm" class="btn btn-light" style="float: right;">Continue with LandBank</button>
				</div>
				<div class="pp1" hidden>
					<img src="https://img.clipartxtras.com/309d45f487bcb8498d858f26ea011a18_walking-man-black-clip-art-at-clkercom-vector-clip-art-online-walking-clipart-png_744-1052.svg" style="width: 100px; height: 100px; object-fit: contain;">
	                <div class="row">
	                    <div class="col-sm-1 text-right">
	                      	<input id="s_wlk" type="checkbox" name="chance" onchange="_fWalkIn(this.checked)">
	                    </div>
	                    <div class="col-sm-10">
	                      	<p for="s_wlk" style="line-height: 1;" class="text-justify"><b>CONTINUE PAYMENT AS WALK-IN</b> <small>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris.Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris</small></p>
	                    </div>
	                    @if($fPGo['_fPAmt'] != NULL) <form id="_fWlk" method="GET" action="{{asset('client/payment')}}/{{csrf_token()}}/290"></form> @endif
	                </div>
	                <hr>
					<button id="_fWlkBtn" class="btn btn-light" style="float: right;">Continue with Walk-in Payment</button>
				</div>
			</div>
		</div>
		@endisset
	</div><br>
</body>
@include('client.cmp.foot')
@endsection