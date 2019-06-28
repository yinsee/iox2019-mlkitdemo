<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(Request $request)
    {
        $files = glob(public_path() . '/iox2019/*.{png,jpeg,jpg}', GLOB_BRACE);
        $search = $request->input('search', '');
        if ($search) {
            $files = $this->filter($files, $search);
        }

        array_walk($files, function (&$a) {
            $a = basename($a);
        });
        return view('home', compact('search', 'files'));
    }

    public function image(Request $request, $id)
    {

        $json = json_decode(file_get_contents(public_path() . '/iox2019/' . $id . '.json'));
        return view('image', compact('json', 'id'));
    }

    private function filter($files, $keyword)
    {
        $ret = [];
        foreach ($files as $f) {
            $data = json_decode(file_get_contents($f . ".json"));
            if (!is_object($data)) {
                var_dump($data);
                print($f . ".json is not object");
                continue;
            }
            if ($this->found($keyword, $data->labels) || $this->found($keyword, $data->web) || $this->found($keyword, $data->text)) {
                $ret[] = $f;
            }
        }
        return $ret;

    }

    private function found($keyword, $array)
    {
        foreach ($array as $a) {
            if (stristr($a, $keyword)) {
                return true;
            }

        }
        return false;
    }
}
