<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {

	protected $table = 'contatos';
	public $timestamps = true;
	protected $fillable = array('id', 'email', 'name', 'company', 'position', 'address', 'phones', 'phones2', 'phones3', 'skype', 'notes', 'owner_id', 'client_id');
	protected $visible = array('id', 'email', 'name', 'company', 'position', 'address', 'phones', 'phones2', 'phones3', 'skype', 'notes', 'owner_id', 'client_id');

	public function owner()
	{
		return $this->belongsTo('\User');
	}

	public function client()
	{
		return $this->belongsTo('App\Client');
	}

	public function projects()
	{
		return $this->belongsToMany('\Project', 'contato_obra', 'contato_id', 'obra_id');
		// return $this->belongsToMany('\Project');
	}

	public function emails()
	{
		return $this->hasMany('\EmailMessage', 'to', 'from');
	}

}