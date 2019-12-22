<?php

namespace PhpUnit\Tasks;

use PHPUnit\Framework\TestCase;
use TaskForce\Tasks\Status;
use \LogicException;

class StatusTest extends TestCase {
	
	/** @var Status */
	protected $status;
	
	protected function setUp(): void {
		parent::setUp();
		
		$this->status = new Status(1, 2, 3);
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 *
	 * @throws LogicException
	 */
	public function testGetCorrectStatus() {
		$this->assertEquals(1, $this->status->getStatusByAction(1));
		$this->assertEquals(2, $this->status->getStatusByAction(2));
		$this->assertEquals(3, $this->status->getStatusByAction(3));
		$this->assertEquals(4, $this->status->getStatusByAction(4));
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 * @throws LogicException
	 */
	public function testNotHandledActionType() {
		$this->expectException(LogicException::class);
		
		$this->status->getStatusByAction(5);
	}
}
