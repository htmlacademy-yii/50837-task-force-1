<?php

use PHPUnit\Framework\TestCase;
use TaskForce\Actions\RefuseAction;

class RefuseActionTest extends TestCase {
	
	/** @var RefuseAction */
	public $refuseAction;
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 */
	protected function setUp(): void {
		parent::setUp();
		
		$this->refuseAction = new RefuseAction();
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 */
	public function testActionReturnsCorrectName() {
		$this->assertEquals('Отказаться', $this->refuseAction->getName());
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 */
	public function testActionReturnsCorrectCode() {
		$this->assertEquals(4, $this->refuseAction->getCode());
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 */
	public function testActionReturnsCorrectAccess() {
		$this->assertTrue($this->refuseAction->isAllowed(2, 1, 2));
		$this->assertFalse($this->refuseAction->isAllowed(1, 2, 2));
		$this->assertFalse($this->refuseAction->isAllowed(1, 2, 3));
	}
}
