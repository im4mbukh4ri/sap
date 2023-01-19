<?php

use Illuminate\Database\Seeder;

class ReleaseUserFromLock extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $logs = \App\UserLog::where('log', '=', 'User freeze by incorrect pin')->take(100)->get();
        foreach ($logs as $log) {
            \Illuminate\Support\Facades\DB::beginTransaction();
            try {
                $user = $log->user;
                $user->actived = 1;
                $user->suspended = 0;
                $user->save();
                \App\UserLog::create(['user_id' => $log->user_id, 'log' => 'Success release from freeze by incorect PIN']);
                $log->delete();
            } catch (\Exception $e) {
                \Illuminate\Support\Facades\DB::rollback();
            }
            \Illuminate\Support\Facades\DB::commit();
        }
    }
}
