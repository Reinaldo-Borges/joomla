<?php 

    defined('_JEXEC') or die;
    //require_once __DIR__ . '/helper.php';

jimport( 'joomla.plugin.helper' );

class plgMultiPagamentos extends hikashopPaymentPlugin
{
    //$keyAPI = MultiPagamentosHelper::getKey($params);

    //echo 'CHAVE: '.$keyAPI;

    //This function is called at the end of the checkout. 
    //That's the function which should display your payment gateway redirection form with the data from HikaShop
	function onAfterOrderConfirm(&$order,&$methods,$method_id)
	{
		parent::onAfterOrderConfirm($order,$methods,$method_id); // This is a mandatory line in order to initialize the attributes of the payment method

		//Here we can do some checks on the options of the payment method and make sure that every required parameter is set and otherwise 
        //display an error message to the user
		if (empty($this->payment_params->identifier)) //The plugin can only work if those parameters are configured on the website's backend
		{
			$this->app->enqueueMessage('You have to configure an identifier for the Example plugin payment first : check your plugin\'s parameters, on your website backend','error');
			//Enqueued messages will appear to the user, as Joomla's error messages
			return false;
		}
		elseif (empty($this->payment_params->password))
		{
			$this->app->enqueueMessage('You have to configure a password for the Example plugin payment first : check your plugin\'s parameters, on your website backend','error');
			return false;
		}
		elseif (empty($this->payment_params->payment_url))
		{
			$this->app->enqueueMessage('You have to configure a payment url for the Example plugin payment first : check your plugin\'s parameters, on your website backend','error');
			return false;
		}
		else
		{
			//Here, all the required parameters are valid, so we can proceed to the payment platform


			$amout = round($order->cart->full_total->prices[0]->price_value_with_tax,2)*100;
			//The order's amount, here in cents and rounded with 2 decimals because of the payment platform's requirements
			//There is a lot of information in the $order variable, such as price with/without taxes, customer info, products... you can do a var_dump here if you need to display all the available information

			//This array contains all the required parameters by the payment plateform
			//Not all the payment platforms will need all these parameters and they will probably have a different name.
			//You need to look at the payment gateway integration guide provided by the payment gateway in order to know what is needed here
			$vars = array(
				'IDENTIFIER' => $this->payment_params->identifier, //User's identifier on the payment platform
				'CLIENTIDENT' => $order->order_user_id, //The id of the customer
				'DESCRIPTION' => "order number : ".$order->order_number, //Order's description
				'ORDERID' => $order->order_id, //The id of the order which will be given back by the payment gateway when it will notify your plugin that the payment has been done and which will allow you to know the order corresponding to the payment in order to confirm it
				'VERSION' => 2.0, //The platform's API version, needed by the payment platform
				'AMOUNT' => $amout //The amount of the order
			);

			//To certifiate the values integrity, payment platform use to ask a hash
			//This hash is generated according to the platform requirements
			$vars['HASH'] = $this->example_signature($this->payment_params->password,$vars);
			$this->vars = $vars;

			//Add the data sent to the payment gateway to the payment log when the debug setting of the payment method is activated
			if($this->payment_params->debug)
				$this->writeToLog($vars);

			//Ending the checkout, ready to be redirect to the plateform payment final form
			//The showPage function will call the example_end.php file which will display the redirection form containing all the parameters for the payment platform
			return $this->showPage('end');
		}
	}
}