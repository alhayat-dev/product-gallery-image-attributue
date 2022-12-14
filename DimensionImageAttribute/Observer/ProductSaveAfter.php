<?php

namespace Alhayat\DimensionImageAttribute\Observer;

use Magento\Framework\Event\ObserverInterface;

class ProductSaveAfter implements ObserverInterface
{
    protected $request;
    protected $resource;

    /**
     *
     * @param \Magento\Framework\App\RequestInterface $request
     * @param \Magento\Framework\App\ResourceConnection $resource\
     */
    public function __construct(
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\App\ResourceConnection $resource
    ) {
        $this->request = $request;
        $this->resource = $resource;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $data = $this->request->getPostValue();

        if (isset($data['product']['media_gallery']['images'])) {
            // print_r($images);exit;
            $connection = $this->resource->getConnection();
            $tableName = 'catalog_product_entity_media_gallery_value'; //gives table name with prefix
            $product = $observer->getProduct();
            $mediaGallery = $product->getMediaGallery();

            if (isset($mediaGallery['images'])) {
                foreach ($mediaGallery['images'] as $image) {
                    //Update Data into table
                    $dimension = !empty($image['dimension']) ? (int)$image['dimension'] : 0;
                    $sql = "UPDATE " . $tableName . " SET dimension = " . $dimension . " WHERE value_id = " . $image['value_id'];
                    $connection->query($sql);
                }
            }
        }
    }
}
