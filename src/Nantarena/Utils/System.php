<?php

namespace Nantarena\Utils;

/**
 * Ensemble de fonctions utilitaires pour controler les iptables du Firewall
 * 
 * @author Drake <drake@nantarena.net>
 *
 */
class System {
    /**
     * Ajout d'une IP au iptables
     * 
     * @param string $ip
     * @return string
     */
    static function addPlayer($ip) {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            // execution shell
            $cmd = exec('sudo /root/scripts/na_iptables add portal ' . $ip, $output, $return_var);
            
            return $return_var;
        }
    }
    
    /**
     * Retrait d'une IP au iptables
     *
     * @param string $ip
     * @return string
     */
    static function delPlayer($ip) {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            // execution shell
            $cmd = exec('sudo /root/scripts/na_iptables del portal ' . $ip, $output, $return_var);
    
            return $return_var;
        }
    }
    
    /**
     * Ajout d'une IP au iptables full access
     *
     * @param string $ip
     * @return string
     */
    static function addFullPlayer($ip) {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            // execution shell
            $cmd = exec('sudo /root/scripts/na_iptables add fullWeb ' . $ip, $output, $return_var);
    
            return $return_var;
        }
    }
    
    /**
     * Retrait d'une IP au iptables full access
     *
     * @param string $ip
     * @return string
     */
    static function delFullPlayer($ip) {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            // execution shell
            $cmd = exec('sudo /root/scripts/na_iptables del fullWeb ' . $ip, $output, $return_var);

            return $return_var;
        }
    }
    
    /**
     * Retrait d'une IP au iptables de ban
     *
     * @param string $ip
     * @return string
     */
    static function banPlayer($ip) {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            // execution shell
            $cmd = exec('sudo /root/scripts/na_iptables add ban ' . $ip, $output, $return_var);
    
            return $return_var;
        }
    }
    
    /**
     * Retrait d'une IP au iptables de ban
     *
     * @param string $ip
     * @return string
     */
    static function unbanPlayer($ip) {
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            // execution shell
            $cmd = exec('sudo /root/scripts/na_iptables del ban ' . $ip, $output, $return_var);
    
            return $return_var;
        }
    }
}