<?php
namespace Pillbox\TrustpilotWidgets\Test\Unit\Mini;

use Pillbox\TrustpilotWidgets\Helper\Data as WidgetHelper;

class MiniWidgetTest extends \PHPUnit_Framework_TestCase {

  /**
   * @var Pillbox\TrustpilotWidgets\Helper\Data
   */
  protected $widgetHelper;

  /**
   * Tests whether the helper method returns a boolean true
   */
  public function testGetBusinessUnitIdTrue()
  {
    $configPath = 'trustpilotwidgets/general/trustpilot_business_unit_id';
    $dbValue = true;

    // Asserts that the value is correct
    $this->assertEquals($dbValue, $this->_runConfigCheck($configPath, $dbValue));
  }

  /**
   * Tests whether the helper method returns a boolean false
   */
  public function testGetBusinessUnitIdFalse()
  {
    $configPath = 'trustpilotwidgets/general/trustpilot_business_unit_id';
    $dbValue = false;

    // Asserts that the value is correct
    $this->assertEquals($dbValue, $this->_runConfigCheck($configPath, $dbValue));
  }

  /**
   * Used to run an assert on checks to Magento 2 Configs
   * @param  string $path  Core Config Path
   * @param  mixed  $value Value to test for
   * @return mixed         Returned value
   */
  private function _runConfigCheck($path, $value)
  {
    $scopeConfigMock = $this->getMockBuilder(\Magento\Framework\App\Config\ScopeConfigInterface::class)
                            ->disableOriginalConstructor()
                            ->getMock();
    $scopeConfigMock->method('getValue')
                    ->willReturn($value);
    $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
    $myClass = $objectManager->getObject(
        WidgetHelper::class,
        [
             'scopeConfig' => $scopeConfigMock
        ]
    );

    return $myClass->getConfig($path);
  }

}
