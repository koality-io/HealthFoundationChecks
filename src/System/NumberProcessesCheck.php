<?php

namespace Leankoala\HealthFoundationChecks\System;

use Leankoala\HealthFoundationBase\Check\Check;
use Leankoala\HealthFoundationChecks\MetricAwareResult;
use Leankoala\HealthFoundationBase\Check\Result;

class NumberProcessesCheck implements Check
{
    const IDENTIFIER = 'base:system:numberProcesses';

    private $processName;
    private $maxNumber;
    private $minNumber;

    public function init($processName, $maxNumber, $minNumber = 0)
    {
        $this->processName = $processName;
        $this->maxNumber = $maxNumber;
        $this->minNumber = $minNumber;
    }

    public function run()
    {
        $command = 'ps ax  | grep -a "' . $this->processName . '" | wc -l';

        exec($command, $output);

        $count = (int)$output[0] - 2;

        if ($count > $this->maxNumber) {
            $result = new MetricAwareResult(Result::STATUS_FAIL, 'Too many processes found "' . $this->processName . '" (current: ' . $count . ', expected < ' . $this->maxNumber . ').');
        } elseif ($count < $this->minNumber) {
            $result = new MetricAwareResult(Result::STATUS_FAIL, 'Too few processes found "' . $this->processName . '" (current: ' . $count . ' , expected > ' . $this->maxNumber . ').');
        } else {
            $result = new MetricAwareResult(Result::STATUS_PASS, 'Number of processes "' . $this->processName . '" was within limits. Current number is ' . $count . '.');
        }

        $result->setMetric($count, 'process');
        $result->setLimit($this->maxNumber);
        $result->setLimitType(MetricAwareResult::LIMIT_TYPE_MAX);
        $result->setObservedValuePrecision(0);

        return $result;
    }

    public function getIdentifier()
    {
        return self::IDENTIFIER . ':' . md5($this->processName);
    }
}
