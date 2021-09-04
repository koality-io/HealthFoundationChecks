<?php

namespace Leankoala\HealthFoundationChecks\Check\Device;

use Leankoala\HealthFoundationBase\Check\Check;
use Leankoala\HealthFoundationChecks\Check\MetricAwareResult;
use Leankoala\HealthFoundationBase\Check\Result;

class SpaceUsedCheck implements Check
{
    const IDENTIFIER = 'base:device:spaceUsed';

    private $maxUsageInPercent = 95;

    private $directory = '/';

    public function init($maxUsageInPercent, $directory = '/')
    {
        $this->maxUsageInPercent = $maxUsageInPercent;
        $this->directory = $directory;
    }

    /**
     * Checks if the space left on device is sufficient
     *
     * @return Result
     */
    public function run()
    {
        $free = disk_free_space($this->directory);
        $total = disk_total_space($this->directory);

        $usage = 100 - round(($free / $total) * 100);

        if ($usage > $this->maxUsageInPercent) {
            $result = new MetricAwareResult(Result::STATUS_FAIL, 'No space left on device. ' . $usage . '% used (' . $this->directory . ').');
        } else {
            $result = new MetricAwareResult(Result::STATUS_PASS, 'Enough space left on device. ' . $usage . '% used (' . $this->directory . ').');
        }

        $result->setMetric($usage / 100, 'percent', MetricAwareResult::METRIC_TYPE_PERCENT);
        $result->setLimit($this->maxUsageInPercent / 100);
        $result->setLimitType(MetricAwareResult::LIMIT_TYPE_MAX);
        $result->setObservedValuePrecision(2);

        return $result;
    }

    public function getIdentifier()
    {
        return self::IDENTIFIER;
    }
}
