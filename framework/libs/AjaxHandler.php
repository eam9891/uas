<?php
/**
 * Created by PhpStorm.
 * User: Ethan
 * Date: 3/7/2017
 * Time: 2:14 AM
 */

namespace framework\libs;


class AjaxHandler {
    private $url, $divID, $requestType;
    private $dataString = [];


    // $dataString is a two dimensional array that must have the following format:
    //      $dataString = array(
    //           "request" => xxx,
    //           "method"  => xxx,
    //           "params"  => array(
    //               xxx => xxx,
    //               xxx => xxx
    //           )
    //       );


    /** Generates an Ajax Request Button
     *
     * @param string $url
     * @param string $divID
     * @param array  $dataString
     * @param string $requestType
     *
     * @return string
     */
    public function ajaxButton(string $url, string $divID, array $dataString = NULL, string $requestType) : string {

        $this->url = $url;
        $this->divID = $divID;
        $this->dataString = json_encode($dataString);
        $this->requestType = $requestType;

        $ajaxRequest = <<<ajax
            
            $('$this->divID').on('click' , function(){
                loader();
                var data;
                $.ajax({
                    type: "$this->requestType",
                    url: "$this->url",
                    data: $this->dataString,
                    success : function(data) {
                        $("#display").hide().html(data).fadeIn();
                    }
                });
                return false;
            });
        
ajax;

        return (string) $ajaxRequest;
    }



    /** Generates an Ajax Request
     * @param string $url
     * @param array  $dataString
     *
     * @return string
     */
    public function ajaxRequest(string $url, array $dataString = NULL) : string {

        $this->url = $url;
        $this->dataString = json_encode($dataString);

        $ajaxRequest = <<<ajax
            
            
            var data;
            $.ajax({
                type: "POST",
                url: "$this->url",
                data: $this->dataString,
                success : function(data) {
                    $("#display").hide().html(data).fadeIn();
                }
            });
            
       
ajax;
        return (string) $ajaxRequest;
    }
}