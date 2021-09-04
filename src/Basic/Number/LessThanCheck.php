<?php

namespace Leankoala\HealthFoundationChecks\Check\Basic\Number;

use Leankoala\HealthFoundationBase\Check\Check;
use Leankoala\HealthFoundationBase\Check\Result;

/**
 * Class LessThanCheck
 *
 * Checks if a given number is less than an expected value
 *
 * @package Leankoala\HealthFoundationChecks\Check\Basic\Number
 */
class LessThanCheck implements Check
{
    const IDENTIFIER = 'base:basic:number:lessThan';

    private $maxValue;
    private $currentValue;
    private $valueName = "";

    public function init($currentValue, $maxValue, $valueName)
    {
        $this->maxValue = $maxValue;
        $this->currentValue = $currentValue;
        $this->valueName = $valueName;
    }

    public function run()
    {
        if ($this->currentValue > $this->maxValue) {
            return new Result(Result::STATUS_FAIL, 'The given value ("' . $this->valueName . '") is ' . $this->currentValue . ' and too big, it must be less than ' . $this->maxValue . '.');
        } else {
            return new Result(Result::STATUS_PASS, 'The value ("' . $this->valueName . '") was ' . $this->currentValue . '. Maximum was < ' . $this->maxValue . '.');
        }
    }

    public function getIdentifier()
    {
        return self::IDENTIFIER . ':' . $this->valueName;
    }
}
