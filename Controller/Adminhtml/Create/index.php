<?php
namespace Shippify\ShippifyMagento\Controller\Adminhtml\Create;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Sales\Model\ResourceModel\Order\CollectionFactory;
use Magento\Sales\Api\OrderManagementInterface;
use Shippify\ShippifyMagento\Helper\Data;


class Index extends \Magento\Sales\Controller\Adminhtml\Order\AbstractMassAction
{
    /**
     * @var OrderManagementInterface
     */
    protected $orderManagement;

    protected $helperData;

    /**
     * @param Context $context
     * @param Filter $filter
     * @param CollectionFactory $collectionFactory
     * @param OrderManagementInterface $orderManagement
     */

    public function __construct(
        Context $context,
        Filter $filter,
        CollectionFactory $collectionFactory,
        OrderManagementInterface $orderManagement,
        Data $helperData
    ) {
        parent::__construct($context, $filter);
        $this->collectionFactory = $collectionFactory;
        $this->orderManagement = $orderManagement;
        $this->helperData = $helperData;
    }
   /**
     * Hold selected orders
     *
     * @param AbstractCollection $collection
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    protected function massAction(AbstractCollection $collection)
    {
        $logger = \Magento\Framework\App\ObjectManager::getInstance()->get('Psr\Log\LoggerInterface');
        $countCreateOrder = 0;
        $model = $this->_objectManager->create('Magento\Sales\Model\Order');
        $orders = array();
        foreach ($collection->getItems() as $order) {
            if (!$order->getEntityId()) {
                continue;
            }
            $loadedOrder = $model->load($order->getEntityId());
            array_push($orders, $order->getEntityId());
            $countCreateOrder++;
        }
        $countNonCreateOrder = $collection->count() - $countCreateOrder;

        

        if ($countNonCreateOrder && $countCreateOrder) {
            $this->messageManager->addError(__('%1 order(s) were not created in Shippify.', $countNonCreateOrder));
        } elseif ($countNonCreateOrder) {
            $this->messageManager->addError(__('No order(s) were created.'));
        }


        //echo $this->helperData->getGeneralConfig('enable');
       // echo $this->helperData->getGeneralConfig('api_id');
        //echo $this->helperData->getGeneralConfig('api_token');


        if ($countCreateOrder) {


            $url = 'https://api.shippify.co/v1/magento/create/deliveries';

            $ch = curl_init( $url );
            
            $username = $this->helperData->getGeneralConfig('api_id');
            $password = $this->helperData->getGeneralConfig('api_token');

            $orders_separated = implode(",", $orders);

            $payload = json_encode( array( "orders"=> $orders_separated ) );

            $logger->debug('ORDERS');
            $logger->debug((String)$orders_separated);

            curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password); 
            curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
            curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
            // # Return response instead of printing.
            curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
            // # Send request.
            $result = curl_exec($ch);
            curl_close($ch);
            // # Print response.
            $logger->debug('RESULT:');
            $logger->debug((String)$result);

            $this->messageManager->addSuccess(__('You have created %1 delivery(s) in Shippify.', $countCreateOrder));
        }
        

        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('shippifymagento/orders/index');
        return $resultRedirect;
    }
}
