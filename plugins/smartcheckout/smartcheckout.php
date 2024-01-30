<?php

    ini_set('memory_limit', '-1');

    class plgHikaShopSmartCheckout extends JPlugin {

        protected $plugin_name = 'smartcheckout';
        public $cart = null;  

        public function __construct(&$subject, $config) {
            parent::__construct($subject, $config);

            if(isset($this->params))
                return;

            $plugin = JPluginHelper::getPlugin('hikashop', $this->plugin_name);
            $this->params = new JRegistry(@$plugin->params);
        }

        public function onAfterCheckoutStep($controller, &$go_back, $original_go_back){

            echo "onAfterCheckoutStep"."<br>";
            echo "Controller"."<br>";
            var_dump($controller);

            echo "go_back"."<br>";
            var_dump($go_back);

            echo "original_go_back"."<br>";
            var_dump($original_go_back);
           
        }     

        public function onCheckoutWorkflowLoad(&$checkout_workflow, &$shop_closed, $cart_id){                     

            //get cartId
            $this->cart = hikashop_get('class.cart');
            $cartId = $this->cart->getCurrentCartId();
            //$this->getDataCart($cartId);

            //get user
            $user = JFactory::getUser();          
            $userId = $user->id; 

            if($cartId > 0){
                header("Location: /joomla/plugins/hikashoppayment/multipagamentos/tmpl/default.php?cartid=$cartId&userId=$userId");     
                die();           
            }
        }

        public function getDataCart($cart_id){
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);
    
            $query
                    ->select(array('cp.cart_id Cart', 'p.product_id ProductId', 'cp.cart_product_quantity QTD', 'pri.price_value Price'))
                    ->from($db->quoteName('#__hikashop_cart_product', 'cp'))
                    ->join('INNER', $db->quoteName('#__hikashop_product', 'p') . ' ON ' . $db->quoteName('p.product_id') . ' = ' . $db->quoteName('cp.product_id'))
                    ->join('INNER', $db->quoteName('#__hikashop_price', 'pri') . ' ON ' . $db->quoteName('pri.price_product_id') . ' = ' . $db->quoteName('p.product_id'))
                    ->where($db->quoteName('cp.cart_id') . ' = :cartId')
                    ->bind(':cartId', $cart_id);
    
            try {
    
                $db->setQuery($query);
    
                echo $db->replacePrefix((string) $query);
    
                $results = $db->loadAssocList();                
                
                foreach ($results as $row) {
                    echo "<p> Quantity: ". $row['QTD'] . " Price: " . $row['Price'] . "  Product: " . $row['ProductId'] . "<br></p>";
                }
    
            } catch (RuntimeException $e) {
                echo $e->getMessage();
                return false;
            }
    
         
        }
        

    }