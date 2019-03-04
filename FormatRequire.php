<?php 

class FormatRequire{
	
	static function positiveInteger($val)
	{
		if (!is_numeric($val) || !is_int($val))
			throw new FormatException("Format pas respecté");
		if($val < 0)
			throw new NegativeNumberException("Nombre négatif");
	}
}