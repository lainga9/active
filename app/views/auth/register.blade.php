@section('title')
    Register
@stop

@section('content')
    
    <div class="row">
    	<div class="col-md-4">
    		<img style="margin-bottom: 30px;" src="http://placehold.it/600x300" alt="YouTube Video" />
    		<img style="margin-bottom: 30px;" src="http://placehold.it/600" alt="Slider" />
    	</div>
    	<div class="col-md-8">
    		<ul class="nav nav-tabs" role="tablist">
				<li class="active"><a href="#client" role="tab" data-toggle="tab">Register</a></li>
				<li><a href="#instructor" role="tab" data-toggle="tab">Instructor or Organisation</a></li>
			</ul>
			<div class="tab-content">
				<div class="tab-pane active" id="client">
					<!-- <p><strong>Scrap those monthly Gym Memberships!</strong><br />Sign up today and search thousands of classes and activities across the UK. <strong><em>It's free so Let's Get Active!</em></p> -->
					@include('users.client.create')
				</div>
				<div class="tab-pane" id="instructor">
					@include('users.instructor.create')
				</div>
			</div>
    	</div>
    </div>

    <hr />

    <div class="row">
    	<div class="col-sm-9">
    		<img src="http://placehold.it/900x120" alt="" />
    	</div>
    	<div class="col-sm-3">
    		<img src="http://placehold.it/300x130" alt="" />
    	</div>
    </div>

@stop