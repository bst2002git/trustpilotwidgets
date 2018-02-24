<?php

namespace spec\Pillbox\TrustpilotWidgets\Helper;

use Pillbox\TrustpilotWidgets\Helper\Data;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DataSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Data::class);
    }
}
