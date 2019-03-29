<?php

namespace App\Http\Controllers;

use App\Services\Robot\Source\JsonSource;
use App\Services\Robot\Source\Source;
use Illuminate\Http\Request;
use Illuminate\Validation\Validator;
use App\Services\Robot\Robot;

class RobotController extends Controller
{
    private $robot;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Robot $robot)
    {
        $this->robot = $robot;
    }

    public function index()
    {
        return response()->json(['message'=>'For use robot service, please use post request with data param with json format']);
    }

    public function run(Request $request)
    {
        if (is_string($request->get('data')) && is_array(json_decode($request->get('data'), true)) ? true : false) {
            $jsonSource = app(JsonSource::class);
            $jsonSource->setData($request->get('data'));
            $jsonSource->isValid();
            $source = app(Source::class);
            $source->setSource($jsonSource);
            $this->robot->init($source);
            return response()->json($this->robot->launch());
        }
        abort(400, 'Please provide json format or check data is correct');
    }

    //todo::Need add also file(Abstract source) accepting feature
}
