<?php

namespace Drupal\senior_systems_api\Services;

/**
 * Base class for constructing a SOAP client to connect to Senior Systems'
 * Web Services.
 * 
 * This class utilizes PHP's SOAP extension.
 * 
 * See @link http://php.net/manual/en/intro.soap.php @endlink
 * See @link http://help.senior-systems.com/support/WSHelpGuide/html/Setup.htm @endlink
 */
class SeniorSystemsService extends \SoapClient {

  /**
   * Construct a SOAP client based on the appropriate WSDL file for the 
   * requested service.
   * 
   * @param string $service
   *  The name of the Senior Systems API Class
   */
  function __construct($service){
    $url = \Drupal::config('senior_systems_api.settings')->get('url');
    $url .= '/SeniorSystemsWS/' . $service . '.asmx?WSDL';
    $this->SoapClient($url,array('trace'=>1));
  }

  /**
   * Set default values and initiate the SOAP request.
   * 
   * @param string $name
   *  The name of the method
   * @param array $arguments
   *  The passed parameters (will override defaults)
   * @return mixed
   *  An object containing the result, or fault string on failure.
   */
  function __call($name, $arguments) {

    
    // See the individual service class for the _setDefaults() method.
    $defaults = $this->_setDefaults($name);
    
    // Each method only takes one argument: the $params array. However,
    // this is optional, so if it's left out, $arguments will be an empty
    // array.
    $params = array_merge($defaults,$arguments ? $arguments[0] : []);
    
    // If the parameter key is set, we need to change the structure a bit
    // to be compatible with the SOAP call
    if($params['parameters']){
      $this->_parameterize($params);
    }

    try {
      // Initiate the SOAP request
      $result = $this->__soapCall($name, array($params));
      $property = $name . 'Result';
      return $result->$property;
      
    } catch (\SoapFault $fault){
      return $fault->faultstring;
    }
  }

  /**
   * Convert the 'parameters' element of the array into the correct stucture.
   *
   * @param array $params
   */
  private function _parameterize(&$params){
    $WSMethodParams = [];
    foreach($params['parameters'] as $key => $value){
      $WSMethodParams[] = array(
        'Parameter' => $key,
        'Value' => $value,
      );
    }
    $params['parameters'] = array(
      'WSMethodParam' => $WSMethodParams,
    );
  }
}
