<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\FileEntry;
 
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Response;

class FileEntryController extends Controller
{
    /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index( Request $request )
	{
		// $files = FileEntry::where('owner_id', $request->user()->id)->get();
		$files = $request->user()->files;

		return view('arquivos.index', compact('files'));
	}

	/*
		Uplaod the files
	*/
	public function upload( Request $request ) {
 		
		$files = $request->file('file');

        if( !empty($files) ){
            foreach ($files as $file) {
				$extension 	= $file->getClientOriginalExtension();

				$entry = FileEntry::where('original_filename', '=', $file->getClientOriginalName())->get();
				if( $entry->count() ){
					$sys_notifications[] = array( 'type' => 'warning', 'message' => 'Já existe um arquivo com este nome!' );		   		
				   	$request->session()->flash( 'sys_notifications', $sys_notifications );	   	
					return back()->withInput($request->all());
				}

                // Storage::put( $file->getClientOriginalName(), file_get_contents($file) );
				Storage::put( $request->user()->id.'/'.$file->getClientOriginalName(), File::get($file));

				$entry 			= new FileEntry();
				$entry->mime 	= $file->getClientMimeType();
				$entry->original_filename = $file->getClientOriginalName();				
				$entry->filename = $file->getFilename().'.'.$extension;

				$entry->owner_id = $request->user()->id;
		 
				$entry->save();
				
            }

			$sys_notifications[] = array( 'type' => 'success', 'message' => count( $files ) . ' arquivos enviados com sucesso!' );
			$request->session()->flash( 'sys_notifications', $sys_notifications );	   	
        }
		
		return back()->withInput($request->all());;
		
	}

	public function view( Request $request, $filename ){
	
		$entry = FileEntry::where('filename', '=', $filename)->firstOrFail();
		$file = Storage::get($request->user()->id.'/'.$entry->original_filename);
 
		return (new Response($file, 200))
              ->header('Content-Type', $entry->mime);
	}

	public function download( Request $request, $original_filename ){
	
		$entry = FileEntry::where('original_filename', '=', $original_filename)->firstOrFail();
		if( Storage::has( $request->user()->id.'/'.$entry->original_filename ) ){
			
			$file = Storage::get( $request->user()->id.'/'.$entry->original_filename );

			return (new Response($file, 200))
					->header('Content-Description','File Transfer')
					// ->header('Content-Type:','application/octet-stream')
					->header('Content-Type', $entry->mime)
					->header('Content-Disposition', 'attachment; filename=' . $entry->original_filename)
					->header('Content-Transfer-Encoding', 'binary')
					->header('Connection', 'Keep-Alive')
					->header('Expires', 0)
					->header('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
					->header('Pragma', 'public')
					->header('Content-Length', $entry->size);
	              // ->header('Content-Type', $entry->mime);
		}

		$sys_notifications[] = array( 'type' => 'danger', 'message' => 'O arquivo não existe!' );		   		
	   	$request->session()->flash( 'sys_notifications', $sys_notifications );	   	
		return back()->withInput($request->all());

	}



    /**
     * Remove the specified resource from storage.
     *
     * @param int     $id
     * @return Response
     */
    public function delete( Request $request, $id ) {
        $file = FileEntry::where( 'id', $id )
        				 ->where( 'owner_id', $request->user()->id )
        				 ->first();        

        if(!$file){
        	$sys_notifications[] = array( 'type' => 'danger', 'message' => 'O arquivo não existe!' );
	   		$request->session()->flash( 'sys_notifications', $sys_notifications );
            return back()->withInput( $request->all() );
        }

        if( $file->destroy( $id ) ){

        	// Delete the file
        	Storage::delete( $request->user()->id.'/'.$file->original_filename );

            $this->sys_notifications[] = array( 'type' => 'success', 'message' => '<strong><i class="fa fa-check"></i></strong> Arquivo excluído com sucesso!' );                   
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );        
            
            return back()->withInput( $request->all() );

        }else{
            $this->sys_notifications[] = array( 'type' => 'danger', 'message' => '<strong><i class="fa fa-warning"></i></strong> Não foi possível excluir o arquivo!' );
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );        
            return back()->withInput( $request->all() );
        }
    }

}
