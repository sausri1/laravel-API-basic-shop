<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class adminstatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = "app:adminstatus {id} {status}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Change admin status for user";

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $id = $this->argument("id");
        $status = $this->argument("status");
        $user = User::find($id);

        if (!$user) {
            $this->error("user not found");
            return;
        }
        if ($user->is_admin && $status) {
            $this->error("admin already");
            return;
        }
        if (!$user->is_admin && !$status) {
            $this->error("client already");
            return;
        }
        DB::table('users')->where('id', $id)->update(['is_admin'=>$status]);
        $this->line(("status changed for " . $user->fio));
    }
}
