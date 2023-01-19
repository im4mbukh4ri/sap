<?php

return [

	/*
		    |--------------------------------------------------------------------------
		    | Third Party Services
		    |--------------------------------------------------------------------------
		    |
		    | This file is for storing the credentials for third party services such
		    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
		    | default location for this type of information, allowing packages
		    | to have a conventional place to find your various credentials.
		    |
	*/

	'mailgun' => [
		'domain' => env('MAILGUN_DOMAIN'),
		'secret' => env('MAILGUN_SECRET'),
	],

	'ses' => [
		'key' => env('SES_KEY'),
		'secret' => env('SES_SECRET'),
		'region' => 'us-east-1',
	],

	'sparkpost' => [
		'secret' => env('SPARKPOST_SECRET'),
	],

	'stripe' => [
		'model' => App\User::class,
		'key' => env('STRIPE_KEY'),
		'secret' => env('STRIPE_SECRET'),
	],
	'facebook' => [
		'client_id' => '1910630742590715',
		'client_secret' => '96bfe2440edcd3101318a022759ede32',
		'redirect' => 'http://sip.dev/callback',
	],
	'google' => [
		'client_id' => '833012154932-uako1trovva6jm425ont30qcahgppl4e.apps.googleusercontent.com',
		'client_secret' => 'XxCdDvzwpMJJq7PS22DX0Mec',
		'redirect' => 'http://localhost:8000/callback/google',
	],

];
