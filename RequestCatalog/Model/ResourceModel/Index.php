<?php
/**
 * Copyright © 2015 Pcnametag. All rights reserved.
 */
namespace Pcnametag\RequestCatalog\Model\ResourceModel;

/**
 * Index resource
 */
class Index extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('requestcatalog_index', 'id');
    }

  
}
