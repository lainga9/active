@if(Session::has('status') || Session::has('error') || Session::has('success'))

	<div class="row">
		<div class="col-md-12">
			
			@if(Session::has('error'))
				
				<div class="alert alert-danger">{{ Session::get('error')}}</div>

      		@endif

      		@if(Session::has('status'))
				
				<div class="alert alert-info">{{ Session::get('status')}}</div>

      		@endif

      		@if(Session::has('success'))
				
				<div class="alert alert-success">{{ Session::get('success')}}</div>

      		@endif
			
		</div>
	</div>

@endif