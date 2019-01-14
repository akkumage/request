<?php

/**
 * Shipping Integrator 2016 PHP Edition - FedExShip Component
 *
 * Copyright (c) 2017 /n software inc. - All rights reserved.
 *
 * For more information, please visit http://www.nsoftware.com/.
 *
 */

class InShip_FedExShip {
  
  var $handle;

  public function __construct() {
    $this->handle = inship_fedexship_open('');
    inship_fedexship_register_callback($this->handle, 1, array($this, 'fireError'));
    inship_fedexship_register_callback($this->handle, 2, array($this, 'fireNotification'));
    inship_fedexship_register_callback($this->handle, 3, array($this, 'fireSSLServerAuthentication'));
    inship_fedexship_register_callback($this->handle, 4, array($this, 'fireSSLStatus'));
  }
  
  public function __destruct() {
    inship_fedexship_close($this->handle);
  }

 /**
  * Returns the last error code.
  *
  * @access   public
  */
  public function lastError() {
    return inship_fedexship_get_last_error($this->handle);
  }
  
 /**
  * Returns the last error message.
  *
  * @access   public
  */
  public function lastErrorCode() {
    return inship_fedexship_get_last_error_code($this->handle);
  }

 /**
  * Cancels a single package shipment by deleting it from the shipping log.
  *
  * @access   public
  * @param    string    trackingnumber
  * @param    int    trackingidtype
  */
  public function doCancelPackage($trackingnumber, $trackingidtype) {
    $ret = inship_fedexship_do_cancelpackage($this->handle, $trackingnumber, $trackingidtype);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Cancels a scheduled Carrier Pickup request.
  *
  * @access   public
  * @param    string    confirmationnumber
  * @param    string    reason
  */
  public function doCancelPickup($confirmationnumber, $reason) {
    $ret = inship_fedexship_do_cancelpickup($this->handle, $confirmationnumber, $reason);
		$err = inship_fedexship_get_last_error_code($this->handle);
    if ($err != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Cancels a multi-package (MPS) shipment by deleting it from the shipping log.
  *
  * @access   public
  * @param    string    mastertrackingnumber
  * @param    int    trackingidtype
  */
  public function doCancelShipment($mastertrackingnumber, $trackingidtype) {
    $ret = inship_fedexship_do_cancelshipment($this->handle, $mastertrackingnumber, $trackingidtype);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Closes out all FedEx Ground shipments made for the day or generates reports for the last 3 days' close requests.
  *
  * @access   public
  */
  public function doCloseGroundShipments() {
    $ret = inship_fedexship_do_closegroundshipments($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Sets or retrieves a configuration setting .
  *
  * @access   public
  * @param    string    configurationstring
  */
  public function doConfig($configurationstring) {
    $ret = inship_fedexship_do_config($this->handle, $configurationstring);
		$err = inship_fedexship_get_last_error_code($this->handle);
    if ($err != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Uploads your CSP software version information to FedEx when you close your ship day.
  *
  * @access   public
  */
  public function doCSPVersionCapture() {
    $ret = inship_fedexship_do_cspversioncapture($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Generates a shipping label for the specified package.
  *
  * @access   public
  * @param    int    index
  */
  public function doGetPackageLabel($index) {
    $ret = inship_fedexship_do_getpackagelabel($this->handle, $index);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Generates a shipping label for all packages in the shipment.
  *
  * @access   public
  */
  public function doGetShipmentLabels() {
    $ret = inship_fedexship_do_getshipmentlabels($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Checks the availability of the courier dispatch service for the given address.
  *
  * @access   public
  */
  public function doPickupAvailability() {
    $ret = inship_fedexship_do_pickupavailability($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Reprints the requested document.
  *
  * @access   public
  */
  public function doReprintDocuments() {
    $ret = inship_fedexship_do_reprintdocuments($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Resets the internal state of the component and all properties to their default values.
  *
  * @access   public
  */
  public function doReset() {
    $ret = inship_fedexship_do_reset($this->handle);
		$err = $ret;

    if ($err != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This method schedules a courier pickup.
  *
  * @access   public
  */
  public function doSchedulePickup() {
    $ret = inship_fedexship_do_schedulepickup($this->handle);
		$err = inship_fedexship_get_last_error_code($this->handle);
    if ($err != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

   

public function VERSION() {
    return inship_fedexship_get($this->handle, 0);
  }
 /**
  * The carrier type.
  *
  * @access   public
  */
  public function getCarrierType() {
    return inship_fedexship_get($this->handle, 1 );
  }
 /**
  * The carrier type.
  *
  * @access   public
  * @param    int   value
  */
  public function setCarrierType($value) {
    $ret = inship_fedexship_set($this->handle, 1, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the date up to which the unclosed FedEx Ground shipments are to be closed.
  *
  * @access   public
  */
  public function getCloseDate() {
    return inship_fedexship_get($this->handle, 2 );
  }
 /**
  * Identifies the date up to which the unclosed FedEx Ground shipments are to be closed.
  *
  * @access   public
  * @param    string   value
  */
  public function setCloseDate($value) {
    $ret = inship_fedexship_set($this->handle, 2, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * File name of the report to be saved and/or printed by customer.
  *
  * @access   public
  */
  public function getCloseReportFile() {
    return inship_fedexship_get($this->handle, 3 );
  }
 /**
  * File name of the report to be saved and/or printed by customer.
  *
  * @access   public
  * @param    string   value
  */
  public function setCloseReportFile($value) {
    $ret = inship_fedexship_set($this->handle, 3, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Indicates what type of report(s) from the last 3 days are to be returned in a report-only close operation  request.
  *
  * @access   public
  */
  public function getCloseReportType() {
    return inship_fedexship_get($this->handle, 4 );
  }
 /**
  * Indicates what type of report(s) from the last 3 days are to be returned in a report-only close operation  request.
  *
  * @access   public
  * @param    int   value
  */
  public function setCloseReportType($value) {
    $ret = inship_fedexship_set($this->handle, 4, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the time up to which the unclosed FedEx Ground shipments are to be closed.
  *
  * @access   public
  */
  public function getCloseTime() {
    return inship_fedexship_get($this->handle, 5 );
  }
 /**
  * Identifies the time up to which the unclosed FedEx Ground shipments are to be closed.
  *
  * @access   public
  * @param    string   value
  */
  public function setCloseTime($value) {
    $ret = inship_fedexship_set($this->handle, 5, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Shipment Ground tracking number.
  *
  * @access   public
  */
  public function getCloseTrackingNumber() {
    return inship_fedexship_get($this->handle, 6 );
  }
 /**
  * Shipment Ground tracking number.
  *
  * @access   public
  * @param    string   value
  */
  public function setCloseTrackingNumber($value) {
    $ret = inship_fedexship_set($this->handle, 6, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The label that is returned.
  *
  * @access   public
  */
  public function getCODLabel() {
    return inship_fedexship_get($this->handle, 7 );
  }


 /**
  * The file the COD label should be written to.
  *
  * @access   public
  */
  public function getCODLabelFile() {
    return inship_fedexship_get($this->handle, 8 );
  }
 /**
  * The file the COD label should be written to.
  *
  * @access   public
  * @param    string   value
  */
  public function setCODLabelFile($value) {
    $ret = inship_fedexship_set($this->handle, 8, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The total amount to be collected on delivery.
  *
  * @access   public
  */
  public function getCODTotalAmount() {
    return inship_fedexship_get($this->handle, 9 );
  }
 /**
  * The total amount to be collected on delivery.
  *
  * @access   public
  * @param    string   value
  */
  public function setCODTotalAmount($value) {
    $ret = inship_fedexship_set($this->handle, 9, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Contains the tracking number for the COD return shipment.
  *
  * @access   public
  */
  public function getCODTrackingNumber() {
    return inship_fedexship_get($this->handle, 10 );
  }


 /**
  * COD type.
  *
  * @access   public
  */
  public function getCODType() {
    return inship_fedexship_get($this->handle, 11 );
  }
 /**
  * COD type.
  *
  * @access   public
  * @param    int   value
  */
  public function setCODType($value) {
    $ret = inship_fedexship_set($this->handle, 11, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The time your company closes.
  *
  * @access   public
  */
  public function getCompanyCloseTime() {
    return inship_fedexship_get($this->handle, 12 );
  }
 /**
  * The time your company closes.
  *
  * @access   public
  * @param    string   value
  */
  public function setCompanyCloseTime($value) {
    $ret = inship_fedexship_set($this->handle, 12, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Date on which shipment is expected to be delivered.
  *
  * @access   public
  */
  public function getDeliveryDate() {
    return inship_fedexship_get($this->handle, 13 );
  }


 /**
  * Identifies the method by which the package is to be tendered to FedEx.
  *
  * @access   public
  */
  public function getDropoffType() {
    return inship_fedexship_get($this->handle, 14 );
  }
 /**
  * Identifies the method by which the package is to be tendered to FedEx.
  *
  * @access   public
  * @param    int   value
  */
  public function setDropoffType($value) {
    $ret = inship_fedexship_set($this->handle, 14, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Account number for logging in to the FedEx Server .
  *
  * @access   public
  */
  public function getFedExAccountNumber() {
    return inship_fedexship_get($this->handle, 15 );
  }
 /**
  * Account number for logging in to the FedEx Server .
  *
  * @access   public
  * @param    string   value
  */
  public function setFedExAccountNumber($value) {
    $ret = inship_fedexship_set($this->handle, 15, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the CSP product.
  *
  * @access   public
  */
  public function getFedExCSPProductId() {
    return inship_fedexship_get($this->handle, 16 );
  }
 /**
  * Identifies the CSP product.
  *
  * @access   public
  * @param    string   value
  */
  public function setFedExCSPProductId($value) {
    $ret = inship_fedexship_set($this->handle, 16, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the CSP product version.
  *
  * @access   public
  */
  public function getFedExCSPProductVersion() {
    return inship_fedexship_get($this->handle, 17 );
  }
 /**
  * Identifies the CSP product version.
  *
  * @access   public
  * @param    string   value
  */
  public function setFedExCSPProductVersion($value) {
    $ret = inship_fedexship_set($this->handle, 17, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * CSP end user key.
  *
  * @access   public
  */
  public function getFedExCSPUserKey() {
    return inship_fedexship_get($this->handle, 18 );
  }
 /**
  * CSP end user key.
  *
  * @access   public
  * @param    string   value
  */
  public function setFedExCSPUserKey($value) {
    $ret = inship_fedexship_set($this->handle, 18, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * CSP end user password.
  *
  * @access   public
  */
  public function getFedExCSPUserPassword() {
    return inship_fedexship_get($this->handle, 19 );
  }
 /**
  * CSP end user password.
  *
  * @access   public
  * @param    string   value
  */
  public function setFedExCSPUserPassword($value) {
    $ret = inship_fedexship_set($this->handle, 19, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifying part of the authentication key used for the sender's identity.
  *
  * @access   public
  */
  public function getFedExDeveloperKey() {
    return inship_fedexship_get($this->handle, 20 );
  }
 /**
  * Identifying part of the authentication key used for the sender's identity.
  *
  * @access   public
  * @param    string   value
  */
  public function setFedExDeveloperKey($value) {
    $ret = inship_fedexship_set($this->handle, 20, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Meter number to use for submitting requests to the FedEx Server .
  *
  * @access   public
  */
  public function getFedExMeterNumber() {
    return inship_fedexship_get($this->handle, 21 );
  }
 /**
  * Meter number to use for submitting requests to the FedEx Server .
  *
  * @access   public
  * @param    string   value
  */
  public function setFedExMeterNumber($value) {
    $ret = inship_fedexship_set($this->handle, 21, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Secret part of authentication key used for the sender's identity.
  *
  * @access   public
  */
  public function getFedExPassword() {
    return inship_fedexship_get($this->handle, 22 );
  }
 /**
  * Secret part of authentication key used for the sender's identity.
  *
  * @access   public
  * @param    string   value
  */
  public function setFedExPassword($value) {
    $ret = inship_fedexship_set($this->handle, 22, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * URL for the FedEx Server where the requests are sent.
  *
  * @access   public
  */
  public function getFedExServer() {
    return inship_fedexship_get($this->handle, 23 );
  }
 /**
  * URL for the FedEx Server where the requests are sent.
  *
  * @access   public
  * @param    string   value
  */
  public function setFedExServer($value) {
    $ret = inship_fedexship_set($this->handle, 23, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property tells the component whether or not to automatically detect and use firewall system settings, if available.
  *
  * @access   public
  */
  public function getFirewallAutoDetect() {
    return inship_fedexship_get($this->handle, 24 );
  }
 /**
  * This property tells the component whether or not to automatically detect and use firewall system settings, if available.
  *
  * @access   public
  * @param    boolean   value
  */
  public function setFirewallAutoDetect($value) {
    $ret = inship_fedexship_set($this->handle, 24, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property determines the type of firewall to connect through.
  *
  * @access   public
  */
  public function getFirewallType() {
    return inship_fedexship_get($this->handle, 25 );
  }
 /**
  * This property determines the type of firewall to connect through.
  *
  * @access   public
  * @param    int   value
  */
  public function setFirewallType($value) {
    $ret = inship_fedexship_set($this->handle, 25, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property contains the name or IP address of firewall (optional).
  *
  * @access   public
  */
  public function getFirewallHost() {
    return inship_fedexship_get($this->handle, 26 );
  }
 /**
  * This property contains the name or IP address of firewall (optional).
  *
  * @access   public
  * @param    string   value
  */
  public function setFirewallHost($value) {
    $ret = inship_fedexship_set($this->handle, 26, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property contains a password if authentication is to be used when connecting through the firewall.
  *
  * @access   public
  */
  public function getFirewallPassword() {
    return inship_fedexship_get($this->handle, 27 );
  }
 /**
  * This property contains a password if authentication is to be used when connecting through the firewall.
  *
  * @access   public
  * @param    string   value
  */
  public function setFirewallPassword($value) {
    $ret = inship_fedexship_set($this->handle, 27, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property contains the TCP port for the firewall Host .
  *
  * @access   public
  */
  public function getFirewallPort() {
    return inship_fedexship_get($this->handle, 28 );
  }
 /**
  * This property contains the TCP port for the firewall Host .
  *
  * @access   public
  * @param    int   value
  */
  public function setFirewallPort($value) {
    $ret = inship_fedexship_set($this->handle, 28, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property contains a user name if authentication is to be used connecting through a firewall.
  *
  * @access   public
  */
  public function getFirewallUser() {
    return inship_fedexship_get($this->handle, 29 );
  }
 /**
  * This property contains a user name if authentication is to be used connecting through a firewall.
  *
  * @access   public
  * @param    string   value
  */
  public function setFirewallUser($value) {
    $ret = inship_fedexship_set($this->handle, 29, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The date the freight shipment is guaranteed for.
  *
  * @access   public
  */
  public function getFreightGuaranteeDate() {
    return inship_fedexship_get($this->handle, 30 );
  }
 /**
  * The date the freight shipment is guaranteed for.
  *
  * @access   public
  * @param    string   value
  */
  public function setFreightGuaranteeDate($value) {
    $ret = inship_fedexship_set($this->handle, 30, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Specifies what type of freight guarantee is requested.
  *
  * @access   public
  */
  public function getFreightGuaranteeType() {
    return inship_fedexship_get($this->handle, 31 );
  }
 /**
  * Specifies what type of freight guarantee is requested.
  *
  * @access   public
  * @param    int   value
  */
  public function setFreightGuaranteeType($value) {
    $ret = inship_fedexship_set($this->handle, 31, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Image of a Hazardous Materials certification report.
  *
  * @access   public
  */
  public function getHazMatCertificate() {
    return inship_fedexship_get($this->handle, 32 );
  }


 /**
  * Street name.
  *
  * @access   public
  */
  public function getHoldAtLocationAddress1() {
    return inship_fedexship_get($this->handle, 33 );
  }
 /**
  * Street name.
  *
  * @access   public
  * @param    string   value
  */
  public function setHoldAtLocationAddress1($value) {
    $ret = inship_fedexship_set($this->handle, 33, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * A specific detail on the address (such as building, suite, apartment, floor number etc.
  *
  * @access   public
  */
  public function getHoldAtLocationAddress2() {
    return inship_fedexship_get($this->handle, 34 );
  }
 /**
  * A specific detail on the address (such as building, suite, apartment, floor number etc.
  *
  * @access   public
  * @param    string   value
  */
  public function setHoldAtLocationAddress2($value) {
    $ret = inship_fedexship_set($this->handle, 34, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Name of city, town, etc.
  *
  * @access   public
  */
  public function getHoldAtLocationCity() {
    return inship_fedexship_get($this->handle, 35 );
  }
 /**
  * Name of city, town, etc.
  *
  * @access   public
  * @param    string   value
  */
  public function setHoldAtLocationCity($value) {
    $ret = inship_fedexship_set($this->handle, 35, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Country code.
  *
  * @access   public
  */
  public function getHoldAtLocationCountryCode() {
    return inship_fedexship_get($this->handle, 36 );
  }
 /**
  * Country code.
  *
  * @access   public
  * @param    string   value
  */
  public function setHoldAtLocationCountryCode($value) {
    $ret = inship_fedexship_set($this->handle, 36, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * State or province code.
  *
  * @access   public
  */
  public function getHoldAtLocationState() {
    return inship_fedexship_get($this->handle, 37 );
  }
 /**
  * State or province code.
  *
  * @access   public
  * @param    string   value
  */
  public function setHoldAtLocationState($value) {
    $ret = inship_fedexship_set($this->handle, 37, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Postal code.
  *
  * @access   public
  */
  public function getHoldAtLocationZipCode() {
    return inship_fedexship_get($this->handle, 38 );
  }
 /**
  * Postal code.
  *
  * @access   public
  * @param    string   value
  */
  public function setHoldAtLocationZipCode($value) {
    $ret = inship_fedexship_set($this->handle, 38, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the contact person's company name.
  *
  * @access   public
  */
  public function getHoldAtLocationContactCompany() {
    return inship_fedexship_get($this->handle, 39 );
  }
 /**
  * Identifies the contact person's company name.
  *
  * @access   public
  * @param    string   value
  */
  public function setHoldAtLocationContactCompany($value) {
    $ret = inship_fedexship_set($this->handle, 39, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the contact person's email address.
  *
  * @access   public
  */
  public function getHoldAtLocationContactEmail() {
    return inship_fedexship_get($this->handle, 40 );
  }
 /**
  * Identifies the contact person's email address.
  *
  * @access   public
  * @param    string   value
  */
  public function setHoldAtLocationContactEmail($value) {
    $ret = inship_fedexship_set($this->handle, 40, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Recipient's fax number.
  *
  * @access   public
  */
  public function getHoldAtLocationContactFax() {
    return inship_fedexship_get($this->handle, 41 );
  }
 /**
  * Recipient's fax number.
  *
  * @access   public
  * @param    string   value
  */
  public function setHoldAtLocationContactFax($value) {
    $ret = inship_fedexship_set($this->handle, 41, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Sender's first name.
  *
  * @access   public
  */
  public function getHoldAtLocationContactFirstName() {
    return inship_fedexship_get($this->handle, 42 );
  }
 /**
  * Sender's first name.
  *
  * @access   public
  * @param    string   value
  */
  public function setHoldAtLocationContactFirstName($value) {
    $ret = inship_fedexship_set($this->handle, 42, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Person's last name.
  *
  * @access   public
  */
  public function getHoldAtLocationContactLastName() {
    return inship_fedexship_get($this->handle, 43 );
  }
 /**
  * Person's last name.
  *
  * @access   public
  * @param    string   value
  */
  public function setHoldAtLocationContactLastName($value) {
    $ret = inship_fedexship_set($this->handle, 43, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Middle initial.
  *
  * @access   public
  */
  public function getHoldAtLocationContactMiddleInitial() {
    return inship_fedexship_get($this->handle, 44 );
  }
 /**
  * Middle initial.
  *
  * @access   public
  * @param    string   value
  */
  public function setHoldAtLocationContactMiddleInitial($value) {
    $ret = inship_fedexship_set($this->handle, 44, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the contact person's phone number.
  *
  * @access   public
  */
  public function getHoldAtLocationContactPhone() {
    return inship_fedexship_get($this->handle, 45 );
  }
 /**
  * Identifies the contact person's phone number.
  *
  * @access   public
  * @param    string   value
  */
  public function setHoldAtLocationContactPhone($value) {
    $ret = inship_fedexship_set($this->handle, 45, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Phone number of the FedEx location where the shipment will be hold at.
  *
  * @access   public
  */
  public function getHoldAtLocationPhone() {
    return inship_fedexship_get($this->handle, 46 );
  }
 /**
  * Phone number of the FedEx location where the shipment will be hold at.
  *
  * @access   public
  * @param    string   value
  */
  public function setHoldAtLocationPhone($value) {
    $ret = inship_fedexship_set($this->handle, 46, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Date for Ground Home Delivery service.
  *
  * @access   public
  */
  public function getHomeDeliveryDate() {
    return inship_fedexship_get($this->handle, 47 );
  }
 /**
  * Date for Ground Home Delivery service.
  *
  * @access   public
  * @param    string   value
  */
  public function setHomeDeliveryDate($value) {
    $ret = inship_fedexship_set($this->handle, 47, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The phone number of the delivery location.
  *
  * @access   public
  */
  public function getHomeDeliveryPhone() {
    return inship_fedexship_get($this->handle, 48 );
  }
 /**
  * The phone number of the delivery location.
  *
  * @access   public
  * @param    string   value
  */
  public function setHomeDeliveryPhone($value) {
    $ret = inship_fedexship_set($this->handle, 48, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The type of Home Delivery Premium service being requested.
  *
  * @access   public
  */
  public function getHomeDeliveryType() {
    return inship_fedexship_get($this->handle, 49 );
  }
 /**
  * The type of Home Delivery Premium service being requested.
  *
  * @access   public
  * @param    int   value
  */
  public function setHomeDeliveryType($value) {
    $ret = inship_fedexship_set($this->handle, 49, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Total insured amount.
  *
  * @access   public
  */
  public function getInsuredValue() {
    return inship_fedexship_get($this->handle, 50 );
  }
 /**
  * Total insured amount.
  *
  * @access   public
  * @param    string   value
  */
  public function setInsuredValue($value) {
    $ret = inship_fedexship_set($this->handle, 50, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Type of image or printer commands the label is to be formatted in.
  *
  * @access   public
  */
  public function getLabelImageType() {
    return inship_fedexship_get($this->handle, 51 );
  }
 /**
  * Type of image or printer commands the label is to be formatted in.
  *
  * @access   public
  * @param    int   value
  */
  public function setLabelImageType($value) {
    $ret = inship_fedexship_set($this->handle, 51, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The FedEx location identifier that received the express dispatch request.
  *
  * @access   public
  */
  public function getLocation() {
    return inship_fedexship_get($this->handle, 52 );
  }
 /**
  * The FedEx location identifier that received the express dispatch request.
  *
  * @access   public
  * @param    string   value
  */
  public function setLocation($value) {
    $ret = inship_fedexship_set($this->handle, 52, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Image of the manifest for FedEx Ground shipment activity.
  *
  * @access   public
  */
  public function getManifest() {
    return inship_fedexship_get($this->handle, 53 );
  }


 /**
  * Tracking number assigned to the whole MPS shipment.
  *
  * @access   public
  */
  public function getMasterTrackingNumber() {
    return inship_fedexship_get($this->handle, 54 );
  }


 /**
  * Image of a multiweight report.
  *
  * @access   public
  */
  public function getMultiweightReport() {
    return inship_fedexship_get($this->handle, 55 );
  }


 /**
  * The number of records in the Notify arrays.
  *
  * @access   public
  */
  public function getNotifyCount() {
    return inship_fedexship_get($this->handle, 56 );
  }
 /**
  * The number of records in the Notify arrays.
  *
  * @access   public
  * @param    int   value
  */
  public function setNotifyCount($value) {
    $ret = inship_fedexship_set($this->handle, 56, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This can be used to set the entire aggregate xml for the recipient to be notified.
  *
  * @access   public
  */
  public function getNotifyAggregate($notifyidx) {
    return inship_fedexship_get($this->handle, 57 , $notifyidx);
  }
 /**
  * This can be used to set the entire aggregate xml for the recipient to be notified.
  *
  * @access   public
  * @param    string   value
  */
  public function setNotifyAggregate($notifyidx, $value) {
    $ret = inship_fedexship_set($this->handle, 57, $value , $notifyidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Email address of the recipient to be notified.
  *
  * @access   public
  */
  public function getNotifyEmail($notifyidx) {
    return inship_fedexship_get($this->handle, 58 , $notifyidx);
  }
 /**
  * Email address of the recipient to be notified.
  *
  * @access   public
  * @param    string   value
  */
  public function setNotifyEmail($notifyidx, $value) {
    $ret = inship_fedexship_set($this->handle, 58, $value , $notifyidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Fax number of the recipient that is going to receive the Signature Proof of Delivery via fax.
  *
  * @access   public
  */
  public function getNotifyFax($notifyidx) {
    return inship_fedexship_get($this->handle, 59 , $notifyidx);
  }
 /**
  * Fax number of the recipient that is going to receive the Signature Proof of Delivery via fax.
  *
  * @access   public
  * @param    string   value
  */
  public function setNotifyFax($notifyidx, $value) {
    $ret = inship_fedexship_set($this->handle, 59, $value , $notifyidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * User defined text that will be included in the email to be sent to Email .
  *
  * @access   public
  */
  public function getNotifyMessage($notifyidx) {
    return inship_fedexship_get($this->handle, 60 , $notifyidx);
  }
 /**
  * User defined text that will be included in the email to be sent to Email .
  *
  * @access   public
  * @param    string   value
  */
  public function setNotifyMessage($notifyidx, $value) {
    $ret = inship_fedexship_set($this->handle, 60, $value , $notifyidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The name associated with the notification.
  *
  * @access   public
  */
  public function getNotifyName($notifyidx) {
    return inship_fedexship_get($this->handle, 61 , $notifyidx);
  }
 /**
  * The name associated with the notification.
  *
  * @access   public
  * @param    string   value
  */
  public function setNotifyName($notifyidx, $value) {
    $ret = inship_fedexship_set($this->handle, 61, $value , $notifyidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the type of notification requested.
  *
  * @access   public
  */
  public function getNotifyFlags($notifyidx) {
    return inship_fedexship_get($this->handle, 62 , $notifyidx);
  }
 /**
  * Identifies the type of notification requested.
  *
  * @access   public
  * @param    int   value
  */
  public function setNotifyFlags($notifyidx, $value) {
    $ret = inship_fedexship_set($this->handle, 62, $value , $notifyidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the set of valid email notification recipient types.
  *
  * @access   public
  */
  public function getNotifyType($notifyidx) {
    return inship_fedexship_get($this->handle, 63 , $notifyidx);
  }
 /**
  * Identifies the set of valid email notification recipient types.
  *
  * @access   public
  * @param    int   value
  */
  public function setNotifyType($notifyidx, $value) {
    $ret = inship_fedexship_set($this->handle, 63, $value , $notifyidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Street name.
  *
  * @access   public
  */
  public function getOriginAddress1() {
    return inship_fedexship_get($this->handle, 64 );
  }
 /**
  * Street name.
  *
  * @access   public
  * @param    string   value
  */
  public function setOriginAddress1($value) {
    $ret = inship_fedexship_set($this->handle, 64, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * A specific detail on the address (such as building, suite, apartment, floor number etc.
  *
  * @access   public
  */
  public function getOriginAddress2() {
    return inship_fedexship_get($this->handle, 65 );
  }
 /**
  * A specific detail on the address (such as building, suite, apartment, floor number etc.
  *
  * @access   public
  * @param    string   value
  */
  public function setOriginAddress2($value) {
    $ret = inship_fedexship_set($this->handle, 65, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Various flags that denote information about the address.
  *
  * @access   public
  */
  public function getOriginAddressFlags() {
    return inship_fedexship_get($this->handle, 66 );
  }
 /**
  * Various flags that denote information about the address.
  *
  * @access   public
  * @param    int   value
  */
  public function setOriginAddressFlags($value) {
    $ret = inship_fedexship_set($this->handle, 66, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Name of city, town, etc.
  *
  * @access   public
  */
  public function getOriginCity() {
    return inship_fedexship_get($this->handle, 67 );
  }
 /**
  * Name of city, town, etc.
  *
  * @access   public
  * @param    string   value
  */
  public function setOriginCity($value) {
    $ret = inship_fedexship_set($this->handle, 67, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Country code.
  *
  * @access   public
  */
  public function getOriginCountryCode() {
    return inship_fedexship_get($this->handle, 68 );
  }
 /**
  * Country code.
  *
  * @access   public
  * @param    string   value
  */
  public function setOriginCountryCode($value) {
    $ret = inship_fedexship_set($this->handle, 68, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * State or province code.
  *
  * @access   public
  */
  public function getOriginState() {
    return inship_fedexship_get($this->handle, 69 );
  }
 /**
  * State or province code.
  *
  * @access   public
  * @param    string   value
  */
  public function setOriginState($value) {
    $ret = inship_fedexship_set($this->handle, 69, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Postal code.
  *
  * @access   public
  */
  public function getOriginZipCode() {
    return inship_fedexship_get($this->handle, 70 );
  }
 /**
  * Postal code.
  *
  * @access   public
  * @param    string   value
  */
  public function setOriginZipCode($value) {
    $ret = inship_fedexship_set($this->handle, 70, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the contact person's company name.
  *
  * @access   public
  */
  public function getOriginCompany() {
    return inship_fedexship_get($this->handle, 71 );
  }
 /**
  * Identifies the contact person's company name.
  *
  * @access   public
  * @param    string   value
  */
  public function setOriginCompany($value) {
    $ret = inship_fedexship_set($this->handle, 71, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the contact person's email address.
  *
  * @access   public
  */
  public function getOriginEmail() {
    return inship_fedexship_get($this->handle, 72 );
  }
 /**
  * Identifies the contact person's email address.
  *
  * @access   public
  * @param    string   value
  */
  public function setOriginEmail($value) {
    $ret = inship_fedexship_set($this->handle, 72, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Recipient's fax number.
  *
  * @access   public
  */
  public function getOriginFax() {
    return inship_fedexship_get($this->handle, 73 );
  }
 /**
  * Recipient's fax number.
  *
  * @access   public
  * @param    string   value
  */
  public function setOriginFax($value) {
    $ret = inship_fedexship_set($this->handle, 73, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Sender's first name.
  *
  * @access   public
  */
  public function getOriginFirstName() {
    return inship_fedexship_get($this->handle, 74 );
  }
 /**
  * Sender's first name.
  *
  * @access   public
  * @param    string   value
  */
  public function setOriginFirstName($value) {
    $ret = inship_fedexship_set($this->handle, 74, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Person's last name.
  *
  * @access   public
  */
  public function getOriginLastName() {
    return inship_fedexship_get($this->handle, 75 );
  }
 /**
  * Person's last name.
  *
  * @access   public
  * @param    string   value
  */
  public function setOriginLastName($value) {
    $ret = inship_fedexship_set($this->handle, 75, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Middle initial.
  *
  * @access   public
  */
  public function getOriginMiddleInitial() {
    return inship_fedexship_get($this->handle, 76 );
  }
 /**
  * Middle initial.
  *
  * @access   public
  * @param    string   value
  */
  public function setOriginMiddleInitial($value) {
    $ret = inship_fedexship_set($this->handle, 76, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the contact person's phone number.
  *
  * @access   public
  */
  public function getOriginPhone() {
    return inship_fedexship_get($this->handle, 77 );
  }
 /**
  * Identifies the contact person's phone number.
  *
  * @access   public
  * @param    string   value
  */
  public function setOriginPhone($value) {
    $ret = inship_fedexship_set($this->handle, 77, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The location of pickup.
  *
  * @access   public
  */
  public function getPackageLocation() {
    return inship_fedexship_get($this->handle, 78 );
  }
 /**
  * The location of pickup.
  *
  * @access   public
  * @param    int   value
  */
  public function setPackageLocation($value) {
    $ret = inship_fedexship_set($this->handle, 78, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The number of records in the Package arrays.
  *
  * @access   public
  */
  public function getPackageCount() {
    return inship_fedexship_get($this->handle, 79 );
  }
 /**
  * The number of records in the Package arrays.
  *
  * @access   public
  * @param    int   value
  */
  public function setPackageCount($value) {
    $ret = inship_fedexship_set($this->handle, 79, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Base charge applicable to this package.
  *
  * @access   public
  */
  public function getPackageBaseCharge($packageidx) {
    return inship_fedexship_get($this->handle, 80 , $packageidx);
  }


 /**
  * The COD monetary value for the package.
  *
  * @access   public
  */
  public function getPackageCODAmount($packageidx) {
    return inship_fedexship_get($this->handle, 81 , $packageidx);
  }
 /**
  * The COD monetary value for the package.
  *
  * @access   public
  * @param    string   value
  */
  public function setPackageCODAmount($packageidx, $value) {
    $ret = inship_fedexship_set($this->handle, 81, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Filename and location to save the CODLabel of this package to.
  *
  * @access   public
  */
  public function getPackageCODFile($packageidx) {
    return inship_fedexship_get($this->handle, 82 , $packageidx);
  }
 /**
  * Filename and location to save the CODLabel of this package to.
  *
  * @access   public
  * @param    string   value
  */
  public function setPackageCODFile($packageidx, $value) {
    $ret = inship_fedexship_set($this->handle, 82, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Image of the COD return label for this package retrieved by FedEx Server upon a successful COD ship request.
  *
  * @access   public
  */
  public function getPackageCODLabel($packageidx) {
    return inship_fedexship_get($this->handle, 83 , $packageidx);
  }


 /**
  * The code that indicates the type of funds that will be used for the COD payment for this package.
  *
  * @access   public
  */
  public function getPackageCODType($packageidx) {
    return inship_fedexship_get($this->handle, 84 , $packageidx);
  }
 /**
  * The code that indicates the type of funds that will be used for the COD payment for this package.
  *
  * @access   public
  * @param    int   value
  */
  public function setPackageCODType($packageidx, $value) {
    $ret = inship_fedexship_set($this->handle, 84, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies whether or not the dangerous goods being shipped are required to be accessible during delivery.
  *
  * @access   public
  */
  public function getPackageDangerousGoodsAccessible($packageidx) {
    return inship_fedexship_get($this->handle, 85 , $packageidx);
  }
 /**
  * Identifies whether or not the dangerous goods being shipped are required to be accessible during delivery.
  *
  * @access   public
  * @param    boolean   value
  */
  public function setPackageDangerousGoodsAccessible($packageidx, $value) {
    $ret = inship_fedexship_set($this->handle, 85, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * For FedEx, this is the description that appears in the email to identify this package.
  *
  * @access   public
  */
  public function getPackageDescription($packageidx) {
    return inship_fedexship_get($this->handle, 86 , $packageidx);
  }
 /**
  * For FedEx, this is the description that appears in the email to identify this package.
  *
  * @access   public
  * @param    string   value
  */
  public function setPackageDescription($packageidx, $value) {
    $ret = inship_fedexship_set($this->handle, 86, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The height of the package to be shipped.
  *
  * @access   public
  */
  public function getPackageHeight($packageidx) {
    return inship_fedexship_get($this->handle, 87 , $packageidx);
  }
 /**
  * The height of the package to be shipped.
  *
  * @access   public
  * @param    int   value
  */
  public function setPackageHeight($packageidx, $value) {
    $ret = inship_fedexship_set($this->handle, 87, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Amount of insurance requested for this package.
  *
  * @access   public
  */
  public function getPackageInsuredValue($packageidx) {
    return inship_fedexship_get($this->handle, 88 , $packageidx);
  }
 /**
  * Amount of insurance requested for this package.
  *
  * @access   public
  * @param    string   value
  */
  public function setPackageInsuredValue($packageidx, $value) {
    $ret = inship_fedexship_set($this->handle, 88, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The length of the package to be shipped.
  *
  * @access   public
  */
  public function getPackageLength($packageidx) {
    return inship_fedexship_get($this->handle, 89 , $packageidx);
  }
 /**
  * The length of the package to be shipped.
  *
  * @access   public
  * @param    int   value
  */
  public function setPackageLength($packageidx, $value) {
    $ret = inship_fedexship_set($this->handle, 89, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Net charge applicable to this package.
  *
  * @access   public
  */
  public function getPackageNetCharge($packageidx) {
    return inship_fedexship_get($this->handle, 90 , $packageidx);
  }
 /**
  * Net charge applicable to this package.
  *
  * @access   public
  * @param    string   value
  */
  public function setPackageNetCharge($packageidx, $value) {
    $ret = inship_fedexship_set($this->handle, 90, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The packaging type of the package being rated and/or shipped.
  *
  * @access   public
  */
  public function getPackageType($packageidx) {
    return inship_fedexship_get($this->handle, 91 , $packageidx);
  }
 /**
  * The packaging type of the package being rated and/or shipped.
  *
  * @access   public
  * @param    int   value
  */
  public function setPackageType($packageidx, $value) {
    $ret = inship_fedexship_set($this->handle, 91, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Indicates the package reference type and value, that associates this package (assigned by the customer).
  *
  * @access   public
  */
  public function getPackageReference($packageidx) {
    return inship_fedexship_get($this->handle, 92 , $packageidx);
  }
 /**
  * Indicates the package reference type and value, that associates this package (assigned by the customer).
  *
  * @access   public
  * @param    string   value
  */
  public function setPackageReference($packageidx, $value) {
    $ret = inship_fedexship_set($this->handle, 92, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Image of the shipping label for this package return by the Server upon a successful ship response.
  *
  * @access   public
  */
  public function getPackageShippingLabel($packageidx) {
    return inship_fedexship_get($this->handle, 93 , $packageidx);
  }


 /**
  * Filename and location to save the ShippingLabel of this package to.
  *
  * @access   public
  */
  public function getPackageShippingLabelFile($packageidx) {
    return inship_fedexship_get($this->handle, 94 , $packageidx);
  }
 /**
  * Filename and location to save the ShippingLabel of this package to.
  *
  * @access   public
  * @param    string   value
  */
  public function setPackageShippingLabelFile($packageidx, $value) {
    $ret = inship_fedexship_set($this->handle, 94, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Specifies one of the Delivery Signature Options requested for this package.
  *
  * @access   public
  */
  public function getPackageSignatureType($packageidx) {
    return inship_fedexship_get($this->handle, 95 , $packageidx);
  }
 /**
  * Specifies one of the Delivery Signature Options requested for this package.
  *
  * @access   public
  * @param    int   value
  */
  public function setPackageSignatureType($packageidx, $value) {
    $ret = inship_fedexship_set($this->handle, 95, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Contains the collection of special services offered on the package level.
  *
  * @access   public
  */
  public function getPackageSpecialServices($packageidx) {
    return inship_fedexship_get($this->handle, 96 , $packageidx);
  }
 /**
  * Contains the collection of special services offered on the package level.
  *
  * @access   public
  * @param    int64   value
  */
  public function setPackageSpecialServices($packageidx, $value) {
    $ret = inship_fedexship_set($this->handle, 96, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Total discount applicable to this package.
  *
  * @access   public
  */
  public function getPackageTotalDiscount($packageidx) {
    return inship_fedexship_get($this->handle, 97 , $packageidx);
  }


 /**
  * Total surcharges applicable to this package.
  *
  * @access   public
  */
  public function getPackageTotalSurcharges($packageidx) {
    return inship_fedexship_get($this->handle, 98 , $packageidx);
  }


 /**
  * Tracking number assigned to this package.
  *
  * @access   public
  */
  public function getPackageTrackingNumber($packageidx) {
    return inship_fedexship_get($this->handle, 99 , $packageidx);
  }


 /**
  * Weight of this package.
  *
  * @access   public
  */
  public function getPackageWeight($packageidx) {
    return inship_fedexship_get($this->handle, 100 , $packageidx);
  }
 /**
  * Weight of this package.
  *
  * @access   public
  * @param    string   value
  */
  public function setPackageWeight($packageidx, $value) {
    $ret = inship_fedexship_set($this->handle, 100, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The width of the package to be shipped.
  *
  * @access   public
  */
  public function getPackageWidth($packageidx) {
    return inship_fedexship_get($this->handle, 101 , $packageidx);
  }
 /**
  * The width of the package to be shipped.
  *
  * @access   public
  * @param    int   value
  */
  public function setPackageWidth($packageidx, $value) {
    $ret = inship_fedexship_set($this->handle, 101, $value , $packageidx);
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The account number of the party responsible for payment (shipping charges, or duties and taxes).
  *
  * @access   public
  */
  public function getPayorAccountNumber() {
    return inship_fedexship_get($this->handle, 102 );
  }
 /**
  * The account number of the party responsible for payment (shipping charges, or duties and taxes).
  *
  * @access   public
  * @param    string   value
  */
  public function setPayorAccountNumber($value) {
    $ret = inship_fedexship_set($this->handle, 102, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The country code for the payor of the shipment, or duties and taxes.
  *
  * @access   public
  */
  public function getPayorCountryCode() {
    return inship_fedexship_get($this->handle, 103 );
  }
 /**
  * The country code for the payor of the shipment, or duties and taxes.
  *
  * @access   public
  * @param    string   value
  */
  public function setPayorCountryCode($value) {
    $ret = inship_fedexship_set($this->handle, 103, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Method of payment for shipment, or duties and taxes.
  *
  * @access   public
  */
  public function getPayorType() {
    return inship_fedexship_get($this->handle, 104 );
  }
 /**
  * Method of payment for shipment, or duties and taxes.
  *
  * @access   public
  * @param    int   value
  */
  public function setPayorType($value) {
    $ret = inship_fedexship_set($this->handle, 104, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property is used to tell the component which  type of authorization to perform when connecting to the proxy.
  *
  * @access   public
  */
  public function getProxyAuthScheme() {
    return inship_fedexship_get($this->handle, 105 );
  }
 /**
  * This property is used to tell the component which  type of authorization to perform when connecting to the proxy.
  *
  * @access   public
  * @param    int   value
  */
  public function setProxyAuthScheme($value) {
    $ret = inship_fedexship_set($this->handle, 105, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property tells the component whether or not to automatically detect and use proxy system settings, if available.
  *
  * @access   public
  */
  public function getProxyAutoDetect() {
    return inship_fedexship_get($this->handle, 106 );
  }
 /**
  * This property tells the component whether or not to automatically detect and use proxy system settings, if available.
  *
  * @access   public
  * @param    boolean   value
  */
  public function setProxyAutoDetect($value) {
    $ret = inship_fedexship_set($this->handle, 106, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property contains a password if authentication is to be used for the proxy.
  *
  * @access   public
  */
  public function getProxyPassword() {
    return inship_fedexship_get($this->handle, 107 );
  }
 /**
  * This property contains a password if authentication is to be used for the proxy.
  *
  * @access   public
  * @param    string   value
  */
  public function setProxyPassword($value) {
    $ret = inship_fedexship_set($this->handle, 107, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property contains the TCP port for the proxy Server (default 80).
  *
  * @access   public
  */
  public function getProxyPort() {
    return inship_fedexship_get($this->handle, 108 );
  }
 /**
  * This property contains the TCP port for the proxy Server (default 80).
  *
  * @access   public
  * @param    int   value
  */
  public function setProxyPort($value) {
    $ret = inship_fedexship_set($this->handle, 108, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * If a proxy Server is given, then the HTTP request is sent to the proxy instead of the server otherwise specified.
  *
  * @access   public
  */
  public function getProxyServer() {
    return inship_fedexship_get($this->handle, 109 );
  }
 /**
  * If a proxy Server is given, then the HTTP request is sent to the proxy instead of the server otherwise specified.
  *
  * @access   public
  * @param    string   value
  */
  public function setProxyServer($value) {
    $ret = inship_fedexship_set($this->handle, 109, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property determines when to use SSL for the connection to the proxy.
  *
  * @access   public
  */
  public function getProxySSL() {
    return inship_fedexship_get($this->handle, 110 );
  }
 /**
  * This property determines when to use SSL for the connection to the proxy.
  *
  * @access   public
  * @param    int   value
  */
  public function setProxySSL($value) {
    $ret = inship_fedexship_set($this->handle, 110, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * This property contains a user name, if authentication is to be used for the proxy.
  *
  * @access   public
  */
  public function getProxyUser() {
    return inship_fedexship_get($this->handle, 111 );
  }
 /**
  * This property contains a user name, if authentication is to be used for the proxy.
  *
  * @access   public
  * @param    string   value
  */
  public function setProxyUser($value) {
    $ret = inship_fedexship_set($this->handle, 111, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Street name.
  *
  * @access   public
  */
  public function getRecipientAddress1() {
    return inship_fedexship_get($this->handle, 112 );
  }
 /**
  * Street name.
  *
  * @access   public
  * @param    string   value
  */
  public function setRecipientAddress1($value) {
    $ret = inship_fedexship_set($this->handle, 112, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * A specific detail on the address (such as building, suite, apartment, floor number etc.
  *
  * @access   public
  */
  public function getRecipientAddress2() {
    return inship_fedexship_get($this->handle, 113 );
  }
 /**
  * A specific detail on the address (such as building, suite, apartment, floor number etc.
  *
  * @access   public
  * @param    string   value
  */
  public function setRecipientAddress2($value) {
    $ret = inship_fedexship_set($this->handle, 113, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Various flags that denote information about the address.
  *
  * @access   public
  */
  public function getRecipientAddressFlags() {
    return inship_fedexship_get($this->handle, 114 );
  }
 /**
  * Various flags that denote information about the address.
  *
  * @access   public
  * @param    int   value
  */
  public function setRecipientAddressFlags($value) {
    $ret = inship_fedexship_set($this->handle, 114, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Name of city, town, etc.
  *
  * @access   public
  */
  public function getRecipientCity() {
    return inship_fedexship_get($this->handle, 115 );
  }
 /**
  * Name of city, town, etc.
  *
  * @access   public
  * @param    string   value
  */
  public function setRecipientCity($value) {
    $ret = inship_fedexship_set($this->handle, 115, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Country code.
  *
  * @access   public
  */
  public function getRecipientCountryCode() {
    return inship_fedexship_get($this->handle, 116 );
  }
 /**
  * Country code.
  *
  * @access   public
  * @param    string   value
  */
  public function setRecipientCountryCode($value) {
    $ret = inship_fedexship_set($this->handle, 116, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * State or province code.
  *
  * @access   public
  */
  public function getRecipientState() {
    return inship_fedexship_get($this->handle, 117 );
  }
 /**
  * State or province code.
  *
  * @access   public
  * @param    string   value
  */
  public function setRecipientState($value) {
    $ret = inship_fedexship_set($this->handle, 117, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Postal code.
  *
  * @access   public
  */
  public function getRecipientZipCode() {
    return inship_fedexship_get($this->handle, 118 );
  }
 /**
  * Postal code.
  *
  * @access   public
  * @param    string   value
  */
  public function setRecipientZipCode($value) {
    $ret = inship_fedexship_set($this->handle, 118, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the contact person's company name.
  *
  * @access   public
  */
  public function getRecipientCompany() {
    return inship_fedexship_get($this->handle, 119 );
  }
 /**
  * Identifies the contact person's company name.
  *
  * @access   public
  * @param    string   value
  */
  public function setRecipientCompany($value) {
    $ret = inship_fedexship_set($this->handle, 119, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the contact person's email address.
  *
  * @access   public
  */
  public function getRecipientEmail() {
    return inship_fedexship_get($this->handle, 120 );
  }
 /**
  * Identifies the contact person's email address.
  *
  * @access   public
  * @param    string   value
  */
  public function setRecipientEmail($value) {
    $ret = inship_fedexship_set($this->handle, 120, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Recipient's fax number.
  *
  * @access   public
  */
  public function getRecipientFax() {
    return inship_fedexship_get($this->handle, 121 );
  }
 /**
  * Recipient's fax number.
  *
  * @access   public
  * @param    string   value
  */
  public function setRecipientFax($value) {
    $ret = inship_fedexship_set($this->handle, 121, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Sender's first name.
  *
  * @access   public
  */
  public function getRecipientFirstName() {
    return inship_fedexship_get($this->handle, 122 );
  }
 /**
  * Sender's first name.
  *
  * @access   public
  * @param    string   value
  */
  public function setRecipientFirstName($value) {
    $ret = inship_fedexship_set($this->handle, 122, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Person's last name.
  *
  * @access   public
  */
  public function getRecipientLastName() {
    return inship_fedexship_get($this->handle, 123 );
  }
 /**
  * Person's last name.
  *
  * @access   public
  * @param    string   value
  */
  public function setRecipientLastName($value) {
    $ret = inship_fedexship_set($this->handle, 123, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Middle initial.
  *
  * @access   public
  */
  public function getRecipientMiddleInitial() {
    return inship_fedexship_get($this->handle, 124 );
  }
 /**
  * Middle initial.
  *
  * @access   public
  * @param    string   value
  */
  public function setRecipientMiddleInitial($value) {
    $ret = inship_fedexship_set($this->handle, 124, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the contact person's phone number.
  *
  * @access   public
  */
  public function getRecipientPhone() {
    return inship_fedexship_get($this->handle, 125 );
  }
 /**
  * Identifies the contact person's phone number.
  *
  * @access   public
  * @param    string   value
  */
  public function setRecipientPhone($value) {
    $ret = inship_fedexship_set($this->handle, 125, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Street name.
  *
  * @access   public
  */
  public function getReturnAddress1() {
    return inship_fedexship_get($this->handle, 126 );
  }
 /**
  * Street name.
  *
  * @access   public
  * @param    string   value
  */
  public function setReturnAddress1($value) {
    $ret = inship_fedexship_set($this->handle, 126, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * A specific detail on the address (such as building, suite, apartment, floor number etc.
  *
  * @access   public
  */
  public function getReturnAddress2() {
    return inship_fedexship_get($this->handle, 127 );
  }
 /**
  * A specific detail on the address (such as building, suite, apartment, floor number etc.
  *
  * @access   public
  * @param    string   value
  */
  public function setReturnAddress2($value) {
    $ret = inship_fedexship_set($this->handle, 127, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Various flags that denote information about the address.
  *
  * @access   public
  */
  public function getReturnAddressFlags() {
    return inship_fedexship_get($this->handle, 128 );
  }
 /**
  * Various flags that denote information about the address.
  *
  * @access   public
  * @param    int   value
  */
  public function setReturnAddressFlags($value) {
    $ret = inship_fedexship_set($this->handle, 128, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Name of city, town, etc.
  *
  * @access   public
  */
  public function getReturnCity() {
    return inship_fedexship_get($this->handle, 129 );
  }
 /**
  * Name of city, town, etc.
  *
  * @access   public
  * @param    string   value
  */
  public function setReturnCity($value) {
    $ret = inship_fedexship_set($this->handle, 129, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Country code.
  *
  * @access   public
  */
  public function getReturnCountryCode() {
    return inship_fedexship_get($this->handle, 130 );
  }
 /**
  * Country code.
  *
  * @access   public
  * @param    string   value
  */
  public function setReturnCountryCode($value) {
    $ret = inship_fedexship_set($this->handle, 130, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * State or province code.
  *
  * @access   public
  */
  public function getReturnState() {
    return inship_fedexship_get($this->handle, 131 );
  }
 /**
  * State or province code.
  *
  * @access   public
  * @param    string   value
  */
  public function setReturnState($value) {
    $ret = inship_fedexship_set($this->handle, 131, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Postal code.
  *
  * @access   public
  */
  public function getReturnZipCode() {
    return inship_fedexship_get($this->handle, 132 );
  }
 /**
  * Postal code.
  *
  * @access   public
  * @param    string   value
  */
  public function setReturnZipCode($value) {
    $ret = inship_fedexship_set($this->handle, 132, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the contact person's company name.
  *
  * @access   public
  */
  public function getReturnCompany() {
    return inship_fedexship_get($this->handle, 133 );
  }
 /**
  * Identifies the contact person's company name.
  *
  * @access   public
  * @param    string   value
  */
  public function setReturnCompany($value) {
    $ret = inship_fedexship_set($this->handle, 133, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the contact person's email address.
  *
  * @access   public
  */
  public function getReturnEmail() {
    return inship_fedexship_get($this->handle, 134 );
  }
 /**
  * Identifies the contact person's email address.
  *
  * @access   public
  * @param    string   value
  */
  public function setReturnEmail($value) {
    $ret = inship_fedexship_set($this->handle, 134, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Recipient's fax number.
  *
  * @access   public
  */
  public function getReturnFax() {
    return inship_fedexship_get($this->handle, 135 );
  }
 /**
  * Recipient's fax number.
  *
  * @access   public
  * @param    string   value
  */
  public function setReturnFax($value) {
    $ret = inship_fedexship_set($this->handle, 135, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Sender's first name.
  *
  * @access   public
  */
  public function getReturnFirstName() {
    return inship_fedexship_get($this->handle, 136 );
  }
 /**
  * Sender's first name.
  *
  * @access   public
  * @param    string   value
  */
  public function setReturnFirstName($value) {
    $ret = inship_fedexship_set($this->handle, 136, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Person's last name.
  *
  * @access   public
  */
  public function getReturnLastName() {
    return inship_fedexship_get($this->handle, 137 );
  }
 /**
  * Person's last name.
  *
  * @access   public
  * @param    string   value
  */
  public function setReturnLastName($value) {
    $ret = inship_fedexship_set($this->handle, 137, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Middle initial.
  *
  * @access   public
  */
  public function getReturnMiddleInitial() {
    return inship_fedexship_get($this->handle, 138 );
  }
 /**
  * Middle initial.
  *
  * @access   public
  * @param    string   value
  */
  public function setReturnMiddleInitial($value) {
    $ret = inship_fedexship_set($this->handle, 138, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the contact person's phone number.
  *
  * @access   public
  */
  public function getReturnPhone() {
    return inship_fedexship_get($this->handle, 139 );
  }
 /**
  * Identifies the contact person's phone number.
  *
  * @access   public
  * @param    string   value
  */
  public function setReturnPhone($value) {
    $ret = inship_fedexship_set($this->handle, 139, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Street name.
  *
  * @access   public
  */
  public function getSenderAddress1() {
    return inship_fedexship_get($this->handle, 140 );
  }
 /**
  * Street name.
  *
  * @access   public
  * @param    string   value
  */
  public function setSenderAddress1($value) {
    $ret = inship_fedexship_set($this->handle, 140, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * A specific detail on the address (such as building, suite, apartment, floor number etc.
  *
  * @access   public
  */
  public function getSenderAddress2() {
    return inship_fedexship_get($this->handle, 141 );
  }
 /**
  * A specific detail on the address (such as building, suite, apartment, floor number etc.
  *
  * @access   public
  * @param    string   value
  */
  public function setSenderAddress2($value) {
    $ret = inship_fedexship_set($this->handle, 141, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Various flags that denote information about the address.
  *
  * @access   public
  */
  public function getSenderAddressFlags() {
    return inship_fedexship_get($this->handle, 142 );
  }
 /**
  * Various flags that denote information about the address.
  *
  * @access   public
  * @param    int   value
  */
  public function setSenderAddressFlags($value) {
    $ret = inship_fedexship_set($this->handle, 142, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Name of city, town, etc.
  *
  * @access   public
  */
  public function getSenderCity() {
    return inship_fedexship_get($this->handle, 143 );
  }
 /**
  * Name of city, town, etc.
  *
  * @access   public
  * @param    string   value
  */
  public function setSenderCity($value) {
    $ret = inship_fedexship_set($this->handle, 143, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Country code.
  *
  * @access   public
  */
  public function getSenderCountryCode() {
    return inship_fedexship_get($this->handle, 144 );
  }
 /**
  * Country code.
  *
  * @access   public
  * @param    string   value
  */
  public function setSenderCountryCode($value) {
    $ret = inship_fedexship_set($this->handle, 144, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * State or province code.
  *
  * @access   public
  */
  public function getSenderState() {
    return inship_fedexship_get($this->handle, 145 );
  }
 /**
  * State or province code.
  *
  * @access   public
  * @param    string   value
  */
  public function setSenderState($value) {
    $ret = inship_fedexship_set($this->handle, 145, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Postal code.
  *
  * @access   public
  */
  public function getSenderZipCode() {
    return inship_fedexship_get($this->handle, 146 );
  }
 /**
  * Postal code.
  *
  * @access   public
  * @param    string   value
  */
  public function setSenderZipCode($value) {
    $ret = inship_fedexship_set($this->handle, 146, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the contact person's company name.
  *
  * @access   public
  */
  public function getSenderCompany() {
    return inship_fedexship_get($this->handle, 147 );
  }
 /**
  * Identifies the contact person's company name.
  *
  * @access   public
  * @param    string   value
  */
  public function setSenderCompany($value) {
    $ret = inship_fedexship_set($this->handle, 147, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the contact person's email address.
  *
  * @access   public
  */
  public function getSenderEmail() {
    return inship_fedexship_get($this->handle, 148 );
  }
 /**
  * Identifies the contact person's email address.
  *
  * @access   public
  * @param    string   value
  */
  public function setSenderEmail($value) {
    $ret = inship_fedexship_set($this->handle, 148, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Recipient's fax number.
  *
  * @access   public
  */
  public function getSenderFax() {
    return inship_fedexship_get($this->handle, 149 );
  }
 /**
  * Recipient's fax number.
  *
  * @access   public
  * @param    string   value
  */
  public function setSenderFax($value) {
    $ret = inship_fedexship_set($this->handle, 149, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Sender's first name.
  *
  * @access   public
  */
  public function getSenderFirstName() {
    return inship_fedexship_get($this->handle, 150 );
  }
 /**
  * Sender's first name.
  *
  * @access   public
  * @param    string   value
  */
  public function setSenderFirstName($value) {
    $ret = inship_fedexship_set($this->handle, 150, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Person's last name.
  *
  * @access   public
  */
  public function getSenderLastName() {
    return inship_fedexship_get($this->handle, 151 );
  }
 /**
  * Person's last name.
  *
  * @access   public
  * @param    string   value
  */
  public function setSenderLastName($value) {
    $ret = inship_fedexship_set($this->handle, 151, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Middle initial.
  *
  * @access   public
  */
  public function getSenderMiddleInitial() {
    return inship_fedexship_get($this->handle, 152 );
  }
 /**
  * Middle initial.
  *
  * @access   public
  * @param    string   value
  */
  public function setSenderMiddleInitial($value) {
    $ret = inship_fedexship_set($this->handle, 152, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the contact person's phone number.
  *
  * @access   public
  */
  public function getSenderPhone() {
    return inship_fedexship_get($this->handle, 153 );
  }
 /**
  * Identifies the contact person's phone number.
  *
  * @access   public
  * @param    string   value
  */
  public function setSenderPhone($value) {
    $ret = inship_fedexship_set($this->handle, 153, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Identifies the FedEx domestic service to use in a ship request.
  *
  * @access   public
  */
  public function getServiceType() {
    return inship_fedexship_get($this->handle, 154 );
  }
 /**
  * Identifies the FedEx domestic service to use in a ship request.
  *
  * @access   public
  * @param    int   value
  */
  public function setServiceType($value) {
    $ret = inship_fedexship_set($this->handle, 154, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The date on which the package will be tendered to FedEx.
  *
  * @access   public
  */
  public function getShipDate() {
    return inship_fedexship_get($this->handle, 155 );
  }
 /**
  * The date on which the package will be tendered to FedEx.
  *
  * @access   public
  * @param    string   value
  */
  public function setShipDate($value) {
    $ret = inship_fedexship_set($this->handle, 155, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Contains the collection of special services offered by FedEx.
  *
  * @access   public
  */
  public function getShipmentSpecialServices() {
    return inship_fedexship_get($this->handle, 156 );
  }
 /**
  * Contains the collection of special services offered by FedEx.
  *
  * @access   public
  * @param    int64   value
  */
  public function setShipmentSpecialServices($value) {
    $ret = inship_fedexship_set($this->handle, 156, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The certificate (PEM/base64 encoded).
  *
  * @access   public
  */
  public function getSSLAcceptServerCertEncoded() {
    return inship_fedexship_get($this->handle, 157 );
  }
 /**
  * The certificate (PEM/base64 encoded).
  *
  * @access   public
  * @param    string   value
  */
  public function setSSLAcceptServerCertEncoded($value) {
    $ret = inship_fedexship_set($this->handle, 157, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The certificate (PEM/base64 encoded).
  *
  * @access   public
  */
  public function getSSLCertEncoded() {
    return inship_fedexship_get($this->handle, 158 );
  }
 /**
  * The certificate (PEM/base64 encoded).
  *
  * @access   public
  * @param    string   value
  */
  public function setSSLCertEncoded($value) {
    $ret = inship_fedexship_set($this->handle, 158, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The name of the certificate store for the client certificate.
  *
  * @access   public
  */
  public function getSSLCertStore() {
    return inship_fedexship_get($this->handle, 159 );
  }
 /**
  * The name of the certificate store for the client certificate.
  *
  * @access   public
  * @param    string   value
  */
  public function setSSLCertStore($value) {
    $ret = inship_fedexship_set($this->handle, 159, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * If the certificate store is of a type that requires  a password, this property is used to specify that  password in order to open the certificate store.
  *
  * @access   public
  */
  public function getSSLCertStorePassword() {
    return inship_fedexship_get($this->handle, 160 );
  }
 /**
  * If the certificate store is of a type that requires  a password, this property is used to specify that  password in order to open the certificate store.
  *
  * @access   public
  * @param    string   value
  */
  public function setSSLCertStorePassword($value) {
    $ret = inship_fedexship_set($this->handle, 160, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The type of certificate store for this certificate.
  *
  * @access   public
  */
  public function getSSLCertStoreType() {
    return inship_fedexship_get($this->handle, 161 );
  }
 /**
  * The type of certificate store for this certificate.
  *
  * @access   public
  * @param    int   value
  */
  public function setSSLCertStoreType($value) {
    $ret = inship_fedexship_set($this->handle, 161, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The subject of the certificate used for client authentication.
  *
  * @access   public
  */
  public function getSSLCertSubject() {
    return inship_fedexship_get($this->handle, 162 );
  }
 /**
  * The subject of the certificate used for client authentication.
  *
  * @access   public
  * @param    string   value
  */
  public function setSSLCertSubject($value) {
    $ret = inship_fedexship_set($this->handle, 162, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The certificate (PEM/base64 encoded).
  *
  * @access   public
  */
  public function getSSLServerCertEncoded() {
    return inship_fedexship_get($this->handle, 163 );
  }


 /**
  * A timeout for the component.
  *
  * @access   public
  */
  public function getTimeout() {
    return inship_fedexship_get($this->handle, 164 );
  }
 /**
  * A timeout for the component.
  *
  * @access   public
  * @param    int   value
  */
  public function setTimeout($value) {
    $ret = inship_fedexship_set($this->handle, 164, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * The total net charge applied to the whole shipment (specific to the AccountNumber ).
  *
  * @access   public
  */
  public function getTotalNetCharge() {
    return inship_fedexship_get($this->handle, 165 );
  }


 /**
  * Total shipment weight.
  *
  * @access   public
  */
  public function getTotalWeight() {
    return inship_fedexship_get($this->handle, 166 );
  }
 /**
  * Total shipment weight.
  *
  * @access   public
  * @param    string   value
  */
  public function setTotalWeight($value) {
    $ret = inship_fedexship_set($this->handle, 166, $value );
    if ($ret != 0) {
      throw new Exception($ret . ": " . inship_fedexship_get_last_error($this->handle));
    }
    return $ret;
  }

 /**
  * Expected number of days in transit from pickup to delivery.
  *
  * @access   public
  */
  public function getTransitTime() {
    return inship_fedexship_get($this->handle, 167 );
  }




  public function getRuntimeLicense() {
    return inship_fedexship_get($this->handle, 2011 );
  }

  public function setRuntimeLicense($value) {
    $ret = inship_fedexship_set($this->handle, 2011, $value );
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

?>
