<?php
namespace Backoffice\validation\rules;
use Respect\Validation\Exceptions\ValidationException;

class LoginAvailableException extends ValidationException{
	public static $defaultTemplates = [
		self::MODE_DEFAULT => [
			self::STANDARD => "Login is already taken"
		]
	];
}