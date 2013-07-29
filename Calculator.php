<?php

class Calculator {

	protected $result = 0;

	public function getResult()
	{
		return $this->result;
	}

	public function add()
	{
		$this->calculateAll(func_get_args(), '+');
	}

	public function subtract()
	{
		$this->calculateAll(func_get_args(), '-');
	}

	public function calculateAll($nums, $symbol)
	{
		foreach ($nums as $num)
		{
			$this->calculate($num, $symbol);
		}
	}

	protected function calculate($num, $symbol)
	{
		if ( ! is_numeric($num))
			throw new InvalidArgumentException;

		switch ($symbol)
		{
			case '+':
				$this->result += $num;
				break;
			case '-':
				$this->result -= $num;
				break;
		}
	}

}