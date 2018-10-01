@extends('main')
@section('content')
@include('client.cmp.__evaluate')
<body>
	@include('client.cmp.nav')
	@include('client.cmp.__msg')

	<div class="container mt-5" style="min-height: 521px;">
		@isset($evTbl)
		<h2>Select Application</h2><hr>
		@if(count($evTbl) > 0) @for($k = 0; $k < (ceil(count($evTbl)/3)); $k++) 
		<div class="row">
			<?php $_nTotal = ($k*((ceil(count($evTbl)/3))+1)); ?> @for($i = $_nTotal; $i < ((($_nTotal+3) > count($evTbl)) ? count($evTbl) : ($_nTotal+3)); $i++)
			<form method="post" action="{{asset('/client/evaluation')}}">
				{{csrf_field()}}
				<input type="hidden" name="eApid" value="{{$evTbl[$i]->appid}}">
				<input type="hidden" name="eHfd" value="{{$evTbl[$i]->hfser_id}}">
				<input type="submit" name="eSubBtn" value="Submit" hidden>
			</form>
			<div class="col-md-4">
				<div class="card text-white bg-info o-hidden h-100 dashboard-leave-menu">
	             <div class="card-body">
	               <div class="card-body-icon" style="opacity: 0.4;">
	                 <i class="fa fa-fw fa-clipboard-list"></i>
	               </div>
	               <div class="text-uppercase" style="font-size: 27px;text-decoration: underline;"><strong>{{$evTbl[$i]->hfser_desc}}</strong></div>
	               <div class="text-uppercase small">{{$evTbl[$i]->aptdesc}}</div>
	             </div>
	             <a class="card-footer text-white clearfix small z-1" onclick="document.getElementsByName('eSubBtn')[{{$i}}].click();" style="cursor: pointer;">
	               <span class="float-left text-uppercase">View Details</span>
	               <span class="float-right">
	                 <i class="fa fa-angle-right"></i>
	               </span>
	             </a>
	           	</div>
	        </div>
	        @endfor
		</div>
		@endfor @else
		<center><p>No form(s) applied yet</p></center>
		@endif @endisset

		@isset($eApTbl)
		<h2>Evaluation Details</h2><hr>
		@if(count($eApTbl) > 0)
		<div class="table-responsive">
			<table class="table">
				<thead>
					<tr>
						<th>Description</th>
						<th>Status</th>
						<th>Remarks</th>
					</tr>
				</thead>
				<tbody>
					@foreach($eApTbl AS $eApRow)
					<tr>
						<td style="width: 40%;">{{$eApRow->updesc}}</td>

						<?php $_icon = ""; $_status = ""; if($eApRow->app_id != NULL): if($eApRow->evaluation != NULL): if($eApRow->evaluation == '1'): $_icon = "fa-check-circle"; $_status = "Approved"; else: $_icon = "fa-times-circle"; $_status = "Denied"; endif; else: $_icon = "fa-spinner"; $_status = "Pending"; endif; else: $_icon = "fa-exclamation-circle"; $_status = "No file(s) uploaded"; endif; ?>

						<td style="width: 20%;"><i class="fa {{$_icon}}"> {{$_status}}</i></td>
						<td style="width: 40%;">{{$eApRow->remarks}}</td>
					</tr>
					@endforeach
				</tbody>
				<tfoot>
					<?php $_isRec = ""; $_isMsg = ""; $_date = ""; $_time = ""; if(count($eAfTbl) > 0) {if($eAfTbl[0]->isrecommended != NULL) {if($eAfTbl[0]->isrecommended == '1') {$_isRec = "badge-success"; $_isMsg= "Yes"; } else {$_isRec = "badge-danger"; $_isMsg= "No"; } } else {$_isRec = "badge-warning"; $_isMsg= "Pending"; } $_date = $eAfTbl[0]->recommendeddate; $_time = $eAfTbl[0]->recommendedtime; } else { } ?>
					<tr>
						<td>Recommended for Inspection: <label class="badge {{$_isRec}}">{{$_isMsg}}</label></td>
						<td colspan="2">Date/Time for Inspection: <strong>{{date("M jS, Y", strtotime($_date))}} at {{date("h:iA", strtotime($_time))}}</strong></td>
					</tr>
				</tfoot>
			</table>
		</div>
		@else 
		@endif
		@endisset
	</div>
</body>
@include('client.cmp.foot')
@endsection