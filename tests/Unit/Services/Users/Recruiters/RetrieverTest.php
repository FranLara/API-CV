<?php
declare(strict_types = 1);

namespace Tests\Unit\Services\Users\Recruiters;

use App\BusinessObjects\DTOs\Users\Recruiter;
use App\BusinessObjects\Models\Users\Recruiter as RecruiterModel;
use App\Services\Users\Recruiters\Retriever;
use App\Services\Users\Recruiters\Transformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Tests\Unit\Services\ServiceTests;

class RetrieverTest extends ServiceTests
{
	private Retriever $retriever;

	public function testRetrieve(): void
	{
		$identifier = RecruiterModel::factory()->create()->id;
		$this->assertInstanceOf(Recruiter::class, $this->retriever->retrieve($identifier));
	}

	public function testRetrieveModelNotFoundException(): void
	{
		$this->expectException(ModelNotFoundException::class);

		$this->retriever->retrieve('test_id');
	}

	public function testRetrieveByField(): void
	{
		$email = RecruiterModel::factory()->create()->email;
		$this->assertInstanceOf(Recruiter::class, $this->retriever->retrieveByField('email', $email));
	}

	public function testRetrieveByFieldModelNotFoundException(): void
	{
		$this->expectException(ModelNotFoundException::class);

		$this->retriever->retrieveByField('email', 'test_email');
	}

	protected function setUp(): void
	{
		parent::setUp();

		$transformer = $this->createConfiguredMock(Transformer::class, ['transform' => new Recruiter()]);
		$this->retriever = new Retriever($transformer);
	}
}
