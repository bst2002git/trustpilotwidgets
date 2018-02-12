<?php
namespace Helper;

use PHPUnit\Framework\TestCase;

class DataTest extends TestCase {

  /**
   * Tests whether the helper method returns a boolean true
   */
  public function testIsEnabledTrue()
  {
    $configPath = 'trustpilotwidgets/general/trustpilot_business_unit_id';
    $dbValue = true;

    $this->assertInstanceOf(
      Data::class,
      Data::isEnabled()
    );

    // Asserts that the value is correct
    // $this->assertEquals($dbValue, $this->_runConfigCheck($configPath, $dbValue));
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
  public function _runConfigCheck($path, $value)
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
