<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Team as ModelTeam;
use App\Models\User;

class TeamTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */




     /** @test */
    public function a_team_has_a_name()
    {
        $team=new ModelTeam(['name'=>'Flexi']);

        $this->assertEquals('Flexi',$team->name);
    }

    /** @test */
    public function a_team_can_add_member()
    {
        $team=ModelTeam::factory()->create();

        $User=User::factory()->create();
        $UserTwo=User::factory()->create();

        $team->add($User);
        $team->add($UserTwo);

        $this->assertEquals(2,$team->count());

    }

    /** @test */
    public function a_team_has_maximum_size()
    {
        $team=ModelTeam::factory()->create(['size'=>2]);

        $User=User::factory()->create();
        $UserTwo=User::factory()->create();

        $team->add($User);
        $team->add($UserTwo);

        $this->assertEquals(2,$team->count());

        $this->expectException('Exception');

        $UserThree=User::factory()->create();

        $team->add($UserThree);
    }

    /** @test */
    public function a_team_can_add_multi_user()
    {
        $team=ModelTeam::factory()->create();

        $User=User::factory()->count(2)->create();

        $team->add($User);

        $this->assertEquals(2,$team->count());
    }

    /** @test */
    public function a_team_can_remove_a_member()
    {
        $team=ModelTeam::factory()->create();

        $User=User::factory()->count(2)->create();

        $team->add($User);

        $team->remove($User[0]);

        $this->assertEquals(1,$team->count());
    }

    /** @test */
    public function a_team_can_remove_all_members_at_once()
    {
        $team=ModelTeam::factory()->create();

        $User=User::factory()->count(2)->create();

        $team->add($User);

        $team->restart();

        $this->assertEquals(0,$team->count());
    }

    /** @test */
    public function a_team_can_remove_more_members_at_once()
    {
        $team=ModelTeam::factory()->create();

        $User=User::factory()->count(3)->create();

        $team->add($User);

        $team->remove($User->slice(0,2));

        $this->assertEquals(1,$team->count());
    }

    /** @test */
    public function when_a_team_add_many_members_at_once()
    {
        $team=ModelTeam::factory()->create(['size'=>2]);

        $User=User::factory()->count(3)->create();

        $this->expectException('Exception');

        $team->add($User);

    }



}
