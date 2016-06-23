<?php

namespace Drupal\senior_systems_api\Services;

use Drupal\senior_systems_api\SeniorSystems;

/**
 * Construct a SOAP request for the DataExportService methods.
 * 
 * See @link http://help.senior-systems.com/support/WSHelpGuide/html/AllMembers_T_DataExportService.htm @endlink
 */
class DataExportService extends SeniorSystemsService {
  function __construct() {
    parent::__construct('DataExportService');
  }

  /**
   * Set default values. 
   */
  protected function _setDefaults($method){
    
    $defaults = array(
      'authKey' => SeniorSystems::adminKey(),
    );
    switch($method){
      case 'GetAllParentsByStudentID':
        $defaults += array(
          'sStudentID' => '',
          'includeSpouseInfo' => FALSE,
          'includeStudents' => FALSE,
        );
      case 'getFacultySectionsByFacultyID':
        $defaults += array(
          'facultyID' => '',
        );
      break;
      case 'GetAllPersons':
        $defaults += array(
          'numberOfRecords' => 10,
          'lastEntityNumber' => 0,
          'lastUpdateDate' => 0,
          'parameters' => [],
        );
    }
    return $defaults;
  }

}