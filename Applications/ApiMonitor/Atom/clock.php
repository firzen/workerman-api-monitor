<?php 
class Clock implements AtomInterface{
	public function execute()
	{
		$str=file_get_contents('http://worldclockapi.com/api/json/est/now');
		if(json_decode($str)){
			return true;
		}else{
			return false;
		}
	}
	public function getName()
	{
		return 'World Clock API';
	}

	public function getNameSpace()
	{
		return 'Sameple';
	}

	public function getLoopTime()
	{
		return 5;
	}
}

return 'Clock';