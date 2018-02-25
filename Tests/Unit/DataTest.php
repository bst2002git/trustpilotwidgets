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

    // helper_success stores positive (successful) results
    $this->helper = $this->createMock(Data::class);
    /*$this->helper->method('isEnabled')->willReturn(true);
    $this->helper->method('getBusinessUnitID')->willReturn('businessunitid');
    $this->helper->method('getStoreLocale')->willReturn('en_US');
    $this->helper->method('getConfig')->willReturn(true);*/

  }

  /**
   * testIsEnabledTrue
   */
  public function testIsEnabled()
  {
    // ensure the getConfig method returns the result
    $this->helper->method('getConfig')->willReturn(true);
    $this->helper->method('isEnabled')->willReturn($this->helper->getConfig(true));
    $this->assertEquals(true, $this->helper->isEnabled());

  }

  /**
   * testIsEnabledFalse
   */
  public function testIsEnabledFalse()
  {
    // ensure the getConfig method returns the result
    $this->helper->method('getConfig')->willReturn(false);
    $this->helper->method('isEnabled')->willReturn($this->helper->getConfig(false));
    $this->assertEquals(false, $this->helper->isEnabled());

  }

}
