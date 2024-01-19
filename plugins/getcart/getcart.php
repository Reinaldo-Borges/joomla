<?php
	defined('_JEXEC') or die('Restricted access');
?><?php


class plgHikashopGetCart extends JPlugin
{

	public function __construct(&$subject, $config) {
		parent::__construct($subject, $config);		

		if(isset($this->params))
			return;

		$plugin = JPluginHelper::getPlugin('hikashop', 'cartnotify');
		$this->params = new JRegistry(@$plugin->params);

		
	}

	public function onBeforeCartSave(&$element,&$do){			

		//include_once dirname(__FILE__).DS.'classes'.DS.'cart.php';

		$app  = JFactory::getApplication();
		$doc  = JFactory::getDocument();
		$user = JFactory::getUser();

		$linha = "--------------------------------------------------------------------------";

		// print_r(json_encode($user));
		// var_dump($linha);
		// print_r(json_encode($element));

		// var_dump($linha);
		// var_dump($linha);
		// var_dump($linha);		
		
		// $carto = json_decode($carrinho);
		// var_dump($linha);
		// var_dump($carto);
		$elemento = json_encode($element);
		$cart = json_decode($elemento);	

		$productsId = "";

		foreach ($cart->cart_products as $key => $value) {
			//echo $value->product_id . ", " . $value->cart_product_quantity . ", " . $value->cart_id . "<br>";
			global $productsId;
			$productsId = $productsId.''.$value->product_id . ",";
		}
		
		echo 'antes: '.$productsId.'<br>';
		$productsId = substr($productsId,0,-1);
		echo 'depois: '.$productsId.'<br>';

		$result = $this->getPriceByProduct($productsId);

		print_r($result);


	}

	public function getPriceByProduct($productsId){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('price_value, price_product_id')
		    ->from('#__hikashop_price')		     
			->where($db->quoteName('price_product_id') . ' IN (' . $productsId .')');

			// ->where('price_product_id IN ( :products )')
			// ->bind(':products', $productsId);

		try {

			$db->setQuery($query);

			echo $db->replacePrefix((string) $query);

			$results = $db->loadAssocList();

			foreach ($results as $row) {
				echo "<p>" . $row['price_value'] . ", " . $row['price_product_id'] . "<br></p>";
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

	function arrayToObject(array $array, $className) {
		return unserialize(sprintf(
			'O:%d:"%s"%s',
			strlen($className),
			$className,
			strstr(serialize($array), ':')
		));
	}
}

