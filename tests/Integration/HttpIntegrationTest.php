<?php

namespace Tests\Integration;

use App\Repositories\UserRepository;
use Illuminate\Http\Client\RequestException;
use Tests\TestCase;

class HttpIntegrationTest extends TestCase
{
    private UserRepository $userRepository;

    private string $url = 'https://reqres.in/api/users'; // Possibly move to env/config

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = new UserRepository($this->url);
    }

    /** @test */
    public function it_gets_users_api_response(): void
    {
        try {
            $data = $this->userRepository->index(2);
        } catch (RequestException $e) {
            $this->fail("An RequestException should not have been thrown by the provided Closure.");
        }

        $this->assertEquals(
            '2',
            $data['page']
        );
    }

    /** @test
     * @throws \Illuminate\Http\Client\RequestException
     */
    public function it_gets_user_api_response(): void
    {
        $data = $this->userRepository->show(2);

        $this->assertEquals(
            '2',
            $data['id']
        );
    }

    /** @test */
    public function it_gets_user_api_response_with_404(): void
    {
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

    /** @test */
    public function it_gets_user_create_api_response(): void
    {
        try {
            $newUser = $this->userRepository->store([
                "first_name" => "Laurence",
                "last_name" => "Fishburne",
                "job" => "leader",
                "email" => "nebuchadnezzar@zion.com",
                "avatar" => "https://upload.wikimedia.org/wikipedia/en/thumb/a/ab/Morpheus.jpg/220px-Morpheus.jpg"
            ]);
        } catch (RequestException $e) {
            $this->fail("An RequestException should not have been thrown by the provided Closure. ".$e->getMessage());
        }

        $this->assertEquals(
            'Laurence',
            $newUser['first_name']
        );
    }
}
