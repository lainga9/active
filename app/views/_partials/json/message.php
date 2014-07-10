{{#each messages}}
	<article class="message">
		<p><strong>{{this.sender.first_name}} {{this.sender.last_name}}</strong></p>
		<p>{{this.content}}</p>
	</article>

	<hr />

	{{#each this.children}}
		<article class="message">
			<p><strong>{{this.sender.first_name}} {{this.sender.last_name}}</strong></p>
			<p>{{this.content}}</p>
		</article>		
	{{/each}}

	<h4>Reply</h4>
	<form method="POST" data-thread="{{this.id}}" action="<?= URL::route('messages.send') ?>" class="message-reply" data-id="{{this.recipient.id}}">
		<textarea name="content" class="form-control"></textarea>
		<button type="submit" class="btn btn-success">Reply</button>
	</form>
{{/each}}