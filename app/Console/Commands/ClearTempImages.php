<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ClearTempImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:clear-temp-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $tempPath = public_path('uploads/temp');
        $files = File::files($tempPath);
        $now = Carbon::now();
        $deletedFiles = 0;

        $this->info('Checking files in: ' . $tempPath);

        foreach ($files as $file) {
            $lastModified = Carbon::createFromTimestamp(File::lastModified($file));
            $this->info('File: ' . $file->getFilename() . ' - Last Modified: ' . $lastModified);
            if ($lastModified->diffInHours($now) >= 1) {
                File::delete($file);
                $this->info('Deleted: ' . $file->getFilename());
                $deletedFiles++;
            }
        }

        if ($deletedFiles === 0) {
            $this->info('No files to delete.');
        }

        return 0;
    }
}
