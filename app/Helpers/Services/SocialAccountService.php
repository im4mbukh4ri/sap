<?php
namespace App\Helpers\Services;

use App\SocialAccount;
use App\User;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAccountService {
	public function getUserForFacebook(ProviderUser $providerUser) {
		//return dd($providerUser->getEmail());

		$account = SocialAccount::whereProvider('facebook')
			->whereProviderUserId($providerUser->getId())
			->first();
		if ($account) {
			return $account->user;
		}
		$user = User::whereEmail($providerUser->getEmail())->first();
		if ($user) {
			$user->socialAccount()->create([
				'provider_user_id' => $providerUser->getId(),
				'provider' => 'facebook',
			]);
			return $user;
		}
		$user = User::find(1);
		return $user;
	}
	public function getUserForGoogle(ProviderUser $providerUser) {
		return dd($providerUser);
		$account = SocialAccount::whereProvider('google')
			->whereProviderUserId($providerUser->getId())
			->first();
		if ($account) {
			return $account->user;
		}
		$user = User::whereEmail($providerUser->getEmail())->first();
		if ($user) {
			$user->socialAccount()->create([
				'provider_user_id' => $providerUser->getId(),
				'provider' => 'google',
			]);
			return $user;
		}
		$user = User::find(1);
		return $user;
	}
}