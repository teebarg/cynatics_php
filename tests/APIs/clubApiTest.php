<?php namespace Tests\APIs;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;
use App\Models\club;

class clubApiTest extends TestCase
{
    use ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function test_create_club()
    {
        $club = factory(club::class)->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/clubs', $club
        );

        $this->assertApiResponse($club);
    }

    /**
     * @test
     */
    public function test_read_club()
    {
        $club = factory(club::class)->create();

        $this->response = $this->json(
            'GET',
            '/api/clubs/'.$club->id
        );

        $this->assertApiResponse($club->toArray());
    }

    /**
     * @test
     */
    public function test_update_club()
    {
        $club = factory(club::class)->create();
        $editedclub = factory(club::class)->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/clubs/'.$club->id,
            $editedclub
        );

        $this->assertApiResponse($editedclub);
    }

    /**
     * @test
     */
    public function test_delete_club()
    {
        $club = factory(club::class)->create();

        $this->response = $this->json(
            'DELETE',
             '/api/clubs/'.$club->id
         );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/clubs/'.$club->id
        );

        $this->response->assertStatus(404);
    }
}
