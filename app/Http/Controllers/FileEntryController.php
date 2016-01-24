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
	public function upload( Request $request, $redir = true, $email_message_id = null ) {
 		
		$files = $request->file('file');


        if( !empty($files) ){
        	$uploaded = 0;
        	$filesuploadedids = array();
            foreach ($files as $file) {
				$extension 	= $file->getClientOriginalExtension();

				if( $email_message_id != null ){									 	
					Storage::put( $request->user()->id.'/'.$email_message_id.'/'.$file->getClientOriginalName(), File::get($file));
				}else{	              
					Storage::put( $request->user()->id.'/'.$file->getClientOriginalName(), File::get($file));
				}
				
				$entry 						= new FileEntry();
				$entry->mime 				= $file->getClientMimeType();
				$entry->original_filename 	= $file->getClientOriginalName();				
				$entry->filename 			= $file->getFilename().'.'.$extension;
				$entry->owner_id 			= $request->user()->id;
				$entry->save();

				$filesuploadedids[] 		= $entry->id;

				$uploaded++;
            }

            if( (count( $files ) - $uploaded ) != 0 ){
            	$erroruploadmsg = count( $files ) - $uploaded .' arquivos não enviados!';
            }else{
            	$erroruploadmsg = '';
            }

			$sys_notifications[] = array( 'type' => 'success', 'message' => $uploaded. ' arquivos enviados com sucesso! '.$erroruploadmsg );
			$request->session()->flash( 'sys_notifications', $sys_notifications );	   	
        }
		
		if( $redir == true ){			
			return back()->withInput($request->all());
		}else{					
			return array('uploaded'=>$uploaded, 'error'=>count( $files ) - $uploaded, 'ids' => $filesuploadedids);
		}
		
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
        	if( Storage::exists( $request->user()->id.'/'.$file->original_filename ) ){
        		Storage::delete( $request->user()->id.'/'.$file->original_filename );
        	}

            $this->sys_notifications[] = array( 'type' => 'success', 'message' => '<strong><i class="fa fa-check"></i></strong> Arquivo excluído com sucesso!' );                   
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );        
            
            return back()->withInput( $request->all() );

        }else{
            $this->sys_notifications[] = array( 'type' => 'danger', 'message' => '<strong><i class="fa fa-warning"></i></strong> Não foi possível excluir o arquivo!' );
            $request->session()->flash( 'sys_notifications', $this->sys_notifications );        
            return back()->withInput( $request->all() );
        }
    }



    public function add(Request $request) {
 
		$file = $request->file('filefield');
		$extension = $file->getClientOriginalExtension();
		Storage::disk('local')->put($file->getFilename().'.'.$extension,  File::get($file));
		$entry = new Fileentry();
		$entry->mime = $file->getClientMimeType();
		$entry->original_filename = $file->getClientOriginalName();
		$entry->filename = $file->getFilename().'.'.$extension;
 
		$entry->save();
 
		return redirect('fileentry');
		
	}

}
