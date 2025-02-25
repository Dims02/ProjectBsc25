<?php

class Validator {
	public function validate($data) {
		if (empty($data['name'])) {
			return 'Name is required';
		}

		if (empty($data['email'])) {
			return 'Email is required';
		}

		if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
			return 'Invalid email format';
		}

		if (empty($data['password'])) {
			return 'Password is required';
		}

		if (strlen($data['password']) < 6) {
			return 'Password must be at least 6 characters';
		}

		return '';
	}
}