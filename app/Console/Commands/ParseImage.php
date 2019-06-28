<?php

namespace App\Console\Commands;

use Google\Cloud\Vision\VisionClient;
use Illuminate\Console\Command;

class ParseImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:parse {path}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        ini_set('memory_limit', '1024M');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public $keywords;

    public function handle()
    {
        foreach (glob($this->argument('path') . '/*.{png,jpeg,jpg}', GLOB_BRACE) as $p) {
            if (!file_exists($p . ".json")) {
                $this->keywords = ['labels' => [], 'web' => [], 'text' => []];
                print "Parsing $p\n";
                $this->parsefile($p);
            }
        }
    }

    public function parsefile($f)
    {
        //
        $client = new VisionClient();
        $image = $client->image(fopen($f, 'r'), ['labels', 'web', 'text']);
        $response = $client->annotate($image);

        try {
            foreach ($response->labels() as $label) {
                try {
                    $this->keywords['labels'][] = $label->description();
                } catch (\Throwable $th) {
                    // print_r($th);
                }
            }
        } catch (\Throwable $e) {
            print("labels error");
        }

        try {
            foreach ($response->web()->entities() as $web) {
                try {
                    $this->keywords['web'][] = $web->description();
                } catch (\Throwable $th) {
                    // print_r($th);

                }
            }
        } catch (\Throwable $e) {
            print("web error");
        }

        try {
            $skip = true;
            foreach ($response->text() as $text) {
                if ($skip) {
                    $skip = false;
                    continue;
                }

                try {
                    $this->keywords['text'][] = $text->description();
                } catch (\Throwable $th) {
                    // print_r($th);
                }
            }
        } catch (\Throwable $e) {
            print("text error");
        }

        file_put_contents($f . '.json', json_encode($this->keywords));
    }

}
