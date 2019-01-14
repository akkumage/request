<?php
namespace Pcnametag\Requestcatalog\Controller\Index;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Backend\App\Action;
 



class Saveimage extends \Magento\Framework\App\Action\Action
{
	protected $_fileUploaderFactory;
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Filesystem $filesystem,
         \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        \Magento\Framework\App\Filesystem\DirectoryList $directory_list,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
        
    ) {
        $this->_request = $context->getRequest();
        $this->filesystem=$filesystem;
        $this->_mediaDirectory = $filesystem->getDirectoryWrite(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
        $this->directory_list= $directory_list;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        return parent::__construct($context);

    }
     
    public function execute()
    {
		//echo '<pre>';
        	//print_r($_REQUEST);
        	//print_r($_FILES);
        	foreach($_FILES as $key=> $file)
				$file_key = $key;				
        	//echo '</pre>';
        	//return "die here";
            $target = $this->_mediaDirectory->getAbsolutePath('liquifire');       
            
            
             
	        $uploader = $this->_fileUploaderFactory->create(['fileId' => $_FILES[$file_key]]);
	        $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png','eps','ai']);
	        $uploader->setAllowRenameFiles(true);
	        $result = $uploader->save($target);
			$resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
			
			$_objectManager = \Magento\Framework\App\ObjectManager::getInstance(); //instance of\Magento\Framework\App\ObjectManager
			$storeManager = $_objectManager->get('Magento\Store\Model\StoreManagerInterface'); 
			$currentStore = $storeManager->getStore();
			$mediaUrl = $currentStore->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
			//$target2 = $this->directory_list->getBaseUrl('media'); 
        	$resultJson->setData($mediaUrl.'liquifire/'.$result['file']);
        	//echo '<pre>';
        	//print_r($resultJson);
        	//echo '</pre>';
        	return $resultJson;
    }
}
