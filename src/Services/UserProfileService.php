<?php

namespace Drupal\senior_systems_api\Services;

use Drupal\senior_systems_api\SeniorSystems;

/**
 * Construct a SOAP request for the UserProfileService methods.
 * 
 * See @link http://help.senior-systems.com/support/WSHelpGuide/html/AllMembers_T_UserProfileService.htm @endlink
 */
class UserProfileService extends SeniorSystemsService {
  function __construct() {
    parent::__construct('UserProfileService');
  }

  /**
   * Set default values. 
   */
  protected function _setDefaults($method){
    
    $defaults = array(
      'authKey' => SeniorSystems::adminKey(),
    );
    switch($method){
      case 'getPersonInfoByWebUserID':
        $defaults += array(
          'includeSpouseInfo' => FALSE,
          'includeStudents' => TRUE,
        );
      break;
    }
    return $defaults;
  }
  

}
