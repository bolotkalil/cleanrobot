<?php
/**
 * Created by PhpStorm.
 * User: bolotkalil
 * Date: 9/18/18
 * Time: 9:39 AM
 */

namespace App\Console\Commands;

use App\Services\Robot\Robot;
use App\Services\Robot\Export\Export;
use App\Services\Robot\Export\JsonExport;
use App\Services\Robot\Source\JsonSource;
use App\Services\Robot\Source\Source;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class RobotCommand extends Command {

    private $robot;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Robot $robot)
    {
        parent::__construct();
        $this->robot = $robot;
    }
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'robot';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Launch CleanRobot console command";

//    public function fire()
//    {
//        $option = $this->option('source');
//
//        $this->info('This a command :'.$option);
//    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->argument('source')) {
            $this->error('Please provide source');
            return;
        }
        $fileExt = pathinfo($this->argument('source'), PATHINFO_EXTENSION);
        $sourceClassName = 'App\\Services\\Robot\\Source\\'.ucfirst($fileExt).'Source';
        if (!class_exists($sourceClassName)) {
            $this->error('Apologize but this '.$fileExt.' format file does not support');
            return;
        }
        $abstractSource = app($sourceClassName);
        $abstractSource->setData(file_get_contents($this->argument('source')));
        $abstractSource->isValid();
        $source = app(Source::class);
        $source->setSource($abstractSource);
        $this->robot->init($source);
        $response = $this->robot->launch();
        if ($response) {
            $fileExt = pathinfo($this->argument('export'), PATHINFO_EXTENSION);
            $exportClassName = 'App\\Services\\Robot\\Export\\'.ucfirst($fileExt).'Export';
            if (!class_exists($exportClassName)) {
                $this->error('Apologize but this '.$fileExt.' format file does not support for export');
                return;
            }
            $abstractExport = app($exportClassName);
            $abstractExport->setData($response);
            $export = app(Export::class);
            $export->setExport($abstractExport);
            if (file_put_contents($this->argument('export'), $export->getExport()->exportData())) {
                $this->info("Result exported on " . $this->argument('export'));
            } else {
                $this->error('Cannot export data to file, please check permissions');
            }

            return;
        }
        $this->error('Something went wrong');
    }

    protected function getArguments()
    {
        return [
            ['source', InputArgument::OPTIONAL, 'An source argument.'],
            ['export', InputArgument::OPTIONAL, 'An export argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('source', null, InputOption::VALUE_OPTIONAL, 'The source option to get instructions.'),
            array('export', null, InputOption::VALUE_OPTIONAL, 'The file name for export result.'),
        );
    }
}