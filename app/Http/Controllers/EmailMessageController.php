<?php namespace App\Http\Controllers;

use App\EmailMessage;
use Illuminate\Http\Request;

class EmailMessageController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index() {

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create() {

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store() {

	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id) {

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id) {

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id) {

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request, $id) {
		$email = EmailMessage::find($id);
		if (!$email) {
			$sys_notifications[] = array('type' => 'danger', 'message' => '<strong><i class="fa fa-warning"></i></strong> Email não encontrado!');
			$request->session()->flash('sys_notifications', $sys_notifications);
			return back()->withInput($request->all());
		}

		if ($email->destroy($id)) {
			$sys_notifications[] = array('type' => 'success', 'message' => '<strong><i class="fa fa-check"></i></strong> Email excluído com sucesso!');
		} else {
			$sys_notifications[] = array('type' => 'danger', 'message' => '<strong><i class="fa fa-warning"></i></strong> Não foi possível excluir o email!');
		}

		$request->session()->flash('sys_notifications', $sys_notifications);

		// $data = $request->all();
		// $back_to = isset($data['back_to']) ? $data['back_to'] : '/obras/';
		// return redirect($back_to)->withInput($request->all());
		return back();
	}

	public function anexos(Request $request, $technical_consult_id = null, $email_message_id = null) {

		$email = EmailMessage::find($email_message_id);

		if ($email) {
			return view('arquivos.table')->with('files', $email->attachments);
		} else {
			return null;
		}

	}

}