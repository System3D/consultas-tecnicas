<?php

namespace App;

use App\Project;
use App\ProjectStage;
use Illuminate\Database\Eloquent\Model;

class ConsultaTecnica extends Model {

	protected $table = 'consultas_tecnicas';
	public $timestamps = true;
	protected $fillable = array('date', 'title', 'description', 'cliente_id', 'contact_id', 'project_id', 'project_stage_id', 'project_discipline_id', 'color', 'owner_id', 'cod');
	protected $visible = array('id', 'date', 'title', 'description', 'cliente_id', 'contact_id', 'project_id', 'project_stage_id', 'project_discipline_id', 'color', 'owner_id', 'cod');

	public function formattedCod($signal = '#', $lenght = 3)
	{
		if( $this->cod > 0 ){
			$cod = $signal.str_pad($this->cod, $lenght, "0", STR_PAD_LEFT );
		}else if( $this->obra->consultas_tecnicas->max('cod') > 0 ){
			$cod = $signal.str_pad( $this->obra->consultas_tecnicas->max('cod'), $lenght, "0", STR_PAD_LEFT );
		}else{
			$cod = $signal.str_pad( 0, $lenght, "0", STR_PAD_LEFT );
		}
		return $cod;
	}


	public function nextFormattedCod($signal = '#', $lenght = 3)
	{
		if( $this->obra->consultas_tecnicas->max('cod') > 0 ){
			$cod = $signal.str_pad( ($this->obra->consultas_tecnicas->max('cod') + 1), $lenght, "0", STR_PAD_LEFT );
		}else{
			$cod = $signal.str_pad( 1, $lenght, "0", STR_PAD_LEFT );
		}
		return $cod;
	}


	public function cliente() {
		return $this->belongsTo('App\Client', 'cliente_id');
	}

	public function emails() {
		return $this->hasMany('App\EmailMessage', 'consulta_tecnica_id');
	}

	public function project() {
		return $this->belongsTo('App\Project', 'project_id');
	}

	public function obra() {
		return $this->belongsTo('App\Project', 'project_id');
	}

	public function projectstage() {
		return $this->belongsTo('App\ProjectStage', 'project_stage_id');
	}

	public function projectdiscipline() {
		return $this->belongsTo('App\ProjectDiscipline', 'project_discipline_id');
	}
}