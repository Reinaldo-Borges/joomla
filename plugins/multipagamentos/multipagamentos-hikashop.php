
    <?php   
      defined('_JEXEC') or die('Restricted access');
    ?><?php
    class MultiPagamentosHikaShop extends JPlugin
    {
       public function __construct(&$subject, $config) {
          parent::__construct($subject, $config);
    
          if(isset($this->params))
             return;
    
          $plugin = JPluginHelper::getPlugin('hikashop', 'cartnotify');
          $this->params = new JRegistry(@$plugin->params);
       }
    
       function onBeforeCartSave(&$element,&$do){

         echo "TESTE: ".$element;

       }
    
   
   }
    