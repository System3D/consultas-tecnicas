<div class="modal-content">

    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">{{ 'CT ' . str_pad($technical_consult->id, 3, "0", STR_PAD_LEFT) }} <strong>{!! $technical_consult->title !!}</strong></h4>
    </div>
    <div class="modal-body">

		<div class="list-group">

		@foreach ($technical_consult->emails as $email)

			<div href="#" class="list-group-item">
				<h4 class="list-group-item-heading">
					<div class="pull-right">
						{!! Form::open(array('url' => 'consultas_tecnicas/'.$technical_consult->id , 'method'  => 'delete' )) !!}
						<button class="btn btn-danger btn-xs" type="submit" onclick="return confirm('Excluir permanentemente esta consulta técnica e todas as conversas anexadas?');"><i class="fa fa-trash-o"></i> EXCLUIR</button>
						{!! Form::close() !!}
					</div>
					<?php echo html_entity_decode($email->subject); ?>
				</h4>
				<div class="btn-group">
					<a href="#" class="btn-xs btn-link"><i class="fa fa-calendar-o"></i> {{ date( 'd/m/Y', strtotime( $email->date )) }}</a>
					<a href="#" class="btn-xs btn-link"><i class="fa fa-clock-o"></i> {{ date( 'H:i', strtotime( $email->date )) }}</a>
					@if ($email->replies->count() > 0)
						<a href="#email_message_{{ current($email->replies->toArray())['id'] }}" class="btn-xs btn-link"><i class="fa fa-reply"></i> {{ $email->replies->count() }} respostas</a>
					@else
						<a class="btn-xs btn-link"><i class="fa fa-warning"></i> Sem resposta</a>
					@endif
					@if ($email->attachments->count() > 0)
						<a href="{{  url('/consultas_tecnicas/'.$technical_consult->id.'/'.$email->id.'/anexos')  }}" class="btn-xs btn-link" data-toggle="modal" data-target="#modal"><i class="fa fa-reply"></i> {{ $email->attachments->count() }} Anexos</a>
					@else
						<a href="#" class="btn-xs btn-link"><i class="fa fa-warning"></i> Sem anexos</a>
					@endif
					<a href="#" class="btn-xs btn-link"><i class="fa fa-circle" style="color:<?php echo $technical_consult->color ?>;"></i> <?php echo $technical_consult->color ?></a>
				</div>

				<br><br>

				<p class="list-group-item-text"><?php echo html_entity_decode($email->body_html); ?></p>
			</div>

		@endforeach

	</div>

    </div>
</div>