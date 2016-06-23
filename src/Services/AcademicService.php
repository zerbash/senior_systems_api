<?php

namespace Drupal\senior_systems_api\Services;

use Drupal\senior_systems_api\SeniorSystems;

/**
 * Construct a SOAP request for the UserProfileService methods.
 * 
 * See @link http://help.senior-systems.com/support/WSHelpGuide/html/AllMembers_T_AcademicService.htm @endlink
 */
class AcademicService extends SeniorSystemsService {
  function __construct() {
    parent::__construct('AcademicService');
  }

  /**
   * Set default values. 
   */
  protected function _setDefaults($method){
    
    $defaults = array(
      'authKey' => SeniorSystems::adminKey(),
      'schoolID' => 'Upper',
      'nextYear' => FALSE,      
    );
    
    switch($method){
      case 'GetStudentSectionsByStudentID':
        $defaults += array(
          'studentID' => '',
        );
      break;     
      case 'getFacultySectionsByFacultyID':
        $defaults += array(
          'facultyID' => '',
        );
      break;
      case 'GetSection':
        $defaults += array(
          'sectionID' => '',
        );
      break;   
      case 'GetStudentsForSection':
        $defaults += array(
          'sectionID' => '',
          'markinperiodID' => 0,
        );        
    }
    return $defaults;
  }
  

}
