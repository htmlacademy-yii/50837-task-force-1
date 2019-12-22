<?php

namespace PhpUnit\Tasks\GetAvailableActionsForStatusTest;

use PHPUnit\Framework\TestCase;
use TaskForce\Actions\CancelAction;
use TaskForce\Actions\DoneAction;
use TaskForce\Actions\RefuseAction;
use TaskForce\Actions\RespondAction;
use TaskForce\Tasks\Status;
use \LogicException;

class GetAvailableActionsForStatusTest extends TestCase {
	
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
	public function testGetCorrectActions() {
		$this->assertEquals([], $this->status->getAvailableActionsForStatus(1));
		$this->assertEquals([new DoneAction(), new RefuseAction()], $this->status->getAvailableActionsForStatus(2));
		$this->assertEquals([], $this->status->getAvailableActionsForStatus(3));
		$this->assertEquals([], $this->status->getAvailableActionsForStatus(4));
		$this->assertEquals([new CancelAction(), new RespondAction()], $this->status->getAvailableActionsForStatus(5));
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 * @throws LogicException
	 */
	public function testNotHandledStatus() {
		$this->expectException(LogicException::class);
		
		$this->status->getStatusByAction(6);
	}
}
