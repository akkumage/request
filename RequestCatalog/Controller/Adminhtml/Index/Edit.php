<?php
namespace Pcnametag\RequestCatalog\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Edit extends \Magento\Backend\App\Action
{
   /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * @var \Magento\Backend\Model\View\Result\Page
     */
    protected $resultPage;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    
	public function execute()
    {
		$this->resultPage = $this->resultPageFactory->create();  
		$this->resultPage ->getConfig()->getTitle()->set((__('View Request Catalog')));
		
		// 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
		
        $model = $this->_objectManager->create('Pcnametag\RequestCatalog\Model\Index');
		
		$registryObject = $this->_objectManager->get('Magento\Framework\Registry');
		
        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addError(__('This row no longer exists.'));
                $this->_redirect('*/*/');
                return;
            }
        }
        // 3. Set entered data if was error when we do save
        $data = $this->_objectManager->get('Magento\Backend\Model\Session')->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }
		$registryObject->register('requestcatalog_index', $model);
		$this->_view->loadLayout();
        $this->_view->getLayout()->initMessages();
        $this->_view->renderLayout();
    }
}
