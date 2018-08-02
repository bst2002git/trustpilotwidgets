<?php

namespace Pillbox\TrustpilotWidgets\Model\Source;

class Products implements \Magento\Framework\Option\ArrayInterface
{

    protected $_productCollectionFactory;

    public function __construct(
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory
    ) {
        $this->_productCollectionFactory = $productCollectionFactory;
    }

    public function getProducts()
    {
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addAttributeToFilter('type_id', array('in' => array('simple', 'configurable')));
        $collection->getSelect()->order('sku', \Magento\Framework\DB\Select::SQL_ASC);
        return $collection;
    }

    public function toOptionArray()
    {
        foreach ($this->getProducts() as $item) {
            $data[] = ['value' => $item->getSku(), 'label' => $item->getSku() . ' - ' . $item->getName()];
        }
        return $data;
    }
}
