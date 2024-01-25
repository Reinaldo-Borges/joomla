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

        // public function onHikashopAfterDisplayView(&$view){
        //     echo "onHikashopBeforeDisplayView"."<br>";   
        //     //$view;

        //     header("Location: /joomla/plugins/hikashoppayment/multipagamentos/tmpl/default.php");
        //     die();
        // }

        public function onCheckoutWorkflowLoad(&$checkout_workflow, &$shop_closed, $cart_id){
            echo "onCheckoutWorkflowLoad"."<br>";
            echo "checkout_workflow: "."<br>";
            echo json_encode($checkout_workflow);
            echo "<br>";

            echo "shop_closed: ".json_encode($shop_closed)."<br>";        

            echo "cart_id: ".$cart_id."<br>";           

            $this->cart = hikashop_get('class.cart');
            $cartId = $this->cart->getCurrentCartId();
            $this->getDataCart($cartId);

            //header("Location: /joomla/plugins/hikashoppayment/multipagamentos/tmpl/default.php");
            //die();
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
    
            // foreach($results as $k => $result){
            // 	$results[$k] = new stdClass;		
            // 	$results[$k]->id = (int) $result->price_product_id;
            // 	$results[$k]->value = (int) $result->price_value;
                          
            // }
        }
        

    }