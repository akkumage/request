<?php
namespace Pcnametag\RequestCatalog\Block\Adminhtml\Index\Edit\Tab;
class Info extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = array()
    ) {
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
		/* @var $model \Magento\Cms\Model\Page */
        $model = $this->_coreRegistry->registry('requestcatalog_index');
		$isElementDisabled = false;
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('page_');

        $fieldset = $form->addFieldset('base_fieldset', array('legend' => __('Request Catalog Data')));

        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array('name' => 'id'));
        }

		$fieldset->addField(
            'firstname',
            'text',
            array(
                'name' => 'firstname',
                'label' => __('firstname'),
                'title' => __('firstname'),
                'required' => true,
            )
        );
        
        $fieldset->addField(
            'lastname',
            'text',
            array(
                'name' => 'lastname',
                'label' => __('lastname'),
                'title' => __('lastname'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'organisation',
            'text',
            array(
                'name' => 'organisation',
                'label' => __('organisation'),
                'title' => __('organisation'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'jobtitle',
            'text',
            array(
                'name' => 'jobtitle',
                'label' => __('Job Title'),
                'title' => __('Job Title'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'customertype',
            'text',
            array(
                'name' => 'customertype',
                'label' => __('Customer Type'),
                'title' => __('Customer Type'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'paper_catalog',
            'text',
            array(
                'name' => 'paper_catalog',
                'label' => __('Paper Catalog'),
                'title' => __('Paper Catalog'),
            )
        );
        $fieldset->addField(
            'email_offers',
            'text',
            array(
                'name' => 'email_offers',
                'label' => __('Email Offers'),
                'title' => __('Email Offers'),
            )
        );
        
        $fieldset->addField(
            'street',
            'text',
            array(
                'name' => 'street',
                'label' => __('Street Address'),
                'title' => __('Street Address'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'address_line2',
            'text',
            array(
                'name' => 'address_line2',
                'label' => __('Address Line 2'),
                'title' => __('Address Line 2'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'city',
            'text',
            array(
                'name' => 'city',
                'label' => __('city'),
                'title' => __('city'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'zipcode',
            'text',
            array(
                'name' => 'zipcode',
                'label' => __('Postal / Zip Code'),
                'title' => __('Postal / Zip Code'),
                'required' => true,
            )
        );
        $fieldset->addField(
            'country_id',
            'text',
            array(
                'name' => 'country_id',
                'label' => __('Country'),
                'title' => __('Country'),
                'required' => true,
            )
        );
        
         $fieldset->addField(
            'phone',
            'text',
            array(
                'name' => 'phone',
                'label' => __('Phone Number'),
                'title' => __('Phone Number'),
                'required' => true,
            )
        );
         $fieldset->addField(
            'email',
            'text',
            array(
                'name' => 'email',
                'label' => __('Email Address'),
                'title' => __('Email Address'),
                'required' => true,
            )
        );
         $fieldset->addField(
            'event',
            'text',
            array(
                'name' => 'event',
                'label' => __('Name of event:'),
                'title' => __('Name of event:'),
                'required' => true,
            )
        );
         
         $fieldset->addField(
            'date',
            'text',
            array(
                'name' => 'date',
                'label' => __('Date of event:'),
                'title' => __('Date of event:'),
              
            )
        );
         $fieldset->addField(
            'attendees',
            'text',
            array(
                'name' => 'attendees',
                'label' => __('No. of attendees'),
                'title' => __('No. of attendees'),
              
            )
        );
         $fieldset->addField(
            'meetings',
            'text',
            array(
                'name' => 'meetings',
                'label' => __('Do you plan multiple meetings in an average year?'),
                'title' => __('Do you plan multiple meetings in an average year?'),
              
            )
        );
		/*{{CedAddFormField}}*/
        
        if (!$model->getId()) {
            $model->setData('status', $isElementDisabled ? '2' : '1');
        }

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();   
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('info');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('info');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
