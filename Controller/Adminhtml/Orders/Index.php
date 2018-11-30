<?php
namespace Shippify\ShippifyMagento\Controller\Adminhtml\Orders;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\App\Action;

      class Index extends Action
      {
        /**
        * @var \Magento\Framework\View\Result\PageFactory
        */
        protected $resultPageFactory;

        /**
         * Constructor
         *
         * @param \Magento\Backend\App\Action\Context $context
         * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
         */

        public function __construct(
               Context $context,
               PageFactory $resultPageFactory
          ) {
               parent::__construct($context);
               $this->resultPageFactory = $resultPageFactory;
          }

        /**
         * Load the page defined in view/adminhtml/layout/exampleadminnewpage_helloworld_index.xml
         *
         * @return \Magento\Framework\View\Result\Page
         */
        public function execute()
        { 
               $resultPage = $this->resultPageFactory->create();
               $resultPage->getConfig()->getTitle()->prepend(__('Shippify Orders'));
             return  $resultPage;
        }
      }