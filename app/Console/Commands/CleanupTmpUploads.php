<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupTmpUploads extends Command
{
    protected $signature = 'uploads:cleanup-tmp {--days=}';

    protected $description = 'Remove temporary uploaded files from order_files/tmp older than the specified days';

    public function handle(): int
    {
        $days = (int) ($this->option('days') ?: config('uploads.tmp_ttl_days', 3));
        if ($days < 0) {
            $days = 0;
        }

        $threshold = now()->subDays($days);

        $disk = Storage::disk('public');
        $baseDir = 'order_files/tmp';

        if (!$disk->exists($baseDir)) {
            $this->info("Directory '{$baseDir}' does not exist on 'public' disk. Nothing to clean.");
            return self::SUCCESS;
        }

        $files = $disk->allFiles($baseDir);
        $checked = 0;
        $deleted = 0;

        foreach ($files as $path) {
            $checked++;
            try {
                $lastModified = Carbon::createFromTimestamp($disk->lastModified($path));
                if ($lastModified->lessThanOrEqualTo($threshold)) {
                    if ($disk->delete($path)) {
                        $deleted++;
                    }
                }
            } catch (\Throwable $e) {
                \Log::warning('tmp cleanup: failed to process file', [
                    'file' => $path,
                    'message' => $e->getMessage(),
                ]);
            }
        }

        // Optionally remove empty subdirectories within tmp
        try {
            foreach ($disk->directories($baseDir) as $dir) {
                try {
                    if (count($disk->allFiles($dir)) === 0) {
                        $disk->deleteDirectory($dir);
                    }
                } catch (\Throwable $e) {
                    \Log::debug('tmp cleanup: failed to remove directory', [
                        'dir' => $dir,
                        'message' => $e->getMessage(),
                    ]);
                }
            }
        } catch (\Throwable $e) {
            // ignore
        }

        $this->info("Checked {$checked} files; deleted {$deleted}. Threshold: {$days} day(s).");

        return self::SUCCESS;
    }
}

