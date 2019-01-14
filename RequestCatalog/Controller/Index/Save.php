<?php
/**
 *
 * Copyright © 2015 Pcnametagcommerce. All rights reserved.
 */
namespace Pcnametag\RequestCatalog\Controller\Index;
use Magento\Store\Model\ScopeInterface;

class Save extends \Magento\Framework\App\Action\Action
{

	/**
     * @var \Magento\Framework\App\Cache\TypeListInterface
     */
    protected $_cacheTypeList;

    /**
     * @var \Magento\Framework\App\Cache\StateInterface
     */
    protected $_cacheState;

    /**
     * @var \Magento\Framework\App\Cache\Frontend\Pool
     */
    protected $_cacheFrontendPool;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    
    protected $inlineTranslation;
	protected $transportBuilder;
	protected $scopeConfig;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList
     * @param \Magento\Framework\App\Cache\StateInterface $cacheState
     * @param \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
       \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\App\Cache\TypeListInterface $cacheTypeList,
        \Magento\Framework\App\Cache\StateInterface $cacheState,
        \Magento\Framework\App\Cache\Frontend\Pool $cacheFrontendPool,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Translate\Inline\StateInterface $inlineTranslation,
        \Magento\Framework\Mail\Template\TransportBuilder $transportBuilder,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    ) {
        parent::__construct($context);
        $this->_cacheTypeList = $cacheTypeList;
        $this->_cacheState = $cacheState;
        $this->_cacheFrontendPool = $cacheFrontendPool;
        $this->resultPageFactory = $resultPageFactory;
        $this->inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->scopeConfig = $scopeConfig;
        
    }
	
    /**
     * Flush cache storage
     *
     */
    public function execute()
    {
		$data = $this->getRequest()->getParams();
		//echo "<pre>";print_r($data);die;
		if ($data) {
            $model = $this->_objectManager->create('Pcnametag\RequestCatalog\Model\Index');
            try {
				$model->setData($data);
				$model->save();
				$this->messageManager->addSuccess(__('Your request has been submitted.'));
				
				//code for sending email
					$this->inlineTranslation->suspend();
				
					$postObject = new \Magento\Framework\DataObject();
					$post['myname'] = $data['firstname']." ".$data['lastname'];
					//$post['firstname'] = $data['firstname'];
				//	$post['lastname'] = $data['lastname'];
					$post['myemail'] = $data['email'];
					//$post['organisation'] = $data['organisation'];
					//$post['jobtitle'] = $data['jobtitle'];
					foreach($data as $key=>$value){
						$post[$key] = $value;
					}
					
					$postObject->setData($post);
					
					$myname = $data['firstname'];
					$myemail = $data['email'];
					
					$sender = [
					 'name' => $myname,
					 'email'=> $myemail,
					 ];
					 
					 $sentToEmail = $this->scopeConfig->getValue('trans_email/ident_support/email',ScopeInterface::SCOPE_STORE);
					 $sentToname = $this->scopeConfig->getValue('trans_email/ident_support/name',ScopeInterface::SCOPE_STORE);
					 
					 $senderToInfo = [
					 'name' => $sentToname,
					 'email' =>$sentToEmail,
					 ];
					 
					 $storeScope = \Magento\Store\Model\ScopeInterface::SCOPE_STORE; 
					 $transport = $this->_transportBuilder
					 ->setTemplateIdentifier('mymodule_email_template') // My email template
					 ->setTemplateOptions( [
					 'area' => \Magento\Framework\App\Area::AREA_FRONTEND, // this is using frontend area to get the template file if admin then \Magento\Backend\App\Area\FrontNameResolver::AREA_CODE
					 'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
					 ])
					 ->setTemplateVars(['data' => $postObject])
					 ->setFrom($sender)
					 ->addTo($senderToInfo)
					 ->getTransport();
					 $transport->sendMessage();
					 $this->inlineTranslation->resume();
				
				//code end for email
				
				
			}
			catch (\Exception $e) {
                //$this->messageManager->addException($e, __($e->getMessage()));
            }
        }
		$this->_redirect('*/*/');
    }
}
