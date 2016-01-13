<?php 

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
use App\User;
use App\Http\Controllers\Controller;



/*
	Authentication routes
 */

// Authentication routes...
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', 'Auth\AuthController@postLogin');
Route::get('logout', 'Auth\AuthController@getLogout');

// Registration routes...
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');

// Password reset link request routes...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');

// Password reset routes...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');



Route::group(['middleware' => 'auth'], function () {	
	
	Route::get('/', function () {
	    return view('dashboard');
	});
	
	// CLIENTES
	Route::resource('clientes', 'ClientController');
	Route::post('clientes/{client_id}/contatos/attach', 'ClientController@attachContact'); // send contact_id via POST
	Route::post('clientes/{client_id}/contatos/detach', 'ClientController@detachContact'); // send contact_id via POST

	// OBRAS
	Route::resource('obras', 'ProjectController');
	// ETAPAS
	Route::resource('obras/etapas', 'ProjectStageController');
	// DISCIPLINAS
	Route::resource('obras/disciplinas', 'ProjectDisciplineController');

	// OBRA X > ETAPAS / DISCIPLINAS / CONTATOS
	Route::resource('obras/{obra_id}/etapas', 'ProjectStageController');
	Route::resource('obras/{obra_id}/disciplinas', 'ProjectDisciplineController');
	Route::resource('obras/{obra_id}/contatos', 'ContactController');

	// OBRA X > CONTATO X (attach/detach)
	Route::post('obras/{obra_id}/contatos/attach', 'ProjectController@attachContact'); // send contact_id via POST
	Route::post('obras/{obra_id}/contatos/{contact_id}/detach', 'ProjectController@detachContact'); // send contact_id via POST

	// CONSULTAS TÉCNICAS / TIMELINE
	Route::get('consultas_tecnicas/timeline', 'TechnicalConsultController@timeline');
	Route::get('consultas_tecnicas/print', 'TechnicalConsultController@printTimeline');
	// Route::resource('consultas_tecnicas/status', 'TechnicalConsultStatusController');
	// Route::resource('consultas_tecnicas/tipos', 'TechnicalConsultTypeController');
	// CONSULTA TÉCNICA X > EMAILS
	Route::get('consultas_tecnicas/{consulta_tecnica_id}/emails', 'TechnicalConsultController@getEmails');
	// CONSULTAS TÉCNICAS
	Route::resource('consultas_tecnicas', 'TechnicalConsultController');

	
	// OBRA X > CONSULTAS TÉCNICAS
	Route::resource('obras/{obra_id}/etapas/{etapa_id}/consultas_tecnicas', 'TechnicalConsultController');
	Route::resource('obras/{obra_id}/etapas/{etapa_id}/consultas_tecnicas', 'TechnicalConsultController');
	
	Route::resource('users', 'UserController');
	Route::resource('contatos', 'ContactController');
	Route::resource('emailmessage', 'EmailMessageController');

	Route::group(['prefix' => 'clientes'], function () {
		Route::resource('/{client_id}/obras', 'ProjectController');
		Route::group(['prefix' => 'obras/{obra_id}'], function () {
			Route::resource('etapas', 'ProjectStageController');
		});

		Route::resource('/{client_id}/contatos', 'ContactController');
	});

	Route::group(['prefix' => 'obras'], function () {
		Route::resource('/{project_id}/consultas_tecnicas', 'TechnicalConsultController');
		Route::group(['prefix' => '/{project_id}/etapas'], function () {
			Route::resource('etapas', 'ProjectStageController');
			Route::group(['prefix' => '/{projectstage_id}'], function () {
				Route::resource('consultas_tecnicas', 'TechnicalConsultController');
			});
		});
	});

	Route::group(['prefix' => 'api'], function () {
			
		Route::get('/{resource_name?}/{resource_id?}/attach/{attached_resource_name?}/{attached_resource_id?}', 'ApiController@attach');	
		Route::get('/{resource_name?}/{resource_id?}/{resource_relationship?}/{related_resource_id?}/{related_related_resource?}', 'ApiController@index');	
		Route::post('/{resource_name?}/{resource_id?}/{resource_relationship?}/{related_resource_id?}/{related_related_resource?}', 'ApiController@store');	
		
	});

	// Upload files
	Route::post('upload', 'UploadController@upload');

	Route::get('arquivos', ['as' => 'files', 'uses' => 'FileEntryController@index']);
	Route::get('arquivos/{filename}', ['as' => 'filesrc', 'uses' => 'FileEntryController@view']);
	Route::get('arquivos/{filename}/download', ['as' => 'downloadfile', 'uses' => 'FileEntryController@download']);
	Route::post('arquivos/upload',['as' => 'addentry', 'uses' => 'FileEntryController@upload']);
	
	Route::delete('arquivos/{file_id}',['as' => 'deletefile', 'uses' => 'FileEntryController@delete']);
	
});