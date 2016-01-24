<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\Access\Authorizable;

class User extends Model implements AuthenticatableContract,
AuthorizableContract,
CanResetPasswordContract {
	use Authenticatable, Authorizable, CanResetPassword;

	protected $table = 'users';
	public $timestamps = true;
	protected $fillable = array('name', 'username', 'email', 'password', 'register_ip');
	protected $visible = array('name', 'username', 'email', 'register_ip');

	/**
	 * Scope a query to only include popular users.
	 *
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	// public function scopePopular($query)
	// {
	//     return $query->where('locatario_id', '>', 100);
	// }

	public function clients() {
		return $this->hasMany('App\Client', 'owner_id');
	}

	public function contacts() {
		return $this->hasMany('App\Contact', 'owner_id');
	}

	public function tecnhical_consults() {
		return $this->hasMany('App\TechnicalConsult', 'owner_id');
	}

	public function projects() {
		return $this->hasMany('App\Project', 'owner_id');
	}

	public function files() {
		return $this->hasMany('App\FileEntry', 'owner_id');
	}

	public function storagePath() {
		if (is_dir(storage_path($this->id))) {
			return storage_path($this->id);
		} else {
			\Storage::makeDirectory($this->id);
			if (is_dir(storage_path($this->id))) {
				return storage_path($this->id);
			}
			return '/';
		}
	}

}