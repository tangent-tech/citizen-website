<?php

class BdrCondition {
	public $quantity;
	public $productIdArray = array();
	public $type;
	
	public function BdrCondition($_quantity, $_productIdArray, $_type) {
		$this->quantity = $_quantity;
		$this->productIdArray = $_productIdArray;
		$this->type = $_type;
	}
}

class BdrSolutionProduct {
	public $productID;
	public $quantity;
	public $type;
	
	public function BdrSolutionProduct($_productID, $_quantity, $_type) {
		$this->productID = $_productID;
		$this->quantity = $_quantity;
		$this->type = $_type;
	}
}

class bdrConditionDiscountCalculator {
	
	public function bdrConditionDiscountCalculator($_ProductQuantityArray, $_ConditionArray, $_MaxNoOfTimeThisRuleApplied) {
		$this->ProductQuantityArray = $_ProductQuantityArray;
		$this->ConditionArray = $_ConditionArray;
		$this->MaxNoOfTimeThisRuleApplied = $_MaxNoOfTimeThisRuleApplied;
	}
	
	private function loopCurrentCondition($currentConditionIndex, $currentProductIndex, $targetQuantity) {
		if ($currentConditionIndex == count($this->ConditionArray))
			return true;
		
		/* @var $CurrentCondition BdrCondition */
		$CurrentCondition = $this->ConditionArray[$currentConditionIndex];
		
		if ($currentProductIndex == count($CurrentCondition->productIdArray))
			return false;
			
		$ProductID = strval($CurrentCondition->productIdArray[$currentProductIndex]);
		$ProductQuantity = $this->ProductQuantityArray[$ProductID];
		
		if ($targetQuantity == 0) {
			$targetQuantity = $CurrentCondition->quantity;
		}
		
		for ($i = min($targetQuantity, $ProductQuantity); $i > 0; $i--) {			
			$BdrSolution = new BdrSolutionProduct($ProductID, $i, $CurrentCondition->type);
			array_push($this->Solution, $BdrSolution);
			$this->ProductQuantityArray[$ProductID] -= $i;
			$newTargetQuantity = $targetQuantity - $i;
						
			if ($newTargetQuantity == 0) {
				if ($this->loopCurrentCondition($currentConditionIndex+1, 0, 0))
					return true;
				else {
					array_pop($this->Solution);
					$this->ProductQuantityArray[$ProductID] += $i;
				}
			}
			else {
				if ($this->loopCurrentCondition($currentConditionIndex, $currentProductIndex+1, $newTargetQuantity))
					return true;
				else {
					array_pop($this->Solution);
					$this->ProductQuantityArray[$ProductID] += $i;
				}
			}
		}
		
		return $this->loopCurrentCondition($currentConditionIndex, $currentProductIndex+1, $targetQuantity);
	}
	
	private function mergeSolutionToSummary() {
		foreach ($this->Solution as $S) {
			/* @var $S BdrSolutionProduct */
			if ($S->type == 'cost') {
				if (!isset($this->CostAwareSolutionSummary[$S->productID]))
					$this->CostAwareSolutionSummary[$S->productID] = $S->quantity;
				else
					$this->CostAwareSolutionSummary[$S->productID] += $S->quantity;
			}
			elseif ($S->type == 'free') {
				if (!isset($this->FreeSolutionSummary[$S->productID]))
					$this->FreeSolutionSummary[$S->productID] = $S->quantity;
				else
					$this->FreeSolutionSummary[$S->productID] += $S->quantity;
			}
		}
	}
	
	public function getSolution(&$FreeSolution, &$CostSolution, &$QuantityLeftArray, &$RuleHitNoOfTimes) {
		
		$RetVal = false;
		$RuleHitNoOfTimes = 0;
		
		if ($this->MaxNoOfTimeThisRuleApplied == 0) {
			$FreeSolution = array();
			$CostSolution = array();
			$QuantityLeftArray = array();
			return false;
		}
		
		while ($RuleHitNoOfTimes < $this->MaxNoOfTimeThisRuleApplied && $this->loopCurrentCondition(0, 0, 0)) {
			$RuleHitNoOfTimes++;
			$this->mergeSolutionToSummary();
			$this->Solution = array();
			$RetVal = true;
		}
		
		$FreeSolution = $this->FreeSolutionSummary;
		$CostSolution = $this->CostAwareSolutionSummary;
		$QuantityLeftArray = $this->ProductQuantityArray;
		
		return $RetVal;
	}
	
	private $Solution = array();
	
	private $CostAwareSolutionSummary = array();
	private $FreeSolutionSummary = array();
	
	private $ProductQuantityArray;
	private $ConditionArray;
	private $MaxNoOfTimeThisRuleApplied = 0;
}