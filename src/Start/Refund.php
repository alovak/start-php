<?php

class Start_Refund {

    public static function create(array $data) {
        $return_data = Start_Request::make_request("/charges/" . $data["charge_id"] . "/refunds", $data);
        return $return_data;
    }
}
