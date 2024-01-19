<?php 

    defined('_JEXEC') or die;

    abstract class MultiPagamentosData{
        public static function salvarOpcoes{
        }

       
        public static function listarOpcoes(&$params){
            $db = JFactory::getDbo();
            $query = $db->getQuery(true);

            $query->select('option_id, name');
            $query->from('#__options');
            $query->order('name DESC');
            $db->setQuery($query, 0, $params->get('count', 5));

            try {
                $results = $db->loadObjectList();
            } catch (RuntimeException $e) {
                echo $e->getMessage();
                return false;
            }

            foreach($results as $k => $result){
                $results[$k] = new stdClass;
                $results[$k]->name = htmlspecialchars($result->name);
                $results[$k]->id = (int) $result->option_id;                               
            }

            return $results;
        }

        public static function salvarCliente{
        }
       
       
    }
