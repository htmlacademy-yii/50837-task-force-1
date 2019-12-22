<?php

use PHPUnit\Framework\TestCase;
use TaskForce\Actions\DoneAction;

class DoneActionTest extends TestCase {
	
	/** @var DoneAction */
	public $doneAction;
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 */
	protected function setUp(): void {
		parent::setUp();
		
		$this->doneAction = new DoneAction();
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 */
	public function testActionReturnsCorrectName() {
		$this->assertEquals('Выполнено', $this->doneAction->getName());
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 */
	public function testActionReturnsCorrectCode() {
		$this->assertEquals(3, $this->doneAction->getCode());
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 */
	public function testActionReturnsCorrectAccess() {
		$this->assertTrue($this->doneAction->isAllowed(1, 2, 2));
		$this->assertFalse($this->doneAction->isAllowed(2, 1, 2));
		$this->assertFalse($this->doneAction->isAllowed(1, 2, 3));
	}
}
