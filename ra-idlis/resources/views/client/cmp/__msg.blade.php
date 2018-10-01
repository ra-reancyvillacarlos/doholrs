@isset($errMsg)	
	<div id="__msg" style="position: absolute; right: 0; top: 0; left: 1; bottom: 1; margin-right: 10px; margin-top: 10px; max-width: 300px;" class="ml-auto">
		<div class="alert alert-{{$errAlt}} alert-dismissible fade show" role="alert">
		  <h4 class="alert-heading">Message</h4>
		  <hr>
		  <p class="mb-0">{{$errMsg}} @isset($locHref) <a href="{{asset('/resend_mail')}}/{{$locHref}}">here</a> @endisset</p>
		  <button onclick="setTimeout(function() { document.getElementById('__msg').style=''; }, 400)" type="button" class="close" data-dismiss="alert" aria-label="Close">
		    <span aria-hidden="true">&times;</span>
		  </button>
		</div>
	</div>
@endisset