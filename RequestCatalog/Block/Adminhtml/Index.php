<?php
namespace Pcnametag\RequestCatalog\Block\Adminhtml;
class Index extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * Constructor
     *
     * @return void
     */
    protected function _construct()
    {
		
        $this->_controller = 'adminhtml_index';/*block grid.php directory*/
        $this->_blockGroup = 'Pcnametag_RequestCatalog';
        $this->_headerText = __('Request Catalog');
        $this->_addButtonLabel = __('Add New Entry'); 
        parent::_construct();
		
    }
}
