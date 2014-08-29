<article class="action">
	<a href="{{ $action->getSubjectLink() }}">{{ $action->getSubjectName() }}</a> {{ $action->getVerb() }} <a href="{{ $action->getObjectLink() }}">{{ $action->getObjectName() }}</a> - <em class="text-muted">{{ $action->created_at }}</em>
	@include($action->getTemplate(), [$action->getObjectType() => $action->getObject()])
</article>