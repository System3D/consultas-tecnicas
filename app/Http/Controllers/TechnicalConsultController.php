<?php namespace App\Http\Controllers;

use App\Contact;
use App\EmailMessage;
use App\Helpers\Alfred;
use App\TechnicalConsult;
use Illuminate\Http\Request;

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

		if ($request->ajax()) {
			return view('technical_consults.create-modal', compact('clients'));
		} else {
			return view('technical_consults.create', compact('clients'));
		}

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request) {

		$data = $request->all();
		$data['technical_consult']['owner_id'] = $request->user()->id;
		$data['technical_consult']['color'] = (new Alfred())->randomColor();

		// CRIA CONSULTA TÉCNICA
		$technical_consult = TechnicalConsult::create($data['technical_consult']);

		if (!$technical_consult) {
			$this->sys_notifications[] = array('type' => 'danger', 'message' => $validator->errors()->first());
			$request->session()->flash('sys_notifications', $this->sys_notifications);
			return back()->withInput($request->all());
		}

		$email_data = $data['email_message'];
		$email_data['to'] = Contact::find($data['technical_consult']['contact_id'])->email;
		$email_data['from'] = $request->user()->email;
		$email_data['subject'] = $data['technical_consult']['title'];
		$email_data['consulta_tecnica_id'] = $technical_consult->id;
		$email_data['owner_id'] = $request->user()->id;

		$email_data['body_html'] = $data['technical_consult']['description'];
		$email_data['body_text'] = strip_tags($data['technical_consult']['description']);

		// CRIA EMAIL MESSAGE
		$email_message = EmailMessage::create($email_data);

		if (!$email_message) {
			$this->sys_notifications[] = array('type' => 'danger', 'message' => $validator->errors()->first());
			$request->session()->flash('sys_notifications', $this->sys_notifications);
			return back()->withInput($request->all());
		}

		$this->sys_notifications[] = array('type' => 'success', 'message' => 'Nova consulta técnica registrada com sucesso!');
		$request->session()->flash('sys_notifications', $this->sys_notifications);
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
	public function destroy($id) {

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