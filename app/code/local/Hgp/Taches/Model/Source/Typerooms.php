<?php
/**
 * @category Taches
 * @package Hgp_Taches
 * @authors Brice POTE
 * @copyright HotelsGrandParis
 * @license http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Hgp_Taches_Model_Source_Typerooms
{
    public function toOptionArray()
    {        
      $type_rooms[] = array('value'=>'None', 'label'=>'Type non spécifié (None)');
      $type_rooms[] = array('value'=>'Single', 'label'=>'Chambre simple (Single)'); 
      $type_rooms[] = array('value'=>'Double', 'label'=>'Chambre double (Double)');                             
      $type_rooms[] = array('value'=>'Twin', 'label'=>'Chambre double avec lits jumeaux (Twin)');                             
      $type_rooms[] = array('value'=>'Triple', 'label'=>'Chambre triple (Triple)');                             
      $type_rooms[] = array('value'=>'Quadruple', 'label'=>'Chambre quadruple (Quadruple)');                             
      $type_rooms[] = array('value'=>'FamilyRoom', 'label'=>'Chambre familiale (FamilyRoom)');                             
      $type_rooms[] = array('value'=>'JuniorSuite', 'label'=>'Suite Junior (JuniorSuite)');                             
      $type_rooms[] = array('value'=>'Suite', 'label'=>'Suite (Suite)');                             
      $type_rooms[] = array('value'=>'Apartment', 'label'=>'Appartement (Apartment)');                             
      $type_rooms[] = array('value'=>'Studio', 'label'=>'Studio (Studio)');                             
      $type_rooms[] = array('value'=>'Villa', 'label'=>'Villa (Villa)');                             
      $type_rooms[] = array('value'=>'Other', 'label'=>'Autre type (Other)');                             
      return $type_rooms;             
    }
}