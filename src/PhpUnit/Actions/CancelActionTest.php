<?php

use PHPUnit\Framework\TestCase;
use TaskForce\Actions\CancelAction;

class CancelActionTest extends TestCase {
	
	/** @var CancelAction */
	public $cancelAction;
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 */
	protected function setUp(): void {
		parent::setUp();
		
		$this->cancelAction = new CancelAction();
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 */
	public function testActionReturnsCorrectName() {
		$this->assertEquals('Отменить', $this->cancelAction->getName());
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 */
	public function testActionReturnsCorrectCode() {
		$this->assertEquals(1, $this->cancelAction->getCode());
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 */
	public function testActionReturnsCorrectAccess() {
		$this->assertTrue($this->cancelAction->isAllowed(1, 2, 2));
		$this->assertFalse($this->cancelAction->isAllowed(2, 1, 2));
		$this->assertFalse($this->cancelAction->isAllowed(1, 2, 3));
	}
}
