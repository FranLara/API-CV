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

		self::assertInstanceOf(View::class, $home);
		self::assertSame('home', $home->getName());
	}
}
