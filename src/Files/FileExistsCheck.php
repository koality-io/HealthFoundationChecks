<?php

namespace Leankoala\HealthFoundationChecks\Files;

use Leankoala\HealthFoundationBase\Check\Check;
use Leankoala\HealthFoundationBase\Check\Result;


/**
 * Class FileExistsCheck
 *
 * This class checks if a given file exists
 *
 * @package Leankoala\HealthFoundationChecks\Files
 */
class FileExistsCheck implements Check
{
    const IDENTIFIER = 'base:files:fileExists';

    private $filename;

    public function run()
    {
        if (file_exists($this->filename)) {
            return new Result(Result::STATUS_PASS, 'The file "' . $this->filename . '" exists.');
        }else{
            return new Result(Result::STATUS_FAIL, 'The file "' . $this->filename . '" does not exist.');
        }
    }

    /**
     * @param $filename
     */
    public function init($filename)
    {
        $this->filename = $filename;
    }

    public function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}
