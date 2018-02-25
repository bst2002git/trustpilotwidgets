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

  }

  /**
   * testIsEnabledTrue
   */
  public function testIsEnabled()
  {

    // set the return value
    $returnValue = true;

    // ensure the getConfig method returns the result
    $this->setConfigReturnValue($returnValue);

    // Run assertion
    $this->assertEquals($returnValue, $this->helper->isEnabled(), 'isEnabled did not return a true value');

  }

  /**
   * testIsEnabledFalse
   */
  public function testIsEnabledFalse()
  {

    // set the return value
    $returnValue = false;

    // ensure the getConfig method returns the result
    $this->setConfigReturnValue($returnValue);

    // Run assertion
    $this->assertEquals($returnValue, $this->helper->isEnabled(), 'isEnabled did not return a false value');

  }

  /**
   * testGetBusinessUnitID
   */
  public function testGetBusinessUnitID()
  {

    // set the return value
    $returnValue = '1111111111';

    // ensure that the getConfig method returns the right value
    $this->setConfigReturnValue($returnValue);

    // Run assertion
    $this->assertEquals($returnValue, $this->helper->getBusinessUnitID(), 'isEnabled did not return a false value');

  }

  /**
   * setConfigReturnValue
   * @param mixed $value Value that the getConfig method will return
   */
  public function setConfigReturnValue($value)
  {

    $this->helper->method('getConfig')->willReturn($value);

  }

}
