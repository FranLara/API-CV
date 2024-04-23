<?php
declare(strict_types = 1);

namespace Tests\Unit\Http\Controllers\Web;

use App\Http\Controllers\Web\Landing;
use Illuminate\View\View;
use Tests\TestCase;

class LandingTest extends TestCase
{
	public function testHome(): void
	{
		$home = (new Landing())->home();

		$this->assertInstanceOf(View::class, $home);
		$this->assertSame('home', $home->getName());
	}
}
