<?php

namespace App;

use App\User;
use Illuminate\Database\Eloquent\Model;

class FileEntry extends Model {

	protected $fillable = ['email_message_id', 'id', 'filename', 'mime', 'original_filename'];

	protected $visible = ['email_message_id', 'id', 'filename', 'mime', 'original_filename'];

	public function user() {
		return $this->belongsTo('App\User', 'owner_id');
	}

	public function emailmessage() {
		return $this->belongsTo('App\EmailMessage', 'email_message_id');
	}

	public function icon() {
		switch ($this->mime) {
		case 'image/jpeg':
			return 'file-image-o';
			break;

		case 'image/png':
			return 'file-image-o';
			break;

		case 'video/mp4':
			return 'file-video-o';
			break;

		case 'application/msword':
			return 'file-word-o';
			break;

		case 'application/vnd.ms-excel':
			return 'file-excel-o';
			break;

		case 'application/octet-stream':
			return 'file-zip-o';
			break;

		case 'application/pdf':
			return 'file-pdf-o';
			break;

		default:
			return 'file-o';
			break;
		}
		return $this->mime;
	}
}
