<?php

namespace Omnipay\Humm\Helper;

/**
 * NOTE: Adapted from https://github.com/shophumm/humm-au-magento2.x
 * 
 * Class Crypto
 * @package Humm\HummPaymentGateway\Helper
 */
class Crypto {

    /**
     * generates a hmac based on an associative array and an api key
     *
     * @param $query array
     * @param $api_key string
     *
     * @return string
     */
    public static function generateSignature( $query, $api_key ) {
        $clear_text = '';
        ksort( $query );
        foreach ( $query as $key => $value ) {
            if ( substr( $key, 0, 2 ) === "x_" && $key !== "x_signature" ) {
                $clear_text .= $key . $value;
            }
        }
        $hash = hash_hmac( "sha256", $clear_text, $api_key );
        $hash = str_replace( '-', '', $hash );

        return $hash;
    }

    /**
     * validates and associative array that contains a hmac signature against an api key
     *
     * @param $query array
     * @param $api_key string
     *
     * @return bool
     */
    public static function isValidSignature( $query, $api_key ) {
        $actualSignature = $query['x_signature'] ?? null;
        if (isset($query['x_signature'])) {
            unset( $query['x_signature'] );
        }

        $expectedSignature = self::generateSignature( $query, $api_key );

        return ($actualSignature && ($actualSignature == $expectedSignature));
    }
}
