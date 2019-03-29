<?php
/**
 * Todo::it written fast, need complete robot test and write tests for all components(Export, Handler, Iterator, Source and State).
 */

use App\Services\Robot\Source\JsonSource;
use App\Services\Robot\Source\Source;
use App\Services\Robot\Robot;

class RobotTest extends TestCase
{
    private $robot;
    private $tests = ['test1', 'test2'];
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->robot = new Robot();
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRobot()
    {
        foreach ($this->tests as $test) {
            $testSource = file_get_contents(dirname(__FILE__).'/'.$test.'.json');
            $jsonSource = app(JsonSource::class);
            $jsonSource->setData($testSource);
            $jsonSource->isValid();
            $source = app(Source::class);
            $source->setSource($jsonSource);
            $this->robot->init($source);
            $result = $this->robot->launch();
            $expected = json_decode(file_get_contents(dirname(__FILE__) .'/'.$test.'_result.json'), true);
            $expectedVisited = $expected['visited'];
            array_map(function($visited) use ($expectedVisited){
                $this->assertTrue(in_array($visited, $expectedVisited));
            }, $result['visited']);
            $expectedCleaned = $expected['cleaned'];
            array_map(function($cleaned) use ($expectedCleaned){
                $this->assertTrue(in_array($cleaned, $expectedCleaned));
            }, $result['cleaned']);
            $this->assertEquals($result['final']['facing'], $expected['final']['facing']);
            $this->assertEquals($result['final']['X'], $expected['final']['X']);
            $this->assertEquals($result['final']['Y'], $expected['final']['Y']);
            $this->assertEquals($result['battery'], $expected['battery']);
        }
    }
}
