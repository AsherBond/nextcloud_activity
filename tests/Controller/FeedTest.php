<?php
/**
 * @copyright Copyright (c) 2016, ownCloud, Inc.
 *
 * @author Joas Schilling <coding@schilljs.com>
 *
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */

namespace OCA\Activity\Tests\Controller;

use OCA\Activity\Controller\Feed;
use OCA\Activity\Tests\TestCase;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\Util;
use OCP\IURLGenerator;
use OCP\Activity\IManager;
use OCP\IUserSession;
use OCP\IRequest;
use OCP\IConfig;
use OCA\Activity\UserSettings;
use OCA\Activity\GroupHelper;
use OCA\Activity\Data;
use OCP\IUser;

class FeedTest extends TestCase {
	/** @var IConfig|\PHPUnit_Framework_MockObject_MockObject */
	protected $config;

	/** @var IRequest|\PHPUnit_Framework_MockObject_MockObject */
	protected $request;

	/** @var Data|\PHPUnit_Framework_MockObject_MockObject */
	protected $data;

	/** @var GroupHelper|\PHPUnit_Framework_MockObject_MockObject */
	protected $helper;

	/** @var UserSettings|\PHPUnit_Framework_MockObject_MockObject */
	protected $userSettings;

	/** @var IManager|\PHPUnit_Framework_MockObject_MockObject */
	protected $manager;

	/** @var IUserSession|\PHPUnit_Framework_MockObject_MockObject */
	protected $session;

	/** @var \OCP\IL10N */
	protected $l10n;

	/** @var Feed */
	protected $controller;

	protected function setUp(): void {
		parent::setUp();

		$this->data = $this->createMock(Data::class);
		$this->helper = $this->createMock(GroupHelper::class);
		$this->userSettings = $this->createMock(UserSettings::class);

		$this->config = $this->createMock(IConfig::class);
		$this->request = $this->createMock(IRequest::class);
		$this->session = $this->createMock(IUserSession::class);
		$this->manager = $this->createMock(IManager::class);

		/** @var $urlGenerator IURLGenerator|\PHPUnit_Framework_MockObject_MockObject */
		$urlGenerator = $this->createMock(IURLGenerator::class);

		$this->controller = new Feed(
			'activity',
			$this->request,
			$this->data,
			$this->helper,
			$this->userSettings,
			$urlGenerator,
			$this->manager,
			\OC::$server->getL10NFactory(),
			$this->config
		);
	}


	public function showData() {
		return [
			['application/rss+xml', 'application/rss+xml'],
			[null, 'text/xml; charset=UTF-8'],
		];
	}

	/**
	 * @dataProvider showData
	 *
	 * @param string $acceptHeader
	 * @param string $expectedHeader
	 */
	public function testShow($acceptHeader, $expectedHeader) {
		$this->mockUserSession('test');
		$this->data->expects($this->any())
			->method('get')
			->willReturn(['data' => []]);
		if ($acceptHeader !== null) {
			$this->request->expects($this->any())
				->method('getHeader')
				->willReturn($acceptHeader);
		}

		$templateResponse = $this->controller->show();
		$this->assertInstanceOf(TemplateResponse::class, $templateResponse, 'Asserting type of return is \OCP\AppFramework\Http\TemplateResponse');

		$headers = $templateResponse->getHeaders();
		$this->assertArrayHasKey('Content-Type', $headers);
		$this->assertEquals($expectedHeader, $headers['Content-Type']);

		$renderedResponse = $templateResponse->render();
		$this->assertNotEmpty($renderedResponse);

		$l = Util::getL10N('activity');
		$description = (string) $l->t('Your feed URL is invalid');
		$this->assertNotContains($description, $renderedResponse);
	}

	/**
	 * @dataProvider showData
	 *
	 * @param string $acceptHeader
	 * @param string $expectedHeader
	 */
	public function testShowNoToken($acceptHeader, $expectedHeader) {
		$this->manager->expects($this->any())
			->method('getCurrentUserId')
			->willThrowException(new \UnexpectedValueException());
		if ($acceptHeader !== null) {
			$this->request->expects($this->any())
				->method('getHeader')
				->willReturn($acceptHeader);
		}

		$templateResponse = $this->controller->show();
		$this->assertInstanceOf(TemplateResponse::class, $templateResponse, 'Asserting type of return is \OCP\AppFramework\Http\TemplateResponse');

		$headers = $templateResponse->getHeaders();
		$this->assertArrayHasKey('Content-Type', $headers);
		$this->assertEquals($expectedHeader, $headers['Content-Type']);

		$renderedResponse = $templateResponse->render();
		$this->assertNotEmpty($renderedResponse);

		$l = Util::getL10N('activity');
		$description = (string) $l->t('Your feed URL is invalid');
		$this->assertContains($description, $renderedResponse);
	}

	protected function mockUserSession($user) {
		$mockUser = $this->createMock(IUser::class);
		$mockUser->expects($this->any())
			->method('getUID')
			->willReturn($user);

		$this->session->expects($this->any())
			->method('isLoggedIn')
			->willReturn(true);
		$this->session->expects($this->any())
			->method('getUser')
			->willReturn($mockUser);
		$this->manager->expects($this->any())
			->method('getCurrentUserId')
			->willReturn($user);
	}
}
