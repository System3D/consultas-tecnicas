<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailMessage extends Model {

	protected $table = 'email_messages';
	public $timestamps = true;
	protected $fillable = array('type', 'from', 'to', 'subject', 'body_text', 'body_html', 'headers', 'consulta_tecnica_id', 'email_message_id', 'status', 'rating', 'date');
	protected $visible = array('id', 'type', 'from', 'to', 'subject', 'body_text', 'body_html', 'headers', 'consulta_tecnica_id', 'email_message_id', 'status', 'rating', 'date');
	public $ratingclass;
	public $ratinglabel;

	public function tecnhical_consult() {
		return $this->belongsTo('App\TechnicalConsult', 'consulta_tecnica_id');
	}

	public function consulta_tecnica() {
		return $this->belongsTo('App\ConsultaTecnica', 'consulta_tecnica_id');
	}

	public function replies() {
		return $this->hasMany('App\EmailMessage');
	}

	public function attachments() {
		return $this->hasMany('App\FileEntry');
	}

}