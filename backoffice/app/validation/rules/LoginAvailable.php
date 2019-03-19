<?php
namespace Backoffice\Validation\rules;
use Respect\Validation\Rules\AbstractRule;

class LoginAvailable extends AbstractRule{
	public function validate($input){
		$curl = new \Curl\Curl();
		$curlResponse = $curl->get('backend-lmaillard.pagekite.me/checkLogin/'.$input);
		return json_decode($curlResponse->response)->count === 0;
	}
}