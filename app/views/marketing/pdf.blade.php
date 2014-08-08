<article class="instructor">
	<div class="row">
		<div class="col-md-4">
			<h5>Telephone: {{ $instructor['phone'] }}</h5>
			<h5>Mobile: {{ $instructor['mobile'] }}</h5>
		</div>
		<div class="col-md-8">
			<div class="row">
				<div class="col-md-3">
					<img src="http://placehold.it/200x200" alt="" />
					<h5>Average Rating</h5>
				</div>
				<div class="col-md-9">
					<h3 class="text-success">{{ $user['first_name'] }} {{ $user['last_name'] }}</h3>
					<hr />
					<h4>Bio:</h4>
					<p>{{ $instructor['bio'] }}</p>
					<div class="row">
						<div class="col-md-4">
							{{ $instructor['facebook'] }}
						</div>
						<div class="col-md-4">
							{{ $instructor['twitter'] }}
						</div>
						<div class="col-md-4">
							{{ $instructor['youtube'] }}
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</article>