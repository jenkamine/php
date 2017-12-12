<?php

use Phalcon\Mvc\Model;

class xempmst extends Model
{

	public $emp_no;
	public $emp_nm;
	public $fac_code;
	public $web_pass;

	public function getEmpNo()
	{
		return $this->$emp_no;
	}
	public function setEmpNo()
	{
		return $this->$emp_no;
	}
	public function getEmpNm()
	{
		return $this->$emp_nm;
	}
	public function setEmpNm()
	{
		return $this->$emp_nm;
	}
	public function getFacCode()
	{
		if(empty($this->$fac_code))
		{
			return '001';
		}
		return $this->$fac_code;
	}
	public function setFacCode()
	{
		return $this->$fac_code;
	}
	public function getWebPass()
	{
		return $this->$web_pass;
	}
	public function setWebPass()
	{
		return $this->$web_pass;
	}
}
