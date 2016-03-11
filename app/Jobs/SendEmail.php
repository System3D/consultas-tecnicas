<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Job implements SelfHandling {
	use InteractsWithQueue, SerializesModels;

	protected $email_data, $anexos, $request, $email_message, $technical_consult, $contatos;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($email_data, $anexos, $request, $email_message, $technical_consult, $contatos) {
		$this->email_data = $email_data;
		$this->anexos = $anexos;
		$this->request = $request;
		$this->email_message = $email_message;
		$this->technical_consult = $technical_consult;
		$this->contatos = $contatos;
	}

	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle(Mailer $mailer, Request $request) {

		foreach ($this->contatos as $contato) {
			$mailer->send('emails.message', ['email_data' => $this->email_data], function ($message) use ($request, $contato) {
				foreach ($this->anexos as $anexo) {
					$message->attach(storage_path('app/' . $request->user()->id . '/' . $this->email_message->id . '/' . $anexo->original_filename));
				}
				$message->subject('Consulta Técnica CT' . $this->technical_consult->id);
				$message->from($request->user()->email, 'Consultas Técnicas');
				$message->to($contato->email, $contato->name);
				if (!empty($this->email_data['bcc'])) {
					$message->bcc($this->email_data['bcc']);
				}
			});
		}
	}
}
