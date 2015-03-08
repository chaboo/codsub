<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model {

	/**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['first_name', 'last_name', 'email', 'verification_token'];

  public function name() {
    return $this->first_name . " " . $this->last_name;
  }
}
