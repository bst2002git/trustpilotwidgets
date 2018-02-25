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

    // Return value mapping - maps the values that will be returned by the getConfig
    // method, depending on the value passed to it
    $configmap = array(
      array(
        'trustpilotwidgets/general/enable',
        'trustpilotwidgets/general/trustpilot_business_unit_id'
      ),
      array(
        true,
        '1111111111'
      )
    );

    // helper_success stores positive (successful) results
    $this->helper = $this->createMock(Data::class);
    $this->helper->method('getConfig')->willReturnValueMap($configmap);
    $this->helper->method('isEnabled')->willReturn($this->helper->getConfig('trustpilotwidgets/general/enable'));
    $this->helper->method('getBusinessUnitID')->willReturn($this->helper->getConfig('trustpilotwidgets/general/trustpilot_business_unit_id'));
    $this->helper->method('getStoreLocale')->willReturn('en_US');

  }

  /**
   * testIsEnabledTrue
   */
  public function testIsEnabled()
  {

    // Run assertion
    $this->assertEquals(true, $this->helper->isEnabled(), 'isEnabled did not return a true value');

  }

  /**
   * testGetBusinessUnitID
   */
  public function testGetBusinessUnitID()
  {

    // Run assertion
    $this->assertEquals('1111111111', $this->helper->getBusinessUnitID(), 'isEnabled did not return a false value');

  }

}
