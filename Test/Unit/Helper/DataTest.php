<?php
namespace Pillbox\TrustpilotWidgets\Test\Unit\Helper;

use Pillbox\TrustpilotWidgets\Helper\Data as Data;

class DataTest extends \PHPUnit\Framework\TestCase
{

    protected $helper;
    public $enabled = true;
    public $businessUnitID = '1111111111';
    public $locale = 'en-US';

    /**
     * setUp
     */
    protected function setUp()
    {

        // Return value mapping - maps the values that will be returned by the getConfig
        // method, depending on the value passed to it
        $configmap = array(
            array('trustpilotwidgets/general/enable', $this->enabled),
            array('trustpilotwidgets/general/trustpilot_business_unit_id', $this->businessUnitID),
        );

        // helper_success stores positive (successful) results
        $this->helper = $this->createMock(Data::class);

        // Add return value mapping
        $this->helper->method('getConfig')->will($this->returnValueMap($configmap));

        // Ensure that the methods that rely on the getConfig method return the correct result
        $this->helper->method('isEnabled')->willReturn($this->helper->getConfig('trustpilotwidgets/general/enable'));
        $this->helper->method('getBusinessUnitID')->willReturn($this->helper->getConfig('trustpilotwidgets/general/trustpilot_business_unit_id'));

        // Mock the getStoreLocale method
        $this->helper->method('getStoreLocale')->willReturn($this->locale);

    }

    /**
     * testIsEnabledTrue
     */
    public function testIsEnabled()
    {

        // Run assertions
        $this->assertEquals($this->enabled, $this->helper->getConfig('trustpilotwidgets/general/enable'));
        $this->assertEquals($this->enabled, $this->helper->isEnabled());

    }

    /**
     * testGetBusinessUnitID
     */
    public function testGetBusinessUnitID()
    {

        // Run assertions
        $this->assertEquals($this->businessUnitID, $this->helper->getConfig('trustpilotwidgets/general/trustpilot_business_unit_id'));
        $this->assertEquals($this->businessUnitID, $this->helper->getBusinessUnitID());

    }

    public function testGetStoreLocale()
    {

        // Run assertion
        $this->assertEquals($this->locale, $this->helper->getStoreLocale());

    }

}
