<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\Project;

class ProjectDiscipline extends Model
{
	protected $table = 'disciplinas'; //project_disciplines
	public $timestamps = true;
	protected $fillable = array('id', 'title', 'description', 'project_id', 'owner_id');
	protected $visible = array('id', 'title', 'description', 'project_id', 'owner_id');

	public function project()
	{
		return $this->belongsTo( 'App\Project' );
	}

}
