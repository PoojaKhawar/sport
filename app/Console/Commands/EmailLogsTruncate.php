<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin\EmailLog;

class EmailLogsTruncate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emailLogs:truncate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command is used to delete entries from the `activities` table by truncating it, effectively clearing out unnecessary data.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        EmailLog::truncate();

        return Command::SUCCESS;
    }
}
