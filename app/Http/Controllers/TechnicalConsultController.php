<?php namespace App\Http\Controllers;

use App\Contact;
use App\EmailMessage;
use App\FileEntry;
use App\Helpers\Alfred;
use App\Http\Controllers\FileEntryController;
use App\TechnicalConsult;
use Illuminate\Http\Request;
use JavaScript;
use Mail;
use Validator;

class TechnicalConsultController extends Controller {

	private $sys_notifications = array();

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, $project_id = null, $project_stage_id = null) {

		if ($project_stage_id != null && $project_id != null) {
			$technical_consults = TechnicalConsult::orderBy($request->input('order', 'id'), $request->input('orderby', 'DESC'))
				->where('owner_id', $request->user()->id)
				->where('project_id', $project_id)
				->where('project_stage_id', $project_stage_id)
				->with('emails')
				->get();
		} else if ($project_id != null) {
			$technical_consults = TechnicalConsult::orderBy($request->input('order', 'id'), $request->input('orderby', 'DESC'))
				->where('owner_id', $request->user()->id)
				->where('project_id', $project_id)
				->with('emails')
				->get();
		} else {
			$technical_consults = TechnicalConsult::orderBy($request->input('order', 'id'), $request->input('orderby', 'DESC'))
				->where('owner_id', $request->user()->id)
				->with('emails')
				->get();
		}

		if ($request->ajax()) {
			return $technical_consults;
		} else {
			return view('technical_consults.index')->with('technical_consults', $technical_consults);
		}
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getEmails(Request $request, $id) {

		$consult = TechnicalConsult::find($id);
		$emails = $consult->emails;

		if ($request->ajax()) {
			return $emails;
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request) {

		$clients = $request->user()->clients; // all the clients

		$data = $request->all();

		JavaScript::put([
			'urlbase' => url('/'),
			'date' => '',
			'title' => '',
			'description' => '',
			'cliente_id' => @$data['cliente_id'],
			'contato_id' => @$data['contato_id'],
			'obra_id' => @$data['obra_id'],
			'obra_stage_id' => '',
			'obra_discipline_id' => '',
			'color' => '',
			'owner_id' => $request->user()->id,
		]);

		if ($request->ajax()) {
			return view('technical_consults.create-modal', compact('clients', 'data'));
		} else {
			return view('technical_consults.create', compact('clients', 'data'));
		}

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request, Validator $validator) {

		$data = $request->all();

		// dd($data);

		$data['technical_consult']['owner_id'] = $request->user()->id;
		$data['technical_consult']['color'] = (new Alfred())->randomColor();

		$data['email_message']['date'] = (empty($data['email_message']['date'])) ? date('Y-m-d') : $data['email_message']['date'];
		$data['email_message']['time'] = (empty($data['email_message']['time'])) ? date('H:i') : $data['email_message']['time'];

		// CRIA CONSULTA TÉCNICA
		if (isset($data['technical_consult_id']) && $data['technical_consult_id'] > 0) {
			$technical_consult = TechnicalConsult::find($data['technical_consult_id']);
		} else {
			$technical_consult = TechnicalConsult::create($data['technical_consult']);
		}

		if (!$technical_consult) {
			$this->sys_notifications[] = array('type' => 'danger', 'message' => 'Erro ao criar consulta técnica');
			$request->session()->flash('sys_notifications', $this->sys_notifications);
			return back()->withInput($request->all());
		}

		$email_data = $data['email_message'];
		$email_data['date'] = date('Y-m-d H:i:s', strtotime($email_data['date'] . ' ' . $email_data['time'] . ':00'));
		$contact = Contact::find($data['technical_consult']['contact_id']);
		$email_data['to'] = $contact->email;
		$email_data['toname'] = $contact->name;
		$email_data['from'] = $request->user()->email;
		$email_data['subject'] = $data['technical_consult']['title'];
		$email_data['consulta_tecnica_id'] = $technical_consult->id;
		$email_data['owner_id'] = $request->user()->id;

		$email_data['body_html'] = $data['technical_consult']['description'];
		$email_data['body_text'] = strip_tags($data['technical_consult']['description']);

		$email_data['email_message_id'] = ($data['email_message_id'] && !empty($data['email_message_id'])) ? $data['email_message_id'] : null;

		// CRIA EMAIL MESSAGE
		$email_message = EmailMessage::create($email_data);

		if (!$email_message) {
			$this->sys_notifications[] = array('type' => 'danger', 'message' => $validator->errors()->first());
			$request->session()->flash('sys_notifications', $this->sys_notifications);
			return back()->withInput($request->all());
		}

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

		// SEND MAIL
		if ($email_data['type'] == 1) {
			Mail::send('emails.message', ['email_data' => $email_data], function ($message) use ($email_data, $anexos, $request, $email_message, $technical_consult) {
				foreach ($anexos as $anexo) {
					$message->attach(storage_path('app/' . $request->user()->id . '/' . $email_message->id . '/' . $anexo->original_filename));
				}
				$message->from($email_data['from'], 'Consultas Técnicas');
				$message->to($email_data['to'], $email_data['toname'])->subject('Consulta Técnica CT0' . $technical_consult->id);
				$message->bcc('tonetlds@gmail.com', $email_data['toname'])->subject('Consulta Técnica CT0' . $technical_consult->id);
			});
		}

		$this->sys_notifications[] = array('type' => 'success', 'message' => 'Nova consulta técnica registrada com sucesso!');
		$request->session()->flash('sys_notifications', $this->sys_notifications);

		return redirect('obras/');
		return back()->withInput($request->all());
	}

	/**
	 * Display the specified resource.
	 *
	 * @param int     $id
	 * @return Response
	 */
	public function show(Request $request, $id) {

		$technical_consult = TechnicalConsult::find($id);

		if ($request->ajax()) {
			return view('technical_consults.show-modal', compact('technical_consult'));
		} else {
			return view('technical_consults.show', compact('technical_consult'));
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int     $id
	 * @return Response
	 */
	public function edit($id) {

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param int     $id
	 * @return Response
	 */
	public function update($id) {

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int     $id
	 * @return Response
	 */
	public function destroy(Request $request, $id) {
		$ct = TechnicalConsult::find($id);
		if (!$ct) {
			$sys_notifications[] = array('type' => 'danger', 'message' => '<strong><i class="fa fa-warning"></i></strong> Consulta Tecnica não encontrado!');
			$request->session()->flash('sys_notifications', $sys_notifications);
			return back()->withInput($request->all());
		}

		if ($ct->destroy($id)) {
			$sys_notifications[] = array('type' => 'success', 'message' => '<strong><i class="fa fa-check"></i></strong> Consulta Tecnica excluído com sucesso!');
		} else {
			$sys_notifications[] = array('type' => 'danger', 'message' => '<strong><i class="fa fa-warning"></i></strong> Não foi possível excluir a consulta técnica!');
		}

		$request->session()->flash('sys_notifications', $sys_notifications);

		$data = $request->all();
		$back_to = isset($data['back_to']) ? $data['back_to'] : '/obras/';
		return redirect($back_to)->withInput($request->all());
	}

	/**
	 * Display the technical consults in a timeline
	 *
	 * @param  Request $request [description]
	 * @return [type]           [description]
	 */
	public function timeline(Request $request) {

		$view = $request->input('view', 'timeline');
		switch ($view) {
		case 'chronologic':
			$email_messages = EmailMessage::where('owner_id', $request->user()->id)
				->where('');
			# code...
			break;

		default:
			$technical_consults = TechnicalConsult::where('owner_id', $request->user()->id)->get();
			# code...
			break;
		}

		if ($request->ajax()) {
			return view('technical_consults.timeline.timeline', compact('technical_consults'));
		} else {
			return view('technical_consults.index', compact('technical_consults'));
		}

	}

	public function printTimeline(Request $request) {
		$technical_consults = TechnicalConsult::all();
		return view('technical_consults.index-print', compact('technical_consults'));
	}

}