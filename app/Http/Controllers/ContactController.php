<?php

namespace App\Http\Controllers;
use App\Contact;
use App\Project;
use Illuminate\Http\Request;
use Validator;

class ContactController extends Controller {

	private $sys_notifications = array();
	/**
	 * Display a listing of contacts
	 *
	 * @return Response
	 */
	public function index(Request $request, $obra_id = null) {
		if ($obra_id != null) {
			$project = Project::find($obra_id)->get();
			dd($project);
			$contacts = $project->contacts;
		} else {
			$contacts = Contact::orderBy($request->input('orderby', 'email'), $request->input('order', 'ASC'))->paginate($request->input('paginate', 50));
		}
		return view('contacts.index')->with('contacts', $contacts);
	}

	/**
	 * Show the form for creating a new contact
	 *
	 * @return Response
	 */
	public function create(Request $request, $client_id = null) {
		if ($request->ajax()) {
			return view('contacts.create-modal', compact('client_id', 'request'));
		} else {
			return view('contacts.create', compact('client_id', 'request'));
		}

	}

	/**
	 * Store a newly created contact in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request) {

		$data = $request->all();

		$validator = Validator::make($data, [
			'email' => 'required|unique:contatos|max:255|email',
		]);

		if ($validator->fails()) {

			$sys_notifications[] = array('type' => 'danger', 'message' => $validator->errors()->first());

			$request->session()->flash('sys_notifications', $sys_notifications);

			return back()->withInput($data);
		}

		$contact = Contact::create($data);

		if ($contact) {
			$sys_notifications[] = array('type' => 'success', 'message' => 'Contato salvo com sucesso!');
		} else {
			$sys_notifications[] = array('type' => 'danger', 'message' => 'Não foi possível salvar o contato!');
		}

		$request->session()->flash('sys_notifications', $sys_notifications);

		return back()->withErrors($validator)->withInput($data);
	}

	/**
	 * Display the specified contact.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(Request $request, $id) {
		$contact = Contact::find($id);

		if ($contact) {
			if ($request->ajax()) {
				return view('contacts.edit-modal', compact('contact'));
			} else {
				return view('contacts.edit', compact('contact'));
			}
		}

		$this->sys_notifications[] = array('type' => 'warning', 'message' => 'Erro! Contato não encontrados.');
		$request->session()->flash('sys_notifications', $this->sys_notifications);
		return back()->withInput($request->all());

	}

	/**
	 * Show the form for editing the specified contact.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit(Request $request, $id) {
		$contact = Contact::find($id);

		if ($contact) {
			if ($request->ajax()) {
				return view('contacts.edit-modal', compact('contact'));
			} else {
				return view('contacts.edit', compact('contact'));
			}

		} else {
			$sys_notifications[] = array('type' => 'danger', 'message' => 'Contato não encontrado!');
		}

		$request->session()->flash('sys_notifications', $sys_notifications);

		return back()->withInput($request->all());
	}

	/**
	 * Update the specified contact in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id, Request $request) {
		$validator = Validator::make($request->all(), [
			'email' => 'required|max:255|email',
		]);

		if ($validator->fails()) {
			$sys_notifications[] = array('type' => 'danger', 'message' => $validator->errors()->first());
			$request->session()->flash('sys_notifications', $sys_notifications);
			return back()->withInput($request->all());
		}

		// UPDATE RESOURCE
		$contact = Contact::find($id);
		$contact->update($request->all());

		$sys_notifications[] = array('type' => 'success', 'message' => 'Contato atualizado com sucesso!');
		$request->session()->flash('sys_notifications', $sys_notifications);

		return redirect('/contatos/' . $contact->id);
	}

	/**
	 * Remove the specified contact from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Request $request, $client_id = null, $id) {

		$contact = Contact::find($id);
		if (!$contact) {
			$sys_notifications[] = array('type' => 'danger', 'message' => '<strong><i class="fa fa-warning"></i></strong> Contato não encontrado!');
			$request->session()->flash('sys_notifications', $sys_notifications);
			return back()->withInput($request->all());
		}

		if ($contact->destroy($id)) {
			$sys_notifications[] = array('type' => 'success', 'message' => '<strong><i class="fa fa-check"></i></strong> Contato excluído com sucesso!');
		} else {
			$sys_notifications[] = array('type' => 'danger', 'message' => '<strong><i class="fa fa-warning"></i></strong> Não foi possível excluir o contato!');
		}

		$request->session()->flash('sys_notifications', $sys_notifications);

		$data = $request->all();
		$back_to = isset($data['back_to']) ? $data['back_to'] : '/contatos/' . $contato->id;
		return redirect($back_to)->withInput($request->all());
	}

}