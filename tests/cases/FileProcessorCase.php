<?php
namespace Msc;

class Test_FileProcessorCase extends \PHPUnit_Framework_TestCase
{
    public function testGenericProcess() {
        $checker = new Checker(new HttpClientCurl());
        $out = '/tmp/msc_file_processor.csv';
        $task = new FileTask(realpath(__DIR__ . '/../data/list.csv'), $out);
        $processor = new FileProcessor($task, $checker);
        $processor->process();
        $lines = file(FileTask::outizeFilename($out));
        $this->assertCount(4, $lines);
    }
}