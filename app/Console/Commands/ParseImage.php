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

    // public function findDate($text)
    // {
    //     if (preg_match('/(\d+-\S+-20\d+)/', $text, $matches)) {
    //         print " --> date detected";
    //         $this->date = strtotime($matches[1]);
    //         $this->date_str = date('Y-m-d', strtotime($matches[1]));
    //     }
    // }

    // public function findProduct($text)
    // {
    //     static $previtems = [];
    //     static $qtys = [];
    //     if (preg_match('/(0300\d+) ([a-z() ]+)(\d+\.00)/i', $text, $matches)) {
    //         print " --> product detected $matches[1], $matches[2], = $matches[3]";
    //         $this->products[$matches[1]] = $matches[3];
    //         $this->findSku($matches[1], $matches[2]);
    //     } else if (preg_match('/(0300\d+) (.*)$/', $text, $matches)) {
    //         print " --> product detected $matches[1], $matches[2] no qty";
    //         $this->findSku($matches[1], $matches[2]);
    //         if (!empty($qtys)) {
    //             $qty = array_shift($qtys);
    //             print " --> get qty from stack $qty";
    //             $this->products[$matches[1]] = $qty;
    //         } else {
    //             $this->products[$matches[1]] = 0;
    //         }
    //         array_push($previtems, $matches[1]);
    //     } elseif (preg_match('/^(\d+\.00)/', $text, $matches)) {

    //         if (!empty($previtems)) {
    //             $previtem = array_shift($previtems);
    //             print " --> qty detected $matches[1] for $previtem";
    //             $this->products[$previtem] = $matches[1];
    //         } else {
    //             array_push($qtys, $matches[1]);
    //         }
    //     }
    // }

    // public function findSku($code, $name)
    // {
    //     if (strlen($code) != 8) {
    //         return;
    //     }

    //     static $skus = [];
    //     if (isset($skus[$code])) {
    //         return;
    //     }

    //     $sku = Sku::where('code', $code)->first();
    //     if (!$sku) {
    //         Sku::create(['code' => $code, 'name' => $name]);
    //     }
    //     $skus[$code] = $name;
    // }

    // public function dump()
    // {
    //     print $this->date_str . "\n";
    //     print_r($this->products);

    //     if ($sales = Sales::where('date', $this->date_str)->first()) {
    //         $sales->update($this->products);
    //         print "Updated\n";
    //     } else {
    //         $data = $this->products;
    //         $data['date'] = $this->date_str;
    //         Sales::create($data);
    //         print "Created\n";
    //     }
    // }
}
