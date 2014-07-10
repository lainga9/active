{{#each activities}}
	<article class="activity activity-excerpt">
		<div class="row">
			<div class="col-sm-3">
				<img src="http://placehold.it/150x150" alt="Avatar" />
			</div>
			<div class="col-sm-9">
				<h4><a href="{{this.routes.showActivity}}">{{this.name}}</a></h4>
				<h5>Suitable for: <strong>{{this.level_id}}</strong></h5>
				<div class="row">
					<div class="col-md-6">
						<p>{{this.description}}</p>
					</div>
					<div class="col-md-6">
						{{#if this.attending}}	
							<button class="btn btn success btn-lg" disabled>Attending!</button>
						{{else}}
							<form method="POST" action="{{this.routes.book}}">
								<input type="submit" class="btn btn-success btn-lg" value="Book Class" />
							</form>
						{{/if}}
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<p>Time: {{this.time}} Date: {{this.date}} Address: {{this.street_address}}</p>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<p class="pull-right">
					Tweet Share on Facebook
				</p>
				<p class="pull-left">
					{{#if this.favourite}}
						{{{this.views.removeFavourite}}}
					{{else}}
						{{{this.views.addFavourite}}}
					{{/if}}
					<a href="{{this.routes.showUser}}">
						{{this.user.first_name}}
						{{this.user.last_name}}
					</a>
				</p>
			</div>
		</div>
	</article>
	<hr />
{{/each}}