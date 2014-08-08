{{#each activities}}
	<article class="activity activity-excerpt">
		<div class="row">
			<div class="col-sm-3">
				<img src="http://placehold.it/150x150" alt="Avatar" />
			</div>
			<div class="col-sm-9">
				<h4><a href="{{this.routes.showActivity}}">{{this.name}}</a></h4>
				<h5>Suitable for: <strong>{{this.level}}</strong></h5>
				<div class="row">
					<div class="col-md-6">
						<p>{{this.description}}</p>
					</div>
					<div class="col-md-6">
						{{{this.views.bookActivity}}}
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-12">
				<p>Time: {{this.time_from}} - {{this.time_until}} Date: {{this.date}} Address: {{this.street_address}}</p>
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