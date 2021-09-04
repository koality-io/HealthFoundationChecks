<?php

namespace Leankoala\HealthFoundationChecks\Basic;

use Leankoala\HealthFoundationBase\Check\Check;
use Leankoala\HealthFoundationBase\Check\Result;

/**
 * Class StaticCheck
 *
 *
 * @author Nils Langner <nils.langner@leankoala.com>
 * created 2021-08-05
 */
class StaticCheck implements Check
{
    /**
     * @var string
     */
    private $identifier;

    /**
     * @var string
     */
    private $status;

    public function __construct($identifier, Result $result)
    {
        $this->identifier = $identifier;
        $this->result = $result;
    }

    public function run()
    {
        return $this->result;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }
}
