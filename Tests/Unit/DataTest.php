<?php
namespace Pillbox\TrustpilotWidgets\Tests\Unit\Helper;

use Pillbox\TrustpilotWidgets\Helper\Data as Data;

class DataTest extends \PHPUnit\Framework\TestCase
{

  public $class = "Pillbox\TrustpilotWidgets\Helper\Data";
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

  public function displayInfo($method, $test)
  {
      fwrite(STDERR, "{$this->class}::$method - {$test} running...\n\n");
  }

  /**
   * testIsEnabledTrue
   */
  public function testIsEnabled()
  {

    // Display test info
    $this->displayInfo("isEnabled", "testIsEnabled");

    // ensure the getConfig method returns the result
    $this->helper->method('getConfig')->willReturn(true);
    $this->helper->method('isEnabled')->willReturn($this->helper->getConfig(true));

    $this->assertEquals(true, $this->helper->isEnabled(), 'isEnabled did not return a true value');

  }

  /**
   * testIsEnabledFalse
   */
  public function testIsEnabledFalse()
  {

    // Display test info
    $this->displayInfo("isEnabled", "testIsEnabledFalse");

    // ensure the getConfig method returns the result
    $this->helper->method('getConfig')->willReturn(false);
    $this->helper->method('isEnabled')->willReturn($this->helper->getConfig(false));

    $this->assertEquals(false, $this->helper->isEnabled(), 'isEnabled did not return a false value');

  }

}
