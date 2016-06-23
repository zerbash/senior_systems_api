<?php

namespace Drupal\senior_systems_api\Services;

use Drupal\senior_systems_api\SeniorSystems;

class UserManagementService extends SeniorSystemsService {
  function __construct() {
    parent::__construct('UserManagementService');
  }
  
    /**
   * Set default values. This is called from 
   */
  protected function _setDefaults($method){
    
    switch($method){
      case 'loginExt':
        return array(
          'username' => '',
          'password' => '',
        );
      break;
    }

  }
  
}
