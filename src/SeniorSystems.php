<?php

namespace Drupal\senior_systems_api;

class SeniorSystems {
  
  private $service;
  
  function __construct($service) {
   // $class = 'Drupal\senior_systems_api\Services\\' . $service;
  //  return new $class;
  }

  /**
   * 
   * @param string $service
   *  Service requested. Can be:
   *    - UserManagementService
   *    - UserProfileService
   *    - AcademicService
   *    - DataExportService
   *    - DataUpdateService
   *    
   * @return object
   *  SOAP object for requested service.
   */
  public static function service($service){
    $class = 'Drupal\senior_systems_api\Services\\' . $service;
    return new $class;
  }

  /**
   * Retrieve an admin key for making SOAP requests.
   * 
   * Most requests require an admin key. On the configuration page we set
   * a user with appropriate permissions to make these requests.
   * 
   * @return string
   */
  public static function adminKey(){
    
    // Cache ID
    $cid = 'senior_systems_authkey';

    $expired = TRUE;

    if($cache = \Drupal::cache()->get($cid)){
      // Was this cached within the last two hours?
      $expired = time() - $cache->created > 7200;
    }

    if (!$expired) {
      $key = $cache->data;
    } else {
      // Request a new authorization key
      $config = \Drupal::config('senior_systems_api.settings');
      $params = array(
        'username' => $config->get('username'),
        'password' => $config->get('password'),
      );
      $service = self::service('UserManagementService');
      $result = $service->loginExt($params);
      $key = $result->AuthKey;

      // Don't cache a bad key
      $pattern = '/^\w{8}(-\w{4}){3}-\w{12}$/';
      if(preg_match($pattern,$key)){
       \Drupal::cache()->set($cid, $key);
      } else {
        // Don't return a bad key either
        return;
      }
    }

   return $key;

  }

}