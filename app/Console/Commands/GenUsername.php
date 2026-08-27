<?php

namespace App\Console\Commands;

use App\Models\Student;
use Illuminate\Console\Command;

class GenUsername extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:gen-username';

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
        $this->info('generate Username Started');
        $students = Student::whereNull('nisn')->get();
        foreach ($students as $student) {
            $student->update(['nisn' => random_int(1000000000, 9999999999)]);
        };

        $this->info('Generate Username Finished');
        return self::SUCCESS;
    }
}
