<?php

namespace App;

use App\Project;
use App\ProjectStage;
use Illuminate\Database\Eloquent\Model;

class ConsultaTecnica extends Model {

	protected $table = 'consultas_tecnicas';
	public $timestamps = true;
	protected $fillable = array('date', 'title', 'description', 'cliente_id', 'contact_id', 'project_id', 'project_stage_id', 'project_discipline_id', 'color', 'owner_id');
	protected $visible = array('id', 'date', 'title', 'description', 'cliente_id', 'contact_id', 'project_id', 'project_stage_id', 'project_discipline_id', 'color', 'owner_id');

	public function cliente() {
		return $this->belongsTo('App\Client', 'cliente_id');
	}

	public function emails() {
		return $this->hasMany('App\EmailMessage', 'consulta_tecnica_id');
	}

	public function project() {
		return $this->belongsTo('App\Project', 'project_id');
	}

	public function projectstage() {
		return $this->belongsTo('App\ProjectStage', 'project_stage_id');
	}

	public function projectdiscipline() {
		return $this->belongsTo('App\ProjectDiscipline', 'project_discipline_id');
	}

}