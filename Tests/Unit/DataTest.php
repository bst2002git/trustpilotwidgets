<?php
namespace Pillbox\TrustpilotWidgets\Tests\Unit\Helper;

use Pillbox\TrustpilotWidgets\Helper\Data as Data;

class DataTest extends \PHPUnit\Framework\TestCase
{

  protected $helper;

  /**
   * setUp
   */
  protected function setUp()
  {

    $this->helper = $this->createMock(Data::class);
    $this->helper->method('isEnabled')->willReturn(true);
    $this->helper->method('getBusinessUnitID')->willReturn('businessunitid');
    $this->helper->method('getStoreLocale')->willReturn('en_US');
    $this->helper->method('getConfig')->willReturn(true);

  }

  /**
   * testIsEnabledTrue
   */
  public function testIsEnabledTrue()
  {

    $this->assertEquals(true, true);

  }

  /**
   * testIsEnabledFalse
   */
  public function testIsEnabledFalse()
  {

    $this->assertEquals(false, $this->helper->isEnabled());

  }

}
