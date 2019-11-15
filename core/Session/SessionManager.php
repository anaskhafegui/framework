<?php

namespace Core\Session;

class SessionManager{
	
	public $i = 0;

	public function get()
	{
		return $this->i;
	}
}