<?php namespace Tests\Repositories;

use App\Models\club;
use App\Repositories\clubRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Tests\ApiTestTrait;

class clubRepositoryTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions;

    /**
     * @var clubRepository
     */
    protected $clubRepo;

    public function setUp() : void
    {
        parent::setUp();
        $this->clubRepo = \App::make(clubRepository::class);
    }

    /**
     * @test create
     */
    public function test_create_club()
    {
        $club = factory(club::class)->make()->toArray();

        $createdclub = $this->clubRepo->create($club);

        $createdclub = $createdclub->toArray();
        $this->assertArrayHasKey('id', $createdclub);
        $this->assertNotNull($createdclub['id'], 'Created club must have id specified');
        $this->assertNotNull(club::find($createdclub['id']), 'club with given id must be in DB');
        $this->assertModelData($club, $createdclub);
    }

    /**
     * @test read
     */
    public function test_read_club()
    {
        $club = factory(club::class)->create();

        $dbclub = $this->clubRepo->find($club->id);

        $dbclub = $dbclub->toArray();
        $this->assertModelData($club->toArray(), $dbclub);
    }

    /**
     * @test update
     */
    public function test_update_club()
    {
        $club = factory(club::class)->create();
        $fakeclub = factory(club::class)->make()->toArray();

        $updatedclub = $this->clubRepo->update($fakeclub, $club->id);

        $this->assertModelData($fakeclub, $updatedclub->toArray());
        $dbclub = $this->clubRepo->find($club->id);
        $this->assertModelData($fakeclub, $dbclub->toArray());
    }

    /**
     * @test delete
     */
    public function test_delete_club()
    {
        $club = factory(club::class)->create();

        $resp = $this->clubRepo->delete($club->id);

        $this->assertTrue($resp);
        $this->assertNull(club::find($club->id), 'club should not exist in DB');
    }
}
