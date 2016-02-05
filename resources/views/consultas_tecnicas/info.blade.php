<ul class="list-group">
	@if (null !== @$obra)
		<li class="list-group-item"><strong>OBRA:</strong> {{ $obra->title }}</li>
	@endif
	@if (null !== @$etapa)
		<li class="list-group-item"><strong>ETAPA:</strong> {{ $etapa->title }}</li>
	@endif
	@if (null !== @$disciplina)
		<li class="list-group-item"><strong>DISCIPLINA:</strong> {{ $disciplina->title }}</li>
	@endif
	<li class="list-group-item">Item 2</li>
	<li class="list-group-item">Item 3</li>
</ul>