<?php
/**
 * Copyright © 2015 Pcnametag . All rights reserved.
 */
namespace Pcnametag\RequestCatalog\Helper;
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{

	/**
     * @param \Magento\Framework\App\Helper\Context $context
     */
	public function __construct(
		\Magento\Framework\App\Helper\Context $context,
		\Magento\Store\Model\StoreManagerInterface $storeManager
	) {
		$this->_storeManager = $storeManager;
		parent::__construct($context);
	}
	
	public function getFormUrl(){
		return $this->_storeManager->getStore()->getBaseUrl();
	}
}
