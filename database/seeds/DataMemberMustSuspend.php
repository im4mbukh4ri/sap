<?php

use Illuminate\Database\Seeder;

class DataMemberMustSuspend extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $members = \App\DataMember::all();

        foreach ($members as $member) {
            $user = \App\User::where('username', '=', $member->username)->first();
            if ($user) {
                $user->actived = 0;
                $user->save();

                $oauthClientSecrets = $user->client_secrets;
                foreach ($oauthClientSecrets as $oauthClientSecret) {
                    \App\OauthSession::where('client_id', '=', $oauthClientSecret->client_id)->delete();
                }
                $member->is_confirm = 1;
                $member->save();
            }
        }
    }
}
