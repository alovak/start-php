<?php

class Start_Customer {

    /**
     * Create a new customer for given $data
     *
     * @param array $data the data for the new customer
     * @return array the result of the customer
     * @throws Start_Error_Card if the card could not be accepted
     * @throws Start_Error_Parameters if any of the parameters is invalid
     * @throws Start_Error_Authentication if the API Key is invalid
     * @throws Start_Error if there is a general error in the API endpoint
     * @throws Exception for any other errors
     */
    public static function create(array $data) {
        $return_data = Start_Request::make_request("/customers", $data);
        return $return_data;
    }

    /**
     * List all created customers
     *
     * @return array list of customers
     * @throws Start_Error_Parameters if any of the parameters is invalid
     * @throws Start_Error_Authentication if the API Key is invalid
     * @throws Start_Error if there is a general error in the API endpoint
     * @throws Exception for any other errors
     */
    public static function all() {
        $return_data = Start_Request::make_request("/customers");
        return $return_data;
    }

    /* Retrieve an existing Customer */
    public static function get($customer_id) {
        $return_data = Start_Request::make_request("/customers/" . $customer_id);
        return $return_data;
    }
}
