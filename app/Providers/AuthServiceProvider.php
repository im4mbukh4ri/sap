<?php

namespace App\Providers;

//use function foo\func;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {
	/**
	 * The policy mappings for the application.
	 *
	 * @var array
	 */
	protected $policies = [
		'App\Model' => 'App\Policies\ModelPolicy',
	];

	/**
	 * Register any application authentication / authorization services.
	 *
	 * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
	 * @return void
	 */
	public function boot(GateContract $gate) {
		$this->registerPolicies($gate);
		$gate->define('admin-access', function ($user) {
			return $user->role == 'admin';
		});
		$gate->define('acc-access', function ($user) {
			return $user->role == 'acc';
		});
		$gate->define('basic-access', function ($user) {
			return $user->role == 'basic';
		});
		$gate->define('advance-access', function ($user) {
			return $user->role == 'advance';
		});
		$gate->define('pro-access', function ($user) {
			return $user->role == 'pro';
		});
		$gate->define('free-access', function ($user) {
			return $user->role == 'free';
		});
		$gate->define('1', function ($user) {
			return $user->actived == '1';
		});
		$gate->define('0', function ($user) {
			return $user->actived == '0';
		});
		$gate->define('1-access', function ($user) {
			return $user->upline == '1';
		});
		$gate->define('0-access', function ($user) {
			return $user->upline != '1';
		});
		$gate->define('1-suspend', function ($user) {
			return $user->suspended == '1';
		});
		$gate->define('0-suspend', function ($user) {
			return $user->suspended == '0';
		});
	}
}
