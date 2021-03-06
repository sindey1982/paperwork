<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {
	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	protected $fillable = array('username', 'password', 'firstname', 'lastname', 'is_admin', 'remember_token');

	public function setPasswordAttribute($pass) {
		$this->attributes['password'] = Hash::make($pass);
	}

	public function notebooks() {
		return $this->belongsToMany('Notebook')->withTimestamps();
	}

	public function notes() {
		return $this->belongsToMany('Note')->withTimestamps();
	}

	public function shortcuts() {
		return $this->hasMany('Shortcut');
	}

	public function languages() {
		return $this->belongsToMany('Language');
	}
	
    public function isAdmin() {
    	return $this->is_admin;
    }
    
    public function getReminderEmail() {
        return $this->username;
    }
}
