<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;

use App\ProjectDiscipline;
use App\Project;

class ProjectDisciplineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $project_id = null ) {
        if( $project_id != null ){
            $project = Project::find( $project_id );
        }else{
            $this->sys_notifications[] = array( 'type' => 'danger', 'message' => '<i class="fa fa-warning"></i> Proejto não informado!' );                
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );        
            return back()->withInput( $request->all() );
        }

        if( $request->ajax() )  return view('project_disciplines.create-modal', compact('project',$project));
        else                    return view('project_disciplines.create', compact('project',$project));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make( $request->all(), [
            'title'         => 'required',              
        ]);     

        if ($validator->fails()) {
                        
            $this->sys_notifications[] = array( 'type' => 'danger', 'message' => $validator->errors()->first() );   
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );
            return back()->withErrors($validator)->withInput( $request->all() );

        }

        $data = $request->all();        
        $data['owner_id']   = $request->user()->id;

        // Create a new Discipline for project
        $projectdiscipline = ProjectDiscipline::create( $data );

        if( $projectdiscipline ){
            $this->sys_notifications[] = array( 'type' => 'success', 'message' => 'Disciplina criada com sucesso!' );   
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );                
            return redirect( url('obras/'.$data['project_id'].'#disciplinas') )->withErrors($validator)->withInput( $request->all() );
        }else{
            $this->sys_notifications[] = array( 'type' => 'danger', 'message' => 'Erro! Não foi possível adicionar a nova etapa!' );
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );       
            return redirect( url('obras/'.$data['project_id'].'/disciplinas/create') )->withErrors($validator)->withInput( $request->all() );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit( Request $request, $project_id = null, $project_discipline_id = null )
    {
        $projectdiscipline = ProjectDiscipline::find( $project_discipline_id );
        
        if( $projectdiscipline ){                      
            if( $request->ajax() )
                return view('project_disciplines.edit-modal',  compact('projectdiscipline') );  
            else
                return view('project_disciplines.edit',  compact('projectdiscipline') );
        }else{
            $this->sys_notifications[] = array( 'type' => 'danger', 'message' => 'Disciplina do projeto não encontrada!' );
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );
        }

        return back()->withInput($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id ) {
        $validator = Validator::make( $request->all(), [
            'title'         => 'required',  
            'project_id'    => 'required|integer',  
        ]);     

        if ($validator->fails()) {
                        
            $this->sys_notifications[] = array( 'type' => 'danger', 'message' => $validator->errors()->first() );   
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );
            return back()->withErrors($validator)->withInput( $request->all() );

        }

        $data = $request->all();        
        $data['owner_id']   = $request->user()->id;

        // Update a new Project
        $ProjectDiscipline = ProjectDiscipline::find( $id );
        $ProjectDiscipline->update( $data );

        if( $ProjectDiscipline ){
            $this->sys_notifications[] = array( 'type' => 'success', 'message' => 'Alterações salvas com sucesso!' );                 
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );                
            return redirect( url('obras/'.$data['project_id'].'#disciplinas') )->withErrors($validator)->withInput( $request->all() );
        }else{
            $this->sys_notifications[] = array( 'type' => 'danger', 'message' => 'Erro! Não foi possível salvar as alterações da Disciplina!' );
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );       
            return redirect( url('obras/'.$data['project_id'].'/disciplinas/create') )->withErrors($validator)->withInput( $request->all() );
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $projectdiscipline = ProjectDiscipline::find($id);        
        if(!$projectdiscipline){
            return back()->withInput( $request->all() );
        }

        $project_id = $projectdiscipline->project_id;

        if( $projectdiscipline->destroy( $id ) ){
            $this->sys_notifications[] = array( 'type' => 'success', 'message' => '<strong><i class="fa fa-check"></i></strong> Disciplina excluída com sucesso!' );                   
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );        
            return redirect( '/obras/'.$project_id.'#disciplinas' );
        }else{
            $this->sys_notifications[] = array( 'type' => 'danger', 'message' => '<strong><i class="fa fa-warning"></i></strong> Não foi possível excluir a disciplina do projeto!' );                
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );        
            return back()->withInput( $request->all() );
        }
    }

}
