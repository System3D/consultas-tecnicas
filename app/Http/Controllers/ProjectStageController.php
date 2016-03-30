<?php namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\ProjectStage;
use App\Project;
use App\Client;


class ProjectStageController extends Controller {

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
	public function create( Request $request, $project_id = null ) {
		if( $project_id != null ){
			$project = Project::find( $project_id );

			// Get all clients for dropdown
			$clients = Client::all();			

		}else{
			$this->sys_notifications[] = array( 'type' => 'danger', 'message' => '<i class="fa fa-warning"></i> Projeto não informado!' );                
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );        
            return back()->withInput( $request->all() );
		}
		
		if( $request->ajax() )
			return view('project_stages.create-modal',  compact('project', $project) );				
		else
			return view('project_stages.create',  compact('project', $project) );
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store( Request $request ) {

		$validator = Validator::make( $request->all(), [
            'title'     	=> 'required',  
            'project_id' 	=> 'required|integer',
        ]);     

        if ($validator->fails()) {
                        
            $this->sys_notifications[] = array( 'type' => 'danger', 'message' => $validator->errors()->first() );   
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );
            return back()->withErrors($validator)->withInput( $request->all() );

        }

        $data = $request->all();        
        $data['owner_id'] 	= $request->user()->id;


        // Create a new Project
        $projectstage = ProjectStage::create( $data );

        if( $projectstage ){
            $this->sys_notifications[] = array( 'type' => 'success', 'message' => 'Etapa adicionada com sucesso!' );                 
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );                
        	return redirect( url('obras/'.$data['project_id'].'#etapas') )->withErrors($validator)->withInput( $request->all() );
        }else{
            $this->sys_notifications[] = array( 'type' => 'danger', 'message' => 'Erro! Não foi possível adicionar a nova etapa!' );
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );       
        	return redirect( url('obras/'.$data['project_id'].'/etapas/create') )->withErrors($validator)->withInput( $request->all() );
        }

	}

	/**
	 * Display the specified resource.
	 *
	 * @param int     $id
	 * @return Response
	 */
	public function show( $obra_id = null, $id ) {
		$projectstage = ProjectStage::find( $id );
		// $projectstage = ProjectStage::all();
		return $projectstage;
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param int     $id
	 * @return Response
	 */
	public function edit( Request $request, $project_id = null, $project_stage_id = null ) {

		$projectstage = ProjectStage::find($project_stage_id);
        
        if( $projectstage ){                      
        	if( $request->ajax() )
				return view('project_stages.edit-modal',  compact('projectstage') );				
			else
				return view('project_stages.edit',  compact('projectstage') );            
        }else{
            $this->sys_notifications[] = array( 'type' => 'danger', 'message' => 'Etapa do Projeto não encontrada!' );   
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );        
        }

        return back()->withInput($request->all());
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param int     $id
	 * @return Response
	 */
	public function update( Request $request, $id ) {
		$validator = Validator::make( $request->all(), [
            'title'     	=> 'required',  
            'project_id' 	=> 'required|integer',  
        ]);     

        if ($validator->fails()) {
                        
            $this->sys_notifications[] = array( 'type' => 'danger', 'message' => $validator->errors()->first() );   
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );
            return back()->withErrors($validator)->withInput( $request->all() );

        }

        $data = $request->all();        
        $data['owner_id'] 	= $request->user()->id;

        // Update a new Project
        $projectstage = ProjectStage::find( $id );
        $projectstage->update( $data );

        if( $projectstage ){
            $this->sys_notifications[] = array( 'type' => 'success', 'message' => 'Alterações salvas com sucesso!' );                 
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );                
        	return redirect( url('obras/'.$data['project_id'].'#etapas') )->withErrors($validator)->withInput( $request->all() );
        }else{
            $this->sys_notifications[] = array( 'type' => 'danger', 'message' => 'Erro! Não foi possível salvar as alterações da etapa!' );
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );       
        	return redirect( url('obras/'.$data['project_id'].'/etapas/create') )->withErrors($validator)->withInput( $request->all() );
        }
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param int     $id
	 * @return Response
	 */
	public function destroy( Request $request, $id ) {		
		$projectstage = ProjectStage::find($id);  
		$project_id   = $projectstage->project_id;
        if(!$projectstage){
        	$this->sys_notifications[] = array( 'type' => 'danger', 'message' => '<i class="fa fa-warning"></i> Etapa não encontrada!' );                
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );        
            return back()->withInput( $request->all() );
        }

        if( $projectstage->destroy( $id ) ){
            $this->sys_notifications[] = array( 'type' => 'success', 'message' => '<strong><i class="fa fa-check"></i></strong> Etapa excluída com sucesso!' );                   
        }else{
            $this->sys_notifications[] = array( 'type' => 'danger', 'message' => '<strong><i class="fa fa-warning"></i></strong> Não foi possível excluir a etapa do projeto!' );                         
        }
        $request->session()->flash( 'sys_notifications', $this->sys_notifications );                    
        return redirect( url('obras/'.$project_id.'#etapas') )->withInput( $request->all() );  
	}

}