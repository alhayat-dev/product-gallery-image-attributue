<?php

namespace Alhayat\DimensionImageAttribute\Observer;

use Magento\Framework\Event\ObserverInterface;

class ChangeTemplateObserver implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $observer->getBlock()->setTemplate('Alhayat_DimensionImageAttribute::helper/gallery.phtml');
    }
}
