<?php

namespace Tests\Unit;

use App\Repositories\UserRepository;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class HttpFakeTest extends TestCase
{
    private UserRepository $userRepository;

    private string $url = 'https://reqres.in/api/users'; // Possibly move to env/config

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = new UserRepository($this->url);
    }

    /** @test
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function it_fakes_users_api_response(): void
    {
        $usersJson = File::json(base_path('/tests/json/users.json'));

        Http::fake([
            'https://reqres.in/api/users*' => Http::response($usersJson)
        ]);

        $data = $this->userRepository->index(2);
        $this->assertEquals('2', $data['page']);
    }

    /** @test
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function it_fakes_user_api_response(): void
    {
        $usersJson = File::json(base_path('/tests/json/user.json'));
        Http::fake([
            'https://reqres.in/api/users/2*' => Http::response($usersJson)
        ]);

        $data = $this->userRepository->show(2);

        $this->assertEquals(
            '2',
            $data['id']
        );
    }

    /** @test */
    public function it_fakes_user_api_response_with_404(): void
    {
        $userNotFoundJson = File::json(base_path('/tests/json/user_not_found.json'));
        Http::fake([
            'https://reqres.in/api/users/233*' => Http::response($userNotFoundJson, 404)]);

        try {
            $this->userRepository->show(233);
            $this->fail("An RequestException should have been thrown by the provided Closure.");
        } catch (RequestException $e) {
        }
        $this->assertEquals(
            '404',
            $e->getCode()
        );
    }

}
