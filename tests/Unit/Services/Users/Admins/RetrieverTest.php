<?php
declare(strict_types = 1);

namespace Tests\Unit\Services\Users\Admins;

use App\BusinessObjects\DTOs\Users\Admin;
use App\BusinessObjects\Models\Users\Admin as AdminModel;
use App\Services\Users\Admins\Retriever;
use App\Services\Users\Admins\Transformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\Unit\Services\ServiceTest;

class RetrieverTest extends ServiceTest
{
	private Retriever $retriever;

	public function testRetrieve(): void
	{
		$identifier = AdminModel::factory()->create()->id;
		$this->assertInstanceOf(Admin::class, $this->retriever->retrieve($identifier));
	}

	public function testRetrieveModelNotFoundException(): void
	{
		$this->expectException(ModelNotFoundException::class);

		$this->retriever->retrieve('test_id');
	}

	public function testRetrieveByField(): void
	{
		$username = AdminModel::factory()->create()->username;
		$this->assertInstanceOf(Admin::class, $this->retriever->retrieveByField('username', $username));
	}

	public function testRetrieveByFieldModelNotFoundException(): void
	{
		$this->expectException(ModelNotFoundException::class);

		$this->retriever->retrieveByField('username', 'test_username');
	}

	protected function setUp(): void
	{
		parent::setUp();

		$transformer = $this->createConfiguredMock(Transformer::class, ['transform' => new Admin()]);
		$this->retriever = new Retriever($transformer);
	}
}
