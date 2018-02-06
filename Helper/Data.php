<?php
namespace Pillbox\TrustpilotWidgets\Helper;

/**
 * Class Data
 * @package Pillbox\TrustpilotWidgets\Helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

    /**
     * Checks to see if the module is enabled
     * @return boolean Enabled State
     */
    public function isEnabled()
    {
      return ($this->getConfig('trustpilotwidgets/general/enable' == 1) ? true : false;
    }

    /**
     * Gets the Trustpilot Business Unit ID
     * @return string Trustpilot Business Unit ID
     */
    public function getBusinessUnitID()
    {
      return $this->getConfig('trustpilotwidgets/general/business_unit_id');
    }

    /**
     * Gets the current store locale
     * @return string Locale
     */
    public function getStoreLocale()
    {
      $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
      $store = $objectManager->get('Magento\Store\Api\Data\StoreInterface');
      return $store->getLocaleCode();
    }

    /**
     * Gets config value from core_config_data
     * @param  string $config_path Path to Configuration value
     * @return mixed              Result
     */
    public function getConfig($config_path)
    {
      return $this->scopeConfig->getValue($config_path, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
    }

}
