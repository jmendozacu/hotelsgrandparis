<?php
/**
 * @category Taches
 * @package Hgp_Taches
 * @authors Brice POTE
 * @copyright HotelsGrandParis
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Hgp_Taches_Model_Source_Typeprices
{
    public function toOptionArray()
    {        
      $type_prices[] = array('value'=>'None', 'label'=>'Tous les tarifs (None)');
      $type_prices[] = array('value'=>'LowestMinimumPrice', 'label'=>'Prix le plus faible (LowestMinimumPrice)'); 
      $type_prices[] = array('value'=>'LowestMeanPrice', 'label'=>'Prix moyen le plus faible (LowestMeanPrice)');                                                         
      $type_prices[] = array('value'=>'LowestMaximumPrice', 'label'=>'Prix maximal le plus faible (LowestMaximumPrice)');                             
      $type_prices[] = array('value'=>'HighestMinimumPrice', 'label'=>'Prix minimal le plus élevé (HighestMinimumPrice)');                             
      $type_prices[] = array('value'=>'HighestMeanPrice', 'label'=>'Prix moyen le plus élevé (HighestMeanPrice)');                             
      $type_prices[] = array('value'=>'HighestMaximumPrice', 'label'=>'Prix maximal le plus élevé (HighestMaximumPrice)');                             
      $type_prices[] = array('value'=>'BestStatus', 'label'=>'Meilleur état de disponibilité (BestStatus)');                             
      return $type_prices;             
    }
}