<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FileCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'image:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear event inamges in week';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->delete_older_than(storage_path()."/events",3600*24*7);
        // return 0;
    }

    public function delete_older_than($dir, $max_age) {
        $list = array();

        $limit = time() - $max_age;

        $dir = realpath($dir);

        if (!is_dir($dir)) {
            return;
        }

        $dh = opendir($dir);
        if ($dh === false) {
            return;
        }

        while (($file = readdir($dh)) !== false) {
            $file = $dir . '/' . $file;
            if (!is_file($file)) {
                continue;
            }
            if (filemtime($file) < $limit) {
                $list[] = $file;
                unlink($file);
            }
        }
        closedir($dh);
        return $list;
    }
}
