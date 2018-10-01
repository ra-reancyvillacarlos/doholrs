@extends('main')
@section('content')
@include('client.cmp.login')
<body>
	@include('client.cmp.nav')
	@include('client.cmp.__msg')
	<script type="text/javascript">
	@isset($cmpLoc)
		@isset($cmpLoc['bAds'])
		bAds = JSON.parse(("{{json_encode($cmpLoc['bAds'])}}").replace(/&quot;/g,'"'));
		@endisset
		@isset($cmpLoc['cAds'])
		cAds = JSON.parse(("{{json_encode($cmpLoc['cAds'])}}").replace(/&quot;/g,'"'));
		@endisset
		@isset($cmpLoc['pAds'])
		pAds = JSON.parse(("{{json_encode($cmpLoc['pAds'])}}").replace(/&quot;/g,'"'));
		@endisset
		@isset($cmpLoc['rAds'])
		rAds = JSON.parse(("{{json_encode($cmpLoc['rAds'])}}").replace(/&quot;/g,'"'));
		@endisset
	@endisset
	</script>
	<div class="container mt-5" style="min-height: 400px;">
		<div class="row">
			<div id="__steps" class="col-md-6 mt-5">
				<h1>DOH Licensing Process</h1><br>
				<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
				  {{-- <ol class="carousel-indicators">
				    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
				    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
				    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
				  </ol> --}}
				  <div class="carousel-inner">
				    <div class="carousel-item active">
						{{-- <div class="carousel-caption d-none d-md-block"></div> --}}
					    <h4><i class="fa fa-registered"></i>&nbsp;<strong>Step 1:</strong>&nbsp;Registration</h4>
					    <p>Sign-up for your health facility. Get your username and password.</p>
					    <h4><i class="fa fa-address-book"></i>&nbsp;<strong>Step 2:</strong>&nbsp;Apply</h4>
					    <p>Fill-in application form and submit requirements online.</p>
					    <h4><i class="fa fa-credit-card"></i>&nbsp;<strong>Step 3:</strong>&nbsp;Payment</h4>
					    <p>You need to pay for the evaluation and inspection process.</p>
				    </div>
				    <div class="carousel-item">
					    <h4><i class="fa fa-check"></i>&nbsp;<strong>Step 4:</strong>&nbsp;Evaluation</h4>
					    <p>DOH will evaluate your submitted documents and notify your schedule of inspection.</p>
					    <h4><i class="fa fa-search"></i>&nbsp;<strong>Step 5:</strong>&nbsp;Inspection</h4>
					    <p>DOH will conduct inspection and notify the status of your application.</p>
					    <h4><i class="fa fa-print"></i>&nbsp;<strong>Step 6:</strong>&nbsp;Issuance</h4>
					    <p>You can now print your application online.</p>
				    </div>
				  </div>
				  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
				    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
				    <span class="sr-only">Previous</span>
				  </a>
				  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
				    <span class="carousel-control-next-icon" aria-hidden="true"></span>
				    <span class="sr-only">Next</span>
				  </a>
				</div>
			</div>


			<div id="__register" class="col-md-6">
				<h1>Register</h1>
				<h5>Sign Up for free!</h5>
				<div class="progress">
				  	<div id="progress_id" class="progress-bar bg-success" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
				</div>
				<form id="reg_form" method="POST" action="{{asset('/')}}">
					{{csrf_field()}}					
					<div name="grp_id">
						<div class="row">
							<div class="col-md-12">
								<label>Facility Name:</label>
								<input class="form-control"  type="text" name="text2">
							</div>
						</div>
						<div class="row">
							<div class="col-md-8">
								<label>Facility Type:</label>
								{{-- <input class="form-control" list="dt0" name="text3"> --}}
								<select class="form-control" name="text3">
									<option value hidden disabled selected>Select Type</option>
									@isset($cmpLoc)
										@isset($cmpLoc['hAds'])
											@foreach($cmpLoc['hAds'] AS $hAds)
												<option value="{{$hAds->facid}}">{{$hAds->facname}}</option>
											@endforeach
										@endisset
									@endisset
								</select>
							</div>
							<div class="col-md-4">
								<label>Bed Capacity:</label>
								<input class="form-control" type="number" name="text4">
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label>Email Address:</label>
								<input class="form-control"  type="text" name="text6">
							</div>
						</div>
					</div>
					<div name="grp_id">
						<div class="row">
							<div class="col-md-6">
								<label>Region:</label>
								{{-- <input class="form-control" list="dt4" name="text16"> --}}
								<select class="form-control adUser" name="text16" onchange="chAdUser(1, ['provid', 'provname', 'rgnid'])">
									<option value hidden disabled selected>Select</option>
								</select>
							</div>
							<div class="col-md-6">
								<label>Province:</label>
								{{-- <input class="form-control" list="dt3" name="text13"> --}}
								<select class="form-control adUser" name="text13" onchange="chAdUser(2, ['cmid', 'cmname', 'provid'])">
									<option value hidden disabled selected>Select</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label>City/Municipality:</label>
								{{-- <input class="form-control" list="dt2" name="text12"> --}}
								<select class="form-control adUser" name="text12" onchange="chAdUser(3, ['brgyid', 'brgyname', 'cmid'])">
									<option value hidden disabled selected>Select</option>
								</select>
							</div>
							<div class="col-md-6">
								<label>Barangay:</label>
								{{-- <input class="form-control" list="dt1" name="text11"> --}}
								<select class="form-control adUser" name="text11">
									<option value hidden disabled selected>Select</option>
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-8">
								<label>Street Name:</label>
								<input class="form-control" type="text" name="text10">
							</div>
							<div class="col-md-4">
								<label>Zip Code:</label>
								<input class="form-control" type="text" name="text14">
							</div>
						</div>
					</div>
					<div name="grp_id">
						<div class="row">
							<div class="col-md-8">
								<label>Contact Person's Name:</label>
								<input class="form-control"  type="text" name="text7">
							</div>
							<div class="col-md-4">
								<label>Number:</label>
								<input class="form-control"  type="text" name="text8">
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label>Username:</label>
								<input class="form-control" type="text" name="text0">
							</div>
							<div class="col-md-6">
								<label>Password:</label>
								<input class="form-control" type="password" name="text1">
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<label>Authorized Signature:</label>
								<input class="form-control"  type="text" name="text5">
							</div>
						</div>
					</div>
					<div name="grp_id">
						<p>Are you sure you want to submit?</p>
					</div>
					<input class="form-control" type="hidden" name="text19" value="{{$_SERVER['REMOTE_ADDR']}}">
					<input class="form-control" type="hidden" name="text20" value="{{date('Y-m-d')}}">
					<input class="form-control" type="hidden" name="text21" value="{{date('h:i:s')}}">
					<input class="form-control" type="hidden" name="text31" value="{{Illuminate\Support\Str::random(40)}}">
				</form>
				<hr>
				<button id="btnprev" class="btn btn-sm btn-info" style="float: left;" onclick="nextGroup(-1)">Prev</button>
				<button id="btnnext" class="btn btn-sm btn-info" style="float: right;" onclick="nextGroup(1)">Next</button>
				<button id="btnproc" type="submit" class="btn btn-sm btn-success" style="float: right;">Yes</button>
			</div>
		</div>
	</div>
</body>
<script type="text/javascript">
	curName = "grp_id"; nextGroup(0);
	chAdUser(0, ['rgnid', 'rgn_desc']);
</script>
@include('client.cmp.foot')
@endsection