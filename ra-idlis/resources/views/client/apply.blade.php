@extends('main')
@section('content')
@include('client.cmp.__apply')
<body>
	@include('client.cmp.nav')
	@include('client.cmp.__msg')

	<div class="container mt-5" style="min-height: 473px;">
		@isset($hfserTbl) @if(count($hfserTbl) > 0)
		@for($k = 0; $k < (ceil(count($hfserTbl)/3)); $k++)
		<div class="row"><?php $inOf = ($k*((ceil(count($hfserTbl)/3))+1)); ?>
			@for($i = $inOf; $i < ((($inOf+3) > count($hfserTbl)) ? count($hfserTbl) : ($inOf+3)); $i++)
			<form method="POST" action="{{asset('/client/apply')}}">
				{{csrf_field()}}
				<input type="hidden" name="apHfd" value="{{$hfserTbl[$i]->hfser_id}}">
				<input type="hidden" name="apApt" value="{{$hfserTbl[$i]->aptid}}">
				<input type="submit" name="apBtn" value="Submit" hidden>
			</form>
			<div class="col-md-4">
				<div class="card text-white @if($hfserTbl[$i]->aptdesc != NULL) bg-success @else bg-info @endif o-hidden h-100 dashboard-leave-menu">
	             <div class="card-body">
	               <div class="card-body-icon" style="opacity: 0.4;">
	                 <i class="fa fa-fw fa-clipboard-list"></i>
	               </div>
	               <div class="text-uppercase" style="font-size: 27px;text-decoration: underline;"><strong>{{$hfserTbl[$i]->hfser_desc}}</strong></div>
	               <div class="text-uppercase small">@if($hfserTbl[$i]->aptdesc != NULL)<small>Application applied:</small> <strong>{{$hfserTbl[$i]->aptdesc}}</strong>@endif</div>
	             </div>
	             <a class="card-footer text-white clearfix small z-1" onclick="document.getElementsByName('apBtn')[{{$i}}].click();" style="cursor: pointer;">
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
		@endif @endisset

		@isset($aptTbl) 
		<h2>Select Application Type</h2>
		<h6><small>Facility Type:</small> <strong>{{$aHTbl[0]->hfser_desc}}</strong>@if($aHTbl[0]->aptdesc != NULL) <small>Last Application applied:</small> <strong>{{$aHTbl[0]->aptdesc}}</strong>@endif</h6>
		<hr>
		@foreach($aptTbl AS $aptRow) <?php $_btn = ""; $_fa = ""; if($aptRow->_disabled == NULL): $_btn = "btn-dark"; $_fa = "fa-exclamation-circle"; else: $_btn = "btn-light"; $_fa = "fa-check-circle"; endif; ?>
		@if($aptRow->_disabled != NULL) <form id="{{$aptRow->_disabled}}" method="POST" action="{{asset('/client/apply')}}">
			{{csrf_field()}}
			<input type="hidden" name="apFApt" value="{{$aptRow->aptid}}">
		</form> @endif
		<button @if($aptRow->_disabled != NULL) form="{{$aptRow->_disabled}}" @endif class="btn btn-block {{$_btn}}"><i class="fa {{$_fa}}"></i> {{$aptRow->aptdesc}}</button><hr>
		@endforeach @endisset

		@isset($apFTbl) @if($apFTbl != NULL)
		<div class="card">
			<div class="card-header">
				<div class="row">
					<div class="col-md-3 hide-div">
						<img src="{{asset('ra-idlis/public/img/doh2.png')}}" style="float: right; max-height: 60px; padding-left: 20px;">
					</div>
					<div class="col-md-6">
						<h5 class="card-title text-uppercase text-center">Application Form</h5>
						<h6 class="card-subtitle mb-2 text-center text-muted">{{$apFTbl[1]->hfser_desc}} ({{$apFTbl[0]->aptdesc}})</h6>
					</div>
					<div class="col-md-3 hide-div">
						<img src="{{asset('ra-idlis/public/img/doh2.png')}}" style="float: left; max-height: 60px; padding-right: 20px;">
					</div>
				</div>
			</div>
			<div class="card-body">
				@isset($subUser) @if(count($subUser) > 0)
				<div class="row col-border-right" style="border-top: 1px solid; border-right: 1px solid; border-left: 1px solid;">
					<div class="col-md-6">
						<p>Name of Health Facility: <br><strong>{{$curUser->facilityname}}</strong></p>
					</div>
					<div class="col-md-6">
						<p>Health Facility: <br><strong>{{$subUser[0]->facname}}</strong></p>
					</div>
				</div>
				<div class="row col-border-right" style="border-top: 1px solid; border-right: 1px solid; border-left: 1px solid;">
					<div class="col-md-4">
						<p>Owner: <br><strong>{{$curUser->authorizedsignature}}</strong></p>
					</div>
					<div class="col-md-4">
						<p>Email Address: <br><strong>{{$curUser->email}}</strong></p>
					</div>
					<div class="col-md-2">
						<p>Contact Number: <br><strong>{{$curUser->contact}}</strong></p>
					</div>
					<div class="col-md-2">
						<p>Bed Capacity: <br><strong>{{$curUser->bed_capacity}}</strong></p>
					</div>
				</div>
				<div class="row col-border-right" style="border-top: 1px solid; border-right: 1px solid; border-left: 1px solid;">
					<div class="col-md-3">
						<p>Region: <br><strong>{{$subUser[0]->rgn_desc}}</strong></p>
					</div>
					<div class="col-md-3">
						<p>Province: <br><strong>{{$subUser[0]->provname}}</strong></p>
					</div>
					<div class="col-md-3">
						<p>City/Municipality: <br><strong>{{$subUser[0]->cmname}}</strong></p>
					</div>
					<div class="col-md-3">
						<p>Barangay: <br><strong>{{$subUser[0]->brgyname}}</strong></p>
					</div>
				</div>
				<form id="afpForm" method="post" action="{{asset('/client/apply')}}">
					{{csrf_field()}}
					@isset($upApfTbl) @if(count($upApfTbl) > 0) <input type="hidden" name="curApid" value="{{$upApfTbl[0]->appid}}"> @endif @endisset
					<div class="row col-border-right" style="border-top: 1px solid; border-right: 1px solid; border-left: 1px solid;">
						<div class="col-md-6">
							<p>Ownership: <i class="fa fa-sync" style="cursor: pointer;" onclick="__chCl()"></i> <br><select name="owTbl" class="form-control" onchange="__chCl(this.value)">
								<option hidden selected disabled value>Select Ownership</option>
							</select><input type="text" class="form-control" name="owTbl"></p>
						</div>
						<div class="col-md-6">
							<p>Class: <i class="fa fa-sync" style="cursor: pointer;" onclick="__chCl(document.getElementsByName('owTbl')[0].value)"></i> <br><select name="clTbl" class="form-control" onclick="__chCl(document.getElementsByName('owTbl')[0].value, this.value)">
								<option hidden selected disabled value>Select Class</option>
							</select><input type="text" class="form-control" name="clTbl"></p>
						</div>
					</div>
					<div class="row col-border-right" style="border-top: 1px solid; border-right: 1px solid; border-left: 1px solid;">
						<div class="col-md-12 table-responsive" style="padding: 20px;">
							<table class="table">
								<thead>
									<tr>
										<th style="width: 60%;">Description</th>
										<th style="width: 40%;">File(s)</th>
									</tr>
								</thead>
								<tbody>
									@if(count($apUpApfTbl) > 0) @foreach($apUpApfTbl AS $apUpApfRow)
									<tr>
										<td>
											{{$apUpApfRow->updesc}}
										</td>
										<td>
											@isset($apUpApfRow->filepath)
											@if($apUpApfRow->evaluation != NULL) @if($apUpApfRow->evaluation == 1)
											<i class="fa fa-check-circle"> Approved</i>
											@else
											<i class="fa fa-times-circle"> Approved</i>
											@endif
											@else
											<i class="fa fa-spinner"> Pending</i>
											@endif
											@else
											<input type="file" class="form-control" name="upid[{{$apUpApfRow->upid}}]">
											@endisset
										</td>
									</tr>
									@endforeach 
									@else
									<tr><td colspan="2">No requirements to upload</td></tr>
									@endif
								</tbody>
							</table>
						</div>
					</div>
				</form>
				<div class="row col-border-right" style="border-top: 1px solid; border-right: 1px solid; border-left: 1px solid;">
				</div>

				<script type="text/javascript">
				@isset($clTbl)
				clArr = JSON.parse(("{{json_encode($clTbl)}}").replace(/&quot;/g,'"'));
				@endisset
				@isset($owTbl)
				owArr = JSON.parse(("{{json_encode($owTbl)}}").replace(/&quot;/g,'"'));
				@endisset
				__chCl();
				@if(count($upApfTbl) > 0)
				clDesc = "{{$upApfTbl[0]->classdesc}}"; owDesc = "{{$upApfTbl[0]->ocdesc}}";
				setTimeout(function() { __chCl("{{$upApfTbl[0]->ocid}}", "{{$upApfTbl[0]->classid}}") }, 500);
				@else
				@endif
				</script>
				@else
				<center><p>No user's record</p></center>
				@endif @endisset
			</div>
			<div class="card-footer">
				<div class="row">
					@if($isView != true)
					<div class="col-md-4" style="padding: 10px;">
						<button class="btn btn-info btn-block">Save file</button>
					</div>
					<div class="col-md-4" style="padding: 10px;">
						<button class="btn btn-warning btn-block">Save as Draft</button>
					</div>
					<div class="col-md-4" style="padding: 10px;">
						<button class="btn btn-dark btn-block">Open Saved Drafts</button>
					</div>
					@else
					<div class="col-md-12" style="padding: 10px;">
						<small class="tex-small text-muted" style="float: right;">Copyright</small>
					</div>
					@endif
				</div>
			</div>
		</div>
		@endif @endisset
	</div>
</body>
@include('client.cmp.foot')
@endsection