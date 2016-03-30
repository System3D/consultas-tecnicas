<?php

namespace App\Http\Controllers;

use App\ConsultaTecnica;
use App\Contact as Contato;
use App\EmailMessage;
use App\FileEntry;
use App\Helpers\Alfred;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmail;
use App\Project as Obra;
use Illuminate\Http\Request;
use Validator;

class ConsultasTecnicasController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index(Request $request) {
		dd($request->all());
		$consultastecnicas = ConsultaTecnica::all();
		return $consultastecnicas;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create(Request $request) {
		
		$data = $request->all();
		$data['tipo'] = (isset($data['tipo'])) ? $data['tipo'] : 'envio';

		if (!isset($data['project_id'])) {return 'Informe a obra';}
		$obra = Obra::find($data['project_id']);
		if (!$obra) {return "Projeto não encontrado";}

		//if (!isset($data['etapa'])) {return 'Informe a etapa';}
		$etapa = $obra->stages->find(@$data['project_stage_id']);
		$etapa = ($etapa) ? $etapa : '';

		$disciplina = $obra->disciplines->find(@$data['disciplina']);

		if (count(@$obra->contacts) == 0) {
			$this->sys_notifications[] = array('type' => 'warning', 'message' => 'Nenhum contato vinculado ao projeto!<br/>Você precisa vincular ao menos um contato ao projeto para poder criar uma Consulta Técnica.');
			$request->session()->flash('sys_notifications', $this->sys_notifications);
			return back();
		}

		$inputdata = array();
		foreach ( $obra->contacts as $contato) {
			$inputdata['contatos'][$contato->id] = $contato->name . ' - ' . $contato->company;
		}

		$inputdata['etapas'] = $obra->stages->lists('title', 'id');
		$inputdata['disciplinas'] = $obra->disciplines->lists('title', 'id');
		$inputdata['email_message_id'] = @$data['email_message_id'];	




		switch ($data['tipo']) {
		case 'evento':						
			$inputdata['title'] = (count($obra->consultas_tecnicas))?$obra->consultas_tecnicas->first()->nextFormattedCod("CT #"):"CT #001";
			return view('consultas_tecnicas.criar-evento', compact('inputdata', 'obra', 'etapa', 'disciplina'));
			break;

		case 'retorno':


			$consultatecnica = ConsultaTecnica::find(@$data['consulta_tecnica_id']);

			if (!$consultatecnica) {
				$this->sys_notifications[] = array('type' => 'danger', 'message' => 'Erro ao adicionar consulta técnica');
				//$request->session()->flash('sys_notifications', $this->sys_notifications);
				return back()->withFlash('sys_notifications', $this->sys_notifications);
			}
			$inputdata['assunto'] = $consultatecnica->emails->first()->subject;			
			$inputdata['title'] = (count($obra->consultas_tecnicas))?$obra->consultas_tecnicas->first()->nextFormattedCod("CT #"):"CT #001";
			$inputdata['anexos'] = $consultatecnica->emails->first()->attachments;
			return view('consultas_tecnicas.criar-retorno', compact('inputdata', 'obra', 'etapa', 'disciplina', 'consultatecnica'));
			break;

		default:
			$inputdata['title'] = (count($obra->consultas_tecnicas))?$obra->consultas_tecnicas->first()->nextFormattedCod("CT #"):"CT #001";
			
			return view('consultas_tecnicas.criar-envio', compact('inputdata', 'obra', 'etapa', 'disciplina'));
			break;
		}

		$consultastecnicas = ConsultaTecnica::all();		
		return $consultastecnicas;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, Validator $validator) {

		$data = $request->all();
		if (!isset($data['email_message']['project_id'])) {return 'Informe a obra';}
		
		$obra = Obra::find( @$data['email_message']['project_id'] );
		$data['technical_consult']['cod'] = $obra->consultas_tecnicas->max('cod') + 1;

		switch (@$data['email_message']['type']) {
		case 0:
			// CRIA ACONTECIMENTO
			$technical_consult = ConsultaTecnica::create($data['technical_consult']);
			// CRIA EMAIL MESSAGE
			$email_message = new EmailMessage;

			break;

		case 2:
			// REGISTRAR RETORNO
			$technical_consult = ConsultaTecnica::find($data['technical_consult']['id']);
			// CRIA EMAIL MESSAGE
			$email_message = new EmailMessage;
			$email_message->email_message_id = $data['email_message']['email_message_id'];

			break;

		default:
			// CRIA CONSULTA TÉCNICA
			$technical_consult = new ConsultaTecnica;
			$technical_consult->owner_id = $request->user()->id;
			$technical_consult->color = (new Alfred())->randomColor();
			$technical_consult->project_id = @$data['technical_consult']['project_id'];
			$technical_consult->project_stage_id = @$data['technical_consult']['project_stage_id'];
			$technical_consult->project_discipline_id = @$data['technical_consult']['project_discipline_id'];
			$technical_consult->title = @$data['technical_consult']['title'];
			$technical_consult->cod = $data['technical_consult']['cod'];			

			$technical_consult->save();

			// CRIA EMAIL MESSAGE
			$email_message = new EmailMessage;
			break;
		}


		if(isset($data['email_message']['date'])){
			$date = str_replace('/', '-', $data['email_message']['date']);
		}else{
			$date = date('Y-m-d');			
		}
		$data['email_message']['date'] = (empty($data['email_message']['date'])) ? date('Y-m-d') :  date('Y-m-d', strtotime($date ) );
		$data['email_message']['time'] = (empty($data['email_message']['time'])) ? date('H:i') : $data['email_message']['time'];
		$email_message->date = date('Y-m-d H:i:s', strtotime($data['email_message']['date'] . ' ' . $data['email_message']['time']));

		// DADOS PARA O CORPO DO EMAIL
		$email_data = $data['email_message'];
		$email_data['obra'] = $technical_consult->project->title;
		$email_data['subject'] = $technical_consult->title;
		$email_data['consulta_tecnica_id'] = $technical_consult->formattedCod('CT #');
		$email_data['etapa'] = ($technical_consult->projectstage) ? $technical_consult->projectstage->title : '';
		$email_data['disciplina'] = ($technical_consult->projectdiscipline) ? $technical_consult->projectdiscipline->title : '';
		$email_data['body_html'] = $email_data['description'];

		// dd($email_data);

		$contatos = array();
		$email_data_to['contato_emails'] = array();

		$email_message->type = (null !== @$email_data['type']) ? $email_data['type'] : 1;

		if (null == @$email_data['to']) {
			$email_data['to'] = EmailMessage::find($email_message->email_message_id)->to;
			$email_data['to'] = explode(',', @$email_data['to']);
		}
		foreach ($email_data['to'] as $contato_id) {
			$contato = Contato::find($contato_id);
			if (null !== $contato) {
				$contatos[] = $contato;
				$email_data_to['contato_emails'][] = $contato->email;
			}
		}

		$email_message->to = implode(',', $email_data_to['contato_emails']);
		$email_message->from = $request->user()->email;
		$email_message->subject = $email_data['subject'];
		$email_message->consulta_tecnica_id = $technical_consult->id;
		$email_message->owner_id = $request->user()->id;
		$email_message->body_html = $email_data['description'];
		$email_message->rating = @$email_data['rating'];

		$email_message->private = (null === @$email_data['private'])?false:true;
		

		// SALVA EMAIL MESSAGE
		$email_message->save();

		if (!$technical_consult) {
			$this->sys_notifications[] = array('type' => 'danger', 'message' => 'Erro ao adicionar consulta técnica');
			$request->session()->flash('sys_notifications', $this->sys_notifications);
			return back()->withInput($request->all());
		}

		if (!$email_message) {
			$this->sys_notifications[] = array('type' => 'danger', 'message' => $validator->errors()->first());
			$request->session()->flash('sys_notifications', $this->sys_notifications);
			return back()->withInput($request->all());
		}

		// ENVIAR EMAIL
		if ($email_message->type == 1 && "on" == @$data['sendnow']) {

			// ATTACH FILES
			$files = $request->file('file');
			if ($files[0] != null) {
				$filesupload = (new FileEntryController())->upload($request, false, $email_message->id);
				if ($filesupload['uploaded'] > 0) {
					// $this->sys_notifications[] = array('type' => 'success', 'message' => $filesupload['uploaded'] . ' arquivos anexados');
				}
			}

			$anexos = array();
			if (!empty($filesupload['ids'])) {
				foreach ($filesupload['ids'] as $key => $fileid) {
					$entry = FileEntry::find($fileid);
					$entry->email_message_id = $email_message->id;
					$entry->save();
					$anexos[] = $entry;
				}
			}

			// SEND MAIL TO ME
			if (null !== @$data['sendtome']) {
				$email_data['bcc'] = $request->user()->email;
			}

			// PROCESS THE JOB
			 $this->dispatch(new SendEmail($email_data, $anexos, $request, $email_message, $technical_consult, $contatos));
			
			// return view('emails.message', compact('email_data', 'anexos', 'request', 'email_message', 'technical_consult', 'contatos'));

			$this->sys_notifications[] = array('type' => 'success', 'message' => 'E-mail enviado!');

		}

		$this->sys_notifications[] = array('type' => 'success', 'message' => 'Consulta Técnica registrada com sucesso!');
		$request->session()->flash('sys_notifications', $this->sys_notifications);

		return redirect('obras/' . $technical_consult->project_id);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show(Request $request, $id) {
		$technical_consult = ConsultaTecnica::find($id);

		if ($request->ajax()) {
			return view('consultas_tecnicas.exibir-modal', compact('technical_consult'));
		} else {
			return view('consultas_tecnicas.exibir', compact('technical_consult'));
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id) {
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id) {
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id) {
		//
	}

	/**
	 * Display the technical consults in a timeline
	 *
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function timeline(Request $request) {

		$technical_consults = TechnicalConsult::where('owner_id', $request->user()->id)->reverse()->get();

		dd($technical_consults);

		if ($request->ajax()) {
			return view('consultas_tecnicas.timeline.timeline', compact('technical_consults'));
		} else {
			return view('consultas_tecnicas.index', compact('technical_consults'));
		}

	}

	public function printTimeline(Request $request) {
		$technical_consults = TechnicalConsult::all();
		return view('consultas_tecnicas.index-print', compact('technical_consults'));
	}
}
