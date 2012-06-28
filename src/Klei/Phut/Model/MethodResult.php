<?php
namespace Klei\Phut\Model;

use Klei\Phut\Timer;
use Klei\Phut\AssertionException;

class MethodResult {
	protected $timer;
	protected $exception;

	public function __construct(Timer $timer, \Exception $exception = null) {
		$this->setTimer($timer);
		$this->setException($exception);
	}

	public function setTimer(Timer $timer) {
		if (!$timer->hasBeenRun()) {
			throw new \InvalidArgumentException('A timer that has been run was expected. Could not set timer.');
		}
		$this->timer = $timer;
	}

	public function setException(\Exception $exception = null) {
		$this->exception = $exception;
	}

	public function getExecutionTime() {
		return $this->timer->getElapsedTime();
	}

	public function isSuccessful() {
		return (bool)($this->exception === null);
	}

	public function isUnexpectedException() {
		if ($this->exception instanceof AssertionException) {
			return false;
		} else {
			return true;
		}
	}
}