<?php

namespace App\Console\Commands;

use App\Models\Student;
use Database\Seeders\MetaSettingSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class GeneratePasswordStudent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-password-student';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('generate password Started');
        $students = Student::where('status',true)->get();
        foreach($students as $student){
            $student->update([
                'password'=>Hash::make(
                    filled($student->notification_account)
                    ?$student->notification_account
                    :$student->nisn
                ),
                'is_default_password'=>true,
            ]);
        };

        $this->call(MetaSettingSeeder::class);
        $this->info('Generate Password Finished');
        return self::SUCCESS;
    }
}
