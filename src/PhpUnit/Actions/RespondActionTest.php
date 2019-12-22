<?php

use PHPUnit\Framework\TestCase;
use TaskForce\Actions\RespondAction;

class RespondActionTest extends TestCase {
	
	/** @var RespondAction */
	public $respondAction;
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 */
	protected function setUp(): void {
		parent::setUp();
		
		$this->respondAction = new RespondAction();
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 */
	public function testActionReturnsCorrectName() {
		$this->assertEquals('Откликнуться', $this->respondAction->getName());
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 */
	public function testActionReturnsCorrectCode() {
		$this->assertEquals(2, $this->respondAction->getCode());
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 */
	public function testActionReturnsCorrectAccess() {
		$this->assertTrue($this->respondAction->isAllowed(2, 1, 2));
		$this->assertFalse($this->respondAction->isAllowed(1, 2, 2));
		$this->assertFalse($this->respondAction->isAllowed(1, 2, 3));
	}
}
