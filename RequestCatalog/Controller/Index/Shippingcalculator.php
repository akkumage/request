<?php

namespace Pcnametag\Requestcatalog\Controller\Index;

use Magento\Backend\App\Action;

define('INSHIP_OEMKEY_14', '');
define('INSHIP_OEMKEY_15', '');
define('INSHIP_OEMKEY_16', '');
define('INSHIP_OEMKEY_17', '');
define('INSHIP_OEMKEY_18', '');
define('INSHIP_OEMKEY_10', '');
define('INSHIP_OEMKEY_11', '');
define('INSHIP_OEMKEY_12', '');
define('INSHIP_OEMKEY_13', '');
define('INSHIP_OEMKEY_20', '');
define('INSHIP_OEMKEY_26', '');
define('INSHIP_OEMKEY_27', '');
define('INSHIP_OEMKEY_25', '');
define('INSHIP_OEMKEY_21', '');
define('INSHIP_OEMKEY_22', '');
define('INSHIP_OEMKEY_23', '');
define('INSHIP_OEMKEY_24', '');
define('INSHIP_OEMKEY_50', '');
define('INSHIP_OEMKEY_30', '');
define('INSHIP_OEMKEY_35', '');
define('INSHIP_OEMKEY_36', '');
define('INSHIP_OEMKEY_31', '');
define('INSHIP_OEMKEY_32', '');
define('INSHIP_OEMKEY_33', '');
define('INSHIP_OEMKEY_34', '');
define('INSHIP_OEMKEY_40', '');
define('INSHIP_OEMKEY_45', '');
define('INSHIP_OEMKEY_41', '');
define('INSHIP_OEMKEY_42', '');
define('INSHIP_OEMKEY_43', '');
define('INSHIP_OEMKEY_44', '');

class Shippingcalculator extends \Magento\Framework\App\Action\Action
{
	protected $_fileUploaderFactory;
    public function __construct(
        \Magento\Framework\App\Action\Context $context
        
    ) {
        $this->_request = $context->getRequest();
        return parent::__construct($context);
    }
     
    public function execute()
    {
		$rates 		= new InShip_FedExRates();
		$zipcode	= $this->_request->getParam("zipcode");
		$zipcode2	= $this->_request->getParam("zipcode2");
		$leaddate	= $this->_request->getParam("leadtime");
		


		$now = time(); // or your date as well
		$your_date = strtotime($leaddate." 00:00:00");
		$datediff = $your_date-$now;

 



		$leadtime	= ceil($datediff / (60 * 60 * 24));
		if($leadtime	=='')
		{
			$leadtime	= 1;
		}
		
		$ship_date	= '';
		$leadtime	= $leadtime+2;
		if($zipcode!='')
		{
			//$rates->doReset();

			$rates->setFedExServer("https://gatewaybeta.fedex.com:443/web-services");
			//$rates->setFedExServer("https://gateway.fedex.com:443/xml");
			$rates->setRuntimeLicense("4258504241414E5852464155484235363334000000000000000000000000000000000000000000003030303030303030000052304A5A5250564B454E54340000");
			
			$rates->setFedExDeveloperKey('MLq7WcrnTDSK2yzM');
			$rates->setFedExPassword('5aXYj8AupPa8Ufqv2jewiZA7W');
			$rates->setFedExAccountNumber('510087640');
			$rates->setFedExMeterNumber('118878512');
			//$rates->setShipDate('18/11/2017');
			//$rates->setSenderState('NC');
			//$rates->setSenderZipCode('27713');
			$rates->setSenderCountryCode('US');
			$rates->setSenderZipCode($zipcode2);

			//$rates->setRecipientState('NY');
			$rates->setRecipientZipCode($zipcode);
			$rates->setRecipientCountryCode('US');
			$rates->setTotalWeight(1);

			$rates->setDropoffType(0);
			$rates->setRequestedService(15);

			$rates->setPackageCount(1);
			$rates->setPackageType(0,31);
			$rates->setPackageWidth(0,2);
			$rates->setPackageHeight(0,2);
			$rates->setPackageLength(0,2);

			$rates->doGetRates();

			//echo "==".$rates->getServiceCount()."==";

			for($i = 0; $i < $rates->getServiceCount();$i++){
				$ship_date	=  $rates->getServiceDeliveryDate($i);
					//echo "--<tr><td>" . $rates->getServiceDeliveryDate($i) . "==</td>";
					//echo "<td>" . $rates->getServiceTypeDescription($i) . "==</td>";
					//echo "<td>" . $rates->getServiceAccountNetcharge($i) . "==</td></tr>";
			}

			if($rates->doConfig("Warning") != "") {
				//echo "<br><center><b><font color='red'>" . $rates->doConfig("Warning") . "</font></b></center>";
			}
		}
		if($ship_date!='')
			$ship_date = strtotime("+".$leadtime." days", strtotime($ship_date));
		else
			$ship_date = strtotime("+".$leadtime." days", time());
		echo date("m-d-Y", $ship_date);
		//die("dsfkjkjsdf");
		//$result= json_encode("ship_date"=>date("Y-m-d", $ship_date));
		//return  $result;
	}
		
}
    

class InShip_FedExRates {
  
  var $handle;

  public function __construct() {
    $this->handle = inship_fedexrates_open(INSHIP_OEMKEY_21);
    inship_fedexrates_register_callback($this->handle, 1, array($this, 'fireError'));
    inship_fedexrates_register_callback($this->handle, 2, array($this, 'fireNotification'));
    inship_fedexrates_register_callback($this->handle, 3, array($this, 'fireSSLServerAuthentication'));
    inship_fedexrates_register_callback($this->handle, 4, array($this, 'fireSSLStatus'));
  }
  
  public function __destruct() {
    inship_fedexrates_close($this->handle);
  }

 /**
  * Returns the last error code.
  *
  * @access   public
  */
  public function lastError() {
    return inship_fedexrates_get_last_error($this->handle);
  }
  
 /**
  * Returns the last error message.
  *
  * @access   public
  */
  public function lastErrorCode() {
    return inship_fedexrates_get_last_error_code($this->handle);
  }

 /**
  * Sets or retrieves a configuration setting .
  *
  * @access   public
  * @param    string    configurationstring
  */
  public function doConfig($configurationstring) {
    $ret = inship_fedexrates_do_config($this->handle, $configurationstring);
		$err = inship_fedexrates_get_last_error_code($this->handle);
    if ($err != 0) {
      //throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Returns rate information for a specified or all available FedEx services.
  *
  * @access   public
  */
  public function doGetRates() {
    $ret = inship_fedexrates_do_getrates($this->handle);
		$err = $ret;

    if ($err != 0) {
     // throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Resets the internal state of the component and all properties to their default values.
  *
  * @access   public
  */
  public function doReset() {
    $ret = inship_fedexrates_do_reset($this->handle);
		$err = $ret;

    if ($err != 0) {
		//echo "223===".inship_fedexrates_get_last_error($this->handle)."==";

      //throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

   

public function VERSION() {
    return inship_fedexrates_get($this->handle, 0);
  }
 /**
  * The total amount to be collected on delivery.
  *
  * @access   public
  */
  public function getCODTotalAmount() {
    return inship_fedexrates_get($this->handle, 1 );
  }
 /**
  * The total amount to be collected on delivery.
  *
  * @access   public
  * @param    string   value
  */
  public function setCODTotalAmount($value) {
    $ret = inship_fedexrates_set($this->handle, 1, $value );
    if ($ret != 0) {
//	echo "252===".inship_fedexrates_get_last_error($this->handle)."==";

      //throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * COD type.
  *
  * @access   public
  */
  public function getCODType() {
    return inship_fedexrates_get($this->handle, 2 );
  }
 /**
  * COD type.
  *
  * @access   public
  * @param    int   value
  */
  public function setCODType($value) {
    $ret = inship_fedexrates_set($this->handle, 2, $value );
    if ($ret != 0) {
//	echo "276===".inship_fedexrates_get_last_error($this->handle)."==";

//      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the method by which the package is to be tendered to FedEx.
  *
  * @access   public
  */
  public function getDropoffType() {
    return inship_fedexrates_get($this->handle, 3 );
  }
 /**
  * Identifies the method by which the package is to be tendered to FedEx.
  *
  * @access   public
  * @param    int   value
  */
  public function setDropoffType($value) {
    $ret = inship_fedexrates_set($this->handle, 3, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Account number for logging in to the FedEx Server .
  *
  * @access   public
  */
  public function getFedExAccountNumber() {
    return inship_fedexrates_get($this->handle, 4 );
  }
 /**
  * Account number for logging in to the FedEx Server .
  *
  * @access   public
  * @param    string   value
  */
  public function setFedExAccountNumber($value) {
    $ret = inship_fedexrates_set($this->handle, 4, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the CSP product.
  *
  * @access   public
  */
  public function getFedExCSPProductId() {
    return inship_fedexrates_get($this->handle, 5 );
  }
 /**
  * Identifies the CSP product.
  *
  * @access   public
  * @param    string   value
  */
  public function setFedExCSPProductId($value) {
    $ret = inship_fedexrates_set($this->handle, 5, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the CSP product version.
  *
  * @access   public
  */
  public function getFedExCSPProductVersion() {
    return inship_fedexrates_get($this->handle, 6 );
  }
 /**
  * Identifies the CSP product version.
  *
  * @access   public
  * @param    string   value
  */
  public function setFedExCSPProductVersion($value) {
    $ret = inship_fedexrates_set($this->handle, 6, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * CSP end user key.
  *
  * @access   public
  */
  public function getFedExCSPUserKey() {
    return inship_fedexrates_get($this->handle, 7 );
  }
 /**
  * CSP end user key.
  *
  * @access   public
  * @param    string   value
  */
  public function setFedExCSPUserKey($value) {
    $ret = inship_fedexrates_set($this->handle, 7, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * CSP end user password.
  *
  * @access   public
  */
  public function getFedExCSPUserPassword() {
    return inship_fedexrates_get($this->handle, 8 );
  }
 /**
  * CSP end user password.
  *
  * @access   public
  * @param    string   value
  */
  public function setFedExCSPUserPassword($value) {
    $ret = inship_fedexrates_set($this->handle, 8, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifying part of the authentication key used for the sender's identity.
  *
  * @access   public
  */
  public function getFedExDeveloperKey() {
    return inship_fedexrates_get($this->handle, 9 );
  }
 /**
  * Identifying part of the authentication key used for the sender's identity.
  *
  * @access   public
  * @param    string   value
  */
  public function setFedExDeveloperKey($value) {
    $ret = inship_fedexrates_set($this->handle, 9, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Meter number to use for submitting requests to the FedEx Server .
  *
  * @access   public
  */
  public function getFedExMeterNumber() {
    return inship_fedexrates_get($this->handle, 10 );
  }
 /**
  * Meter number to use for submitting requests to the FedEx Server .
  *
  * @access   public
  * @param    string   value
  */
  public function setFedExMeterNumber($value) {
    $ret = inship_fedexrates_set($this->handle, 10, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Secret part of authentication key used for the sender's identity.
  *
  * @access   public
  */
  public function getFedExPassword() {
    return inship_fedexrates_get($this->handle, 11 );
  }
 /**
  * Secret part of authentication key used for the sender's identity.
  *
  * @access   public
  * @param    string   value
  */
  public function setFedExPassword($value) {
    $ret = inship_fedexrates_set($this->handle, 11, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * URL for the FedEx Server where the requests are sent.
  *
  * @access   public
  */
  public function getFedExServer() {
    return inship_fedexrates_get($this->handle, 12 );
  }
 /**
  * URL for the FedEx Server where the requests are sent.
  *
  * @access   public
  * @param    string   value
  */
  public function setFedExServer($value) {
    $ret = inship_fedexrates_set($this->handle, 12, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property tells the component whether or not to automatically detect and use firewall system settings, if available.
  *
  * @access   public
  */
  public function getFirewallAutoDetect() {
    return inship_fedexrates_get($this->handle, 13 );
  }
 /**
  * This property tells the component whether or not to automatically detect and use firewall system settings, if available.
  *
  * @access   public
  * @param    boolean   value
  */
  public function setFirewallAutoDetect($value) {
    $ret = inship_fedexrates_set($this->handle, 13, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property determines the type of firewall to connect through.
  *
  * @access   public
  */
  public function getFirewallType() {
    return inship_fedexrates_get($this->handle, 14 );
  }
 /**
  * This property determines the type of firewall to connect through.
  *
  * @access   public
  * @param    int   value
  */
  public function setFirewallType($value) {
    $ret = inship_fedexrates_set($this->handle, 14, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property contains the name or IP address of firewall (optional).
  *
  * @access   public
  */
  public function getFirewallHost() {
    return inship_fedexrates_get($this->handle, 15 );
  }
 /**
  * This property contains the name or IP address of firewall (optional).
  *
  * @access   public
  * @param    string   value
  */
  public function setFirewallHost($value) {
    $ret = inship_fedexrates_set($this->handle, 15, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property contains a password if authentication is to be used when connecting through the firewall.
  *
  * @access   public
  */
  public function getFirewallPassword() {
    return inship_fedexrates_get($this->handle, 16 );
  }
 /**
  * This property contains a password if authentication is to be used when connecting through the firewall.
  *
  * @access   public
  * @param    string   value
  */
  public function setFirewallPassword($value) {
    $ret = inship_fedexrates_set($this->handle, 16, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property contains the TCP port for the firewall Host .
  *
  * @access   public
  */
  public function getFirewallPort() {
    return inship_fedexrates_get($this->handle, 17 );
  }
 /**
  * This property contains the TCP port for the firewall Host .
  *
  * @access   public
  * @param    int   value
  */
  public function setFirewallPort($value) {
    $ret = inship_fedexrates_set($this->handle, 17, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property contains a user name if authentication is to be used connecting through a firewall.
  *
  * @access   public
  */
  public function getFirewallUser() {
    return inship_fedexrates_get($this->handle, 18 );
  }
 /**
  * This property contains a user name if authentication is to be used connecting through a firewall.
  *
  * @access   public
  * @param    string   value
  */
  public function setFirewallUser($value) {
    $ret = inship_fedexrates_set($this->handle, 18, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The date the freight shipment is guaranteed for.
  *
  * @access   public
  */
  public function getFreightGuaranteeDate() {
    return inship_fedexrates_get($this->handle, 19 );
  }
 /**
  * The date the freight shipment is guaranteed for.
  *
  * @access   public
  * @param    string   value
  */
  public function setFreightGuaranteeDate($value) {
    $ret = inship_fedexrates_set($this->handle, 19, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Specifies what type of freight guarantee is requested.
  *
  * @access   public
  */
  public function getFreightGuaranteeType() {
    return inship_fedexrates_get($this->handle, 20 );
  }
 /**
  * Specifies what type of freight guarantee is requested.
  *
  * @access   public
  * @param    int   value
  */
  public function setFreightGuaranteeType($value) {
    $ret = inship_fedexrates_set($this->handle, 20, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Date for Ground Home Delivery service.
  *
  * @access   public
  */
  public function getHomeDeliveryDate() {
    return inship_fedexrates_get($this->handle, 21 );
  }
 /**
  * Date for Ground Home Delivery service.
  *
  * @access   public
  * @param    string   value
  */
  public function setHomeDeliveryDate($value) {
    $ret = inship_fedexrates_set($this->handle, 21, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The phone number of the delivery location.
  *
  * @access   public
  */
  public function getHomeDeliveryPhone() {
    return inship_fedexrates_get($this->handle, 22 );
  }
 /**
  * The phone number of the delivery location.
  *
  * @access   public
  * @param    string   value
  */
  public function setHomeDeliveryPhone($value) {
    $ret = inship_fedexrates_set($this->handle, 22, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The type of Home Delivery Premium service being requested.
  *
  * @access   public
  */
  public function getHomeDeliveryType() {
    return inship_fedexrates_get($this->handle, 23 );
  }
 /**
  * The type of Home Delivery Premium service being requested.
  *
  * @access   public
  * @param    int   value
  */
  public function setHomeDeliveryType($value) {
    $ret = inship_fedexrates_set($this->handle, 23, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The total amount of insurance requested for the shipment being rated.
  *
  * @access   public
  */
  public function getInsuredValue() {
    return inship_fedexrates_get($this->handle, 24 );
  }
 /**
  * The total amount of insurance requested for the shipment being rated.
  *
  * @access   public
  * @param    string   value
  */
  public function setInsuredValue($value) {
    $ret = inship_fedexrates_set($this->handle, 24, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The number of records in the Package arrays.
  *
  * @access   public
  */
  public function getPackageCount() {
    return inship_fedexrates_get($this->handle, 25 );
  }
 /**
  * The number of records in the Package arrays.
  *
  * @access   public
  * @param    int   value
  */
  public function setPackageCount($value) {
    $ret = inship_fedexrates_set($this->handle, 25, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The COD monetary value for the package.
  *
  * @access   public
  */
  public function getPackageCODAmount($packageidx) {
    return inship_fedexrates_get($this->handle, 26 , $packageidx);
  }
 /**
  * The COD monetary value for the package.
  *
  * @access   public
  * @param    string   value
  */
  public function setPackageCODAmount($packageidx, $value) {
    $ret = inship_fedexrates_set($this->handle, 26, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The code that indicates the type of funds that will be used for the COD payment for this package.
  *
  * @access   public
  */
  public function getPackageCODType($packageidx) {
    return inship_fedexrates_get($this->handle, 27 , $packageidx);
  }
 /**
  * The code that indicates the type of funds that will be used for the COD payment for this package.
  *
  * @access   public
  * @param    int   value
  */
  public function setPackageCODType($packageidx, $value) {
    $ret = inship_fedexrates_set($this->handle, 27, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The height of the package to be shipped.
  *
  * @access   public
  */
  public function getPackageHeight($packageidx) {
    return inship_fedexrates_get($this->handle, 28 , $packageidx);
  }
 /**
  * The height of the package to be shipped.
  *
  * @access   public
  * @param    int   value
  */
  public function setPackageHeight($packageidx, $value) {
    $ret = inship_fedexrates_set($this->handle, 28, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Amount of insurance requested for this package.
  *
  * @access   public
  */
  public function getPackageInsuredValue($packageidx) {
    return inship_fedexrates_get($this->handle, 29 , $packageidx);
  }
 /**
  * Amount of insurance requested for this package.
  *
  * @access   public
  * @param    string   value
  */
  public function setPackageInsuredValue($packageidx, $value) {
    $ret = inship_fedexrates_set($this->handle, 29, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The length of the package to be shipped.
  *
  * @access   public
  */
  public function getPackageLength($packageidx) {
    return inship_fedexrates_get($this->handle, 30 , $packageidx);
  }
 /**
  * The length of the package to be shipped.
  *
  * @access   public
  * @param    int   value
  */
  public function setPackageLength($packageidx, $value) {
    $ret = inship_fedexrates_set($this->handle, 30, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The packaging type of the package being rated and/or shipped.
  *
  * @access   public
  */
  public function getPackageType($packageidx) {
    return inship_fedexrates_get($this->handle, 31 , $packageidx);
  }
 /**
  * The packaging type of the package being rated and/or shipped.
  *
  * @access   public
  * @param    int   value
  */
  public function setPackageType($packageidx, $value) {
    $ret = inship_fedexrates_set($this->handle, 31, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Specifies one of the Delivery Signature Options requested for this package.
  *
  * @access   public
  */
  public function getPackageSignatureType($packageidx) {
    return inship_fedexrates_get($this->handle, 32 , $packageidx);
  }
 /**
  * Specifies one of the Delivery Signature Options requested for this package.
  *
  * @access   public
  * @param    int   value
  */
  public function setPackageSignatureType($packageidx, $value) {
    $ret = inship_fedexrates_set($this->handle, 32, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Contains the collection of special services offered on the package level.
  *
  * @access   public
  */
  public function getPackageSpecialServices($packageidx) {
    return inship_fedexrates_get($this->handle, 33 , $packageidx);
  }
 /**
  * Contains the collection of special services offered on the package level.
  *
  * @access   public
  * @param    int64   value
  */
  public function setPackageSpecialServices($packageidx, $value) {
    $ret = inship_fedexrates_set($this->handle, 33, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Weight of this package.
  *
  * @access   public
  */
  public function getPackageWeight($packageidx) {
    return inship_fedexrates_get($this->handle, 34 , $packageidx);
  }
 /**
  * Weight of this package.
  *
  * @access   public
  * @param    string   value
  */
  public function setPackageWeight($packageidx, $value) {
    $ret = inship_fedexrates_set($this->handle, 34, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The width of the package to be shipped.
  *
  * @access   public
  */
  public function getPackageWidth($packageidx) {
    return inship_fedexrates_get($this->handle, 35 , $packageidx);
  }
 /**
  * The width of the package to be shipped.
  *
  * @access   public
  * @param    int   value
  */
  public function setPackageWidth($packageidx, $value) {
    $ret = inship_fedexrates_set($this->handle, 35, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property is used to tell the component which  type of authorization to perform when connecting to the proxy.
  *
  * @access   public
  */
  public function getProxyAuthScheme() {
    return inship_fedexrates_get($this->handle, 36 );
  }
 /**
  * This property is used to tell the component which  type of authorization to perform when connecting to the proxy.
  *
  * @access   public
  * @param    int   value
  */
  public function setProxyAuthScheme($value) {
    $ret = inship_fedexrates_set($this->handle, 36, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property tells the component whether or not to automatically detect and use proxy system settings, if available.
  *
  * @access   public
  */
  public function getProxyAutoDetect() {
    return inship_fedexrates_get($this->handle, 37 );
  }
 /**
  * This property tells the component whether or not to automatically detect and use proxy system settings, if available.
  *
  * @access   public
  * @param    boolean   value
  */
  public function setProxyAutoDetect($value) {
    $ret = inship_fedexrates_set($this->handle, 37, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property contains a password if authentication is to be used for the proxy.
  *
  * @access   public
  */
  public function getProxyPassword() {
    return inship_fedexrates_get($this->handle, 38 );
  }
 /**
  * This property contains a password if authentication is to be used for the proxy.
  *
  * @access   public
  * @param    string   value
  */
  public function setProxyPassword($value) {
    $ret = inship_fedexrates_set($this->handle, 38, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property contains the TCP port for the proxy Server (default 80).
  *
  * @access   public
  */
  public function getProxyPort() {
    return inship_fedexrates_get($this->handle, 39 );
  }
 /**
  * This property contains the TCP port for the proxy Server (default 80).
  *
  * @access   public
  * @param    int   value
  */
  public function setProxyPort($value) {
    $ret = inship_fedexrates_set($this->handle, 39, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * If a proxy Server is given, then the HTTP request is sent to the proxy instead of the server otherwise specified.
  *
  * @access   public
  */
  public function getProxyServer() {
    return inship_fedexrates_get($this->handle, 40 );
  }
 /**
  * If a proxy Server is given, then the HTTP request is sent to the proxy instead of the server otherwise specified.
  *
  * @access   public
  * @param    string   value
  */
  public function setProxyServer($value) {
    $ret = inship_fedexrates_set($this->handle, 40, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property determines when to use SSL for the connection to the proxy.
  *
  * @access   public
  */
  public function getProxySSL() {
    return inship_fedexrates_get($this->handle, 41 );
  }
 /**
  * This property determines when to use SSL for the connection to the proxy.
  *
  * @access   public
  * @param    int   value
  */
  public function setProxySSL($value) {
    $ret = inship_fedexrates_set($this->handle, 41, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property contains a user name, if authentication is to be used for the proxy.
  *
  * @access   public
  */
  public function getProxyUser() {
    return inship_fedexrates_get($this->handle, 42 );
  }
 /**
  * This property contains a user name, if authentication is to be used for the proxy.
  *
  * @access   public
  * @param    string   value
  */
  public function setProxyUser($value) {
    $ret = inship_fedexrates_set($this->handle, 42, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Indicates the type of rates to be returned.
  *
  * @access   public
  */
  public function getRateType() {
    return inship_fedexrates_get($this->handle, 43 );
  }
 /**
  * Indicates the type of rates to be returned.
  *
  * @access   public
  * @param    int   value
  */
  public function setRateType($value) {
    $ret = inship_fedexrates_set($this->handle, 43, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Street name.
  *
  * @access   public
  */
  public function getRecipientAddress1() {
    return inship_fedexrates_get($this->handle, 44 );
  }
 /**
  * Street name.
  *
  * @access   public
  * @param    string   value
  */
  public function setRecipientAddress1($value) {
    $ret = inship_fedexrates_set($this->handle, 44, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * A specific detail on the address (such as building, suite, apartment, floor number etc.
  *
  * @access   public
  */
  public function getRecipientAddress2() {
    return inship_fedexrates_get($this->handle, 45 );
  }
 /**
  * A specific detail on the address (such as building, suite, apartment, floor number etc.
  *
  * @access   public
  * @param    string   value
  */
  public function setRecipientAddress2($value) {
    $ret = inship_fedexrates_set($this->handle, 45, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Various flags that denote information about the address.
  *
  * @access   public
  */
  public function getRecipientAddressFlags() {
    return inship_fedexrates_get($this->handle, 46 );
  }
 /**
  * Various flags that denote information about the address.
  *
  * @access   public
  * @param    int   value
  */
  public function setRecipientAddressFlags($value) {
    $ret = inship_fedexrates_set($this->handle, 46, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Name of city, town, etc.
  *
  * @access   public
  */
  public function getRecipientCity() {
    return inship_fedexrates_get($this->handle, 47 );
  }
 /**
  * Name of city, town, etc.
  *
  * @access   public
  * @param    string   value
  */
  public function setRecipientCity($value) {
    $ret = inship_fedexrates_set($this->handle, 47, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Country code.
  *
  * @access   public
  */
  public function getRecipientCountryCode() {
    return inship_fedexrates_get($this->handle, 48 );
  }
 /**
  * Country code.
  *
  * @access   public
  * @param    string   value
  */
  public function setRecipientCountryCode($value) {
    $ret = inship_fedexrates_set($this->handle, 48, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * State or province code.
  *
  * @access   public
  */
  public function getRecipientState() {
    return inship_fedexrates_get($this->handle, 49 );
  }
 /**
  * State or province code.
  *
  * @access   public
  * @param    string   value
  */
  public function setRecipientState($value) {
    $ret = inship_fedexrates_set($this->handle, 49, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Postal code.
  *
  * @access   public
  */
  public function getRecipientZipCode() {
    return inship_fedexrates_get($this->handle, 50 );
  }
 /**
  * Postal code.
  *
  * @access   public
  * @param    string   value
  */
  public function setRecipientZipCode($value) {
    $ret = inship_fedexrates_set($this->handle, 50, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Service type for which the shipping rate is requested.
  *
  * @access   public
  */
  public function getRequestedService() {
    return inship_fedexrates_get($this->handle, 51 );
  }
 /**
  * Service type for which the shipping rate is requested.
  *
  * @access   public
  * @param    int   value
  */
  public function setRequestedService($value) {
    $ret = inship_fedexrates_set($this->handle, 51, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Street name.
  *
  * @access   public
  */
  public function getSenderAddress1() {
    return inship_fedexrates_get($this->handle, 52 );
  }
 /**
  * Street name.
  *
  * @access   public
  * @param    string   value
  */
  public function setSenderAddress1($value) {
    $ret = inship_fedexrates_set($this->handle, 52, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * A specific detail on the address (such as building, suite, apartment, floor number etc.
  *
  * @access   public
  */
  public function getSenderAddress2() {
    return inship_fedexrates_get($this->handle, 53 );
  }
 /**
  * A specific detail on the address (such as building, suite, apartment, floor number etc.
  *
  * @access   public
  * @param    string   value
  */
  public function setSenderAddress2($value) {
    $ret = inship_fedexrates_set($this->handle, 53, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Various flags that denote information about the address.
  *
  * @access   public
  */
  public function getSenderAddressFlags() {
    return inship_fedexrates_get($this->handle, 54 );
  }
 /**
  * Various flags that denote information about the address.
  *
  * @access   public
  * @param    int   value
  */
  public function setSenderAddressFlags($value) {
    $ret = inship_fedexrates_set($this->handle, 54, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Name of city, town, etc.
  *
  * @access   public
  */
  public function getSenderCity() {
    return inship_fedexrates_get($this->handle, 55 );
  }
 /**
  * Name of city, town, etc.
  *
  * @access   public
  * @param    string   value
  */
  public function setSenderCity($value) {
    $ret = inship_fedexrates_set($this->handle, 55, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Country code.
  *
  * @access   public
  */
  public function getSenderCountryCode() {
    return inship_fedexrates_get($this->handle, 56 );
  }
 /**
  * Country code.
  *
  * @access   public
  * @param    string   value
  */
  public function setSenderCountryCode($value) {
    $ret = inship_fedexrates_set($this->handle, 56, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * State or province code.
  *
  * @access   public
  */
  public function getSenderState() {
    return inship_fedexrates_get($this->handle, 57 );
  }
 /**
  * State or province code.
  *
  * @access   public
  * @param    string   value
  */
  public function setSenderState($value) {
    $ret = inship_fedexrates_set($this->handle, 57, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Postal code.
  *
  * @access   public
  */
  public function getSenderZipCode() {
    return inship_fedexrates_get($this->handle, 58 );
  }
 /**
  * Postal code.
  *
  * @access   public
  * @param    string   value
  */
  public function setSenderZipCode($value) {
    $ret = inship_fedexrates_set($this->handle, 58, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The number of records in the Service arrays.
  *
  * @access   public
  */
  public function getServiceCount() {
    return inship_fedexrates_get($this->handle, 59 );
  }


 /**
  * Transportation charges before surcharges and discounts applied to a ServiceType .
  *
  * @access   public
  */
  public function getServiceAccountBaseCharge($serviceidx) {
    return inship_fedexrates_get($this->handle, 60 , $serviceidx);
  }


 /**
  * Net charge amount applied to a ServiceType .
  *
  * @access   public
  */
  public function getServiceAccountNetCharge($serviceidx) {
    return inship_fedexrates_get($this->handle, 61 , $serviceidx);
  }


 /**
  * Total discount amount applied to the shipment for a ServiceType .
  *
  * @access   public
  */
  public function getServiceAccountTotalDiscount($serviceidx) {
    return inship_fedexrates_get($this->handle, 62 , $serviceidx);
  }


 /**
  * Total surcharge amount for all additional services applied to a ServiceType .
  *
  * @access   public
  */
  public function getServiceAccountTotalSurcharge($serviceidx) {
    return inship_fedexrates_get($this->handle, 63 , $serviceidx);
  }


 /**
  * Aggregate of details and rates for the ServiceType in the list of available services.
  *
  * @access   public
  */
  public function getServiceAggregate($serviceidx) {
    return inship_fedexrates_get($this->handle, 64 , $serviceidx);
  }


 /**
  * This indicates the shipment delivery date for the ServiceType .
  *
  * @access   public
  */
  public function getServiceDeliveryDate($serviceidx) {
    return inship_fedexrates_get($this->handle, 65 , $serviceidx);
  }


 /**
  * Indicates the day of the week the shipment can be delivered when using the ServiceType .
  *
  * @access   public
  */
  public function getServiceDeliveryDay($serviceidx) {
    return inship_fedexrates_get($this->handle, 66 , $serviceidx);
  }


 /**
  * Indicates the net discount applied to a ServiceType .
  *
  * @access   public
  */
  public function getServiceEffectiveNetDiscount($serviceidx) {
    return inship_fedexrates_get($this->handle, 67 , $serviceidx);
  }


 /**
  * Transportation charges before surcharges and discounts applied to a ServiceType .
  *
  * @access   public
  */
  public function getServiceListBaseCharge($serviceidx) {
    return inship_fedexrates_get($this->handle, 68 , $serviceidx);
  }


 /**
  * Net charge amount applied to a ServiceType .
  *
  * @access   public
  */
  public function getServiceListNetCharge($serviceidx) {
    return inship_fedexrates_get($this->handle, 69 , $serviceidx);
  }


 /**
  * Total discount amount applied to a ServiceType .
  *
  * @access   public
  */
  public function getServiceListTotalDiscount($serviceidx) {
    return inship_fedexrates_get($this->handle, 70 , $serviceidx);
  }


 /**
  * Total surcharge amount for all additional services applied to a ServiceType .
  *
  * @access   public
  */
  public function getServiceListTotalSurcharge($serviceidx) {
    return inship_fedexrates_get($this->handle, 71 , $serviceidx);
  }


 /**
  * Applicable rate scale for the ServiceType .
  *
  * @access   public
  */
  public function getServiceRateScale($serviceidx) {
    return inship_fedexrates_get($this->handle, 72 , $serviceidx);
  }


 /**
  * Applicable rate zone for the ServiceType .
  *
  * @access   public
  */
  public function getServiceRateZone($serviceidx) {
    return inship_fedexrates_get($this->handle, 73 , $serviceidx);
  }


 /**
  * Indicates the service type in the list of available services returned.
  *
  * @access   public
  */
  public function getServiceType($serviceidx) {
    return inship_fedexrates_get($this->handle, 74 , $serviceidx);
  }


 /**
  * Indicates the textual description of a service type in the list of available services returned.
  *
  * @access   public
  */
  public function getServiceTypeDescription($serviceidx) {
    return inship_fedexrates_get($this->handle, 75 , $serviceidx);
  }


 /**
  * Indicates the textual description of the delivery signature services option required by FedEx for the ServiceType .
  *
  * @access   public
  */
  public function getServiceSignatureType($serviceidx) {
    return inship_fedexrates_get($this->handle, 76 , $serviceidx);
  }


 /**
  * Expected number of days in transit from pickup to delivery for the ServiceType .
  *
  * @access   public
  */
  public function getServiceTransitTime($serviceidx) {
    return inship_fedexrates_get($this->handle, 77 , $serviceidx);
  }


 /**
  * The date on which the package will be shipped.
  *
  * @access   public
  */
  public function getShipDate() {
    return inship_fedexrates_get($this->handle, 78 );
  }
 /**
  * The date on which the package will be shipped.
  *
  * @access   public
  * @param    string   value
  */
  public function setShipDate($value) {
    $ret = inship_fedexrates_set($this->handle, 78, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Contains the collection of special services offered by FedEx.
  *
  * @access   public
  */
  public function getShipmentSpecialServices() {
    return inship_fedexrates_get($this->handle, 79 );
  }
 /**
  * Contains the collection of special services offered by FedEx.
  *
  * @access   public
  * @param    int64   value
  */
  public function setShipmentSpecialServices($value) {
    $ret = inship_fedexrates_set($this->handle, 79, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The certificate (PEM/base64 encoded).
  *
  * @access   public
  */
  public function getSSLAcceptServerCertEncoded() {
    return inship_fedexrates_get($this->handle, 80 );
  }
 /**
  * The certificate (PEM/base64 encoded).
  *
  * @access   public
  * @param    string   value
  */
  public function setSSLAcceptServerCertEncoded($value) {
    $ret = inship_fedexrates_set($this->handle, 80, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The certificate (PEM/base64 encoded).
  *
  * @access   public
  */
  public function getSSLCertEncoded() {
    return inship_fedexrates_get($this->handle, 81 );
  }
 /**
  * The certificate (PEM/base64 encoded).
  *
  * @access   public
  * @param    string   value
  */
  public function setSSLCertEncoded($value) {
    $ret = inship_fedexrates_set($this->handle, 81, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The name of the certificate store for the client certificate.
  *
  * @access   public
  */
  public function getSSLCertStore() {
    return inship_fedexrates_get($this->handle, 82 );
  }
 /**
  * The name of the certificate store for the client certificate.
  *
  * @access   public
  * @param    string   value
  */
  public function setSSLCertStore($value) {
    $ret = inship_fedexrates_set($this->handle, 82, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * If the certificate store is of a type that requires  a password, this property is used to specify that  password in order to open the certificate store.
  *
  * @access   public
  */
  public function getSSLCertStorePassword() {
    return inship_fedexrates_get($this->handle, 83 );
  }
 /**
  * If the certificate store is of a type that requires  a password, this property is used to specify that  password in order to open the certificate store.
  *
  * @access   public
  * @param    string   value
  */
  public function setSSLCertStorePassword($value) {
    $ret = inship_fedexrates_set($this->handle, 83, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The type of certificate store for this certificate.
  *
  * @access   public
  */
  public function getSSLCertStoreType() {
    return inship_fedexrates_get($this->handle, 84 );
  }
 /**
  * The type of certificate store for this certificate.
  *
  * @access   public
  * @param    int   value
  */
  public function setSSLCertStoreType($value) {
    $ret = inship_fedexrates_set($this->handle, 84, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The subject of the certificate used for client authentication.
  *
  * @access   public
  */
  public function getSSLCertSubject() {
    return inship_fedexrates_get($this->handle, 85 );
  }
 /**
  * The subject of the certificate used for client authentication.
  *
  * @access   public
  * @param    string   value
  */
  public function setSSLCertSubject($value) {
    $ret = inship_fedexrates_set($this->handle, 85, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The certificate (PEM/base64 encoded).
  *
  * @access   public
  */
  public function getSSLServerCertEncoded() {
    return inship_fedexrates_get($this->handle, 86 );
  }


 /**
  * A timeout for the component.
  *
  * @access   public
  */
  public function getTimeout() {
    return inship_fedexrates_get($this->handle, 87 );
  }
 /**
  * A timeout for the component.
  *
  * @access   public
  * @param    int   value
  */
  public function setTimeout($value) {
    $ret = inship_fedexrates_set($this->handle, 87, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The total weight of all the pieces in this shipment.
  *
  * @access   public
  */
  public function getTotalWeight() {
    return inship_fedexrates_get($this->handle, 88 );
  }
 /**
  * The total weight of all the pieces in this shipment.
  *
  * @access   public
  * @param    string   value
  */
  public function setTotalWeight($value) {
    $ret = inship_fedexrates_set($this->handle, 88, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexrates_get_last_error($this->handle));
    }
    return $ret;
  }



  public function getRuntimeLicense() {
    return inship_fedexrates_get($this->handle, 2011 );
  }

  public function setRuntimeLicense($value) {
    $ret = inship_fedexrates_set($this->handle, 2011, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . ipworkszip_zip_get_last_error($this->handle));
    }
    return $ret;
  }
  
 /**
  * Information about errors during data delivery.
  *
  * @access   public
  * @param    array   Array of event parameters: errorcode, description    
  */
  public function fireError($param) {
    return $param;
  }

 /**
  * Notification returned by the server upon successful request (if applicable).
  *
  * @access   public
  * @param    array   Array of event parameters: message    
  */
  public function fireNotification($param) {
    return $param;
  }

 /**
  * Fired after the server presents its certificate to the client.
  *
  * @access   public
  * @param    array   Array of event parameters: certencoded, certsubject, certissuer, status, accept    
  */
  public function fireSSLServerAuthentication($param) {
    return $param;
  }

 /**
  * Shows the progress of the secure connection.
  *
  * @access   public
  * @param    array   Array of event parameters: message    
  */
  public function fireSSLStatus($param) {
    return $param;
  }


}
