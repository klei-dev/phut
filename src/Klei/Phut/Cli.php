<?php
namespace Klei\Phut;

class Cli {
	protected $doColorize = true;

	protected static $foreground = array(
		'black' => '0;30',
		'dark-gray' => '1;30',
		'red' => '0;31',
		'light-red' => '1;31',
		'green' => '0;32',
		'light-green' => '1;32',
		'brown' => '0;33',
		'yellow' => '1;33',
		'blue' => '0;34',
		'light-blue' => '1;34',
		'purple' => '0;35',
		'light-purple' => '1;35',
		'cyan' => '0;36',
		'light-cyan' => '1;36',
		'light-gray' => '0;37',
		'white' => '1;37'
	);

	protected static $background = array(
		'black' => '40',
		'red' => '41',
		'green' => '42',
		'yellow' => '43',
		'blue' => '44',
		'magenta' => '45',
		'cyan' => '46',
		'light-gray' => '47'
	);

	protected $reset = '0';

	public function disableColoring() {
		$this->doColorize = false;
	}

	public function enableColoring() {
		$this->doColorize = true;
	}

	public function isEnabled() {
		return $this->doColorize;
	}

	public function string($message, $foregroundColor = null, $backgroundColor = null) {
		$this->colorize($message, $foregroundColor, $backgroundColor);

		return $message;
	}

	public function colorize(&$message, $foregroundColor = null, $backgroundColor = null)
	{
		if (!$this->doColorize)
			return;

		$this->applyBackgroundColor($message, $backgroundColor);

		$this->applyForegroundColor($message, $foregroundColor);

		$this->applyColorReset($message, $foregroundColor, $backgroundColor);
	}

	public function applyForegroundColor(&$message, $foregroundColor = null)
	{
		if ($foregroundColor === null)
			return;
		$message = $this->color($this->getForegroundColor($foregroundColor)) . $message;
	}

	public function applyBackgroundColor(&$message, $backgroundColor = null)
	{
		if ($backgroundColor === null)
			return;
		$message = $this->color($this->getBackgroundColor($backgroundColor)) . $message;
	}

	public function applyColorReset(&$message, $foregroundColor = null, $backgroundColor = null)
	{
		if ($foregroundColor === null && $backgroundColor === null)
			return;
		$message .= $this->color($this->reset);
	}

	public function color($color) {
		return "\033[" . $color . "m";
	}

	protected function getForegroundColor($foregroundColor) {
		if (!isset(self::$foreground[$foregroundColor])) {
			throw new \InvalidArgumentException(sprintf('The specified foreground color \'%s\' does not exist', $foregroundColor));
		}
		return self::$foreground[$foregroundColor];
	}

	protected function getBackgroundColor($backgroundColor) {
		if (!isset(self::$background[$backgroundColor])) {
			throw new \InvalidArgumentException(sprintf('The specified background color \'%s\' does not exist', $backgroundColor));
		}
		return self::$background[$backgroundColor];
	}
}
?>