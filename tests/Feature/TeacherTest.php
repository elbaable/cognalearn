<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Teachers;
use App\Models\Courses;
use App\Models\CourseMember;

class teacherTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function test_teacher_index()
    {
        $teacher = Teachers::factory()->create();

        $this->actingAsAdmin()
            ->get("teachers")
            ->assertOk()
            ->assertSee($teacher->firstName)
            ->assertSee($teacher->lastName)
            ->assertSee($teacher->email);
    }

    public function test_teacher_search()
    {
        $teacher = teachers::factory()->create(['firstName' => 'first', 'lastName' => 'last', 'email' => 'test@email.com']);
        $params = [
            'firstName' => 'first',
            'lastName' => 'last',
            'email' => 'test'
        ];

        $this->actingAsAdmin()
            ->post("teachers", $params)
            ->assertOk()
            ->assertSee($teacher->firstName)
            ->assertSee($teacher->lastName)
            ->assertSee($teacher->email);
    }

    public function test_teacher_detail()
    {
        $course = Courses::factory()->create();
        $teacher = Teachers::factory()->create();
        CourseMember::factory()->create(['teacherID' => $teacher->id, 'teacherID' => $teacher->id]);

        $this->actingAsAdmin()
            ->get("teacher/{$teacher->id}")
            ->assertOk()
            ->assertSee($teacher->firstName)
            ->assertSee($teacher->lastName)
            ->assertSee($teacher->email);
    }

    public function test_teacher_store()
    {
        $params = $this->validParams();

        $this->actingAsAdmin()
            ->post('add-teacher', $params)
            ->assertStatus(302);

        $teacher = teachers::first();

        $this->assertDatabaseHas('teachers', $params);
    }

    public function test_teacher_store_fail()
    {
        $params = $this->validParams(['content' => null]);

        $this->actingAsAdmin()
            ->post('add-teacher', $params)
            ->assertStatus(302)
            ->assertSessionHas('success');
    }

    public function test_teacher_edit()
    {
        $teacher = teachers::factory()->create();

        $this->actingAsAdmin()
            ->get("edit-teacher/{$teacher->id}")
            ->assertOk()
            ->assertSee($teacher->firstName)
            ->assertSee($teacher->lastName)
            ->assertSee($teacher->email)
            ->assertSee($teacher->phone);
    }

    public function test_teacher_update()
    {
        $teacher = teachers::factory()->create();
        $params = $this->validParams();
        $params['id'] = $teacher->id;

        $response = $this->actingAsAdmin()
            ->post("update-teacher", $params)
            ->assertStatus(302)
            ->assertSessionHas('success');

        $teacher->refresh();

        $this->assertDatabaseHas('teachers', $params);
        $this->assertEquals($params['firstName'], $teacher->firstName);
    }

    public function test_teacher_delete()
    {
        $teacher = teachers::factory()->create();

        $this->actingAsAdmin()
            ->get("delete-teacher/{$teacher->id}")
            ->assertStatus(302)
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('teachers', $teacher->toArray());
    }

    public function test_courses_store()
    {
        $courses = array(1,2,3,4);
        $params = [
            'id' => 1,
            'courses' => $courses
        ];

        $this->actingAsAdmin()
            ->post('add-courses', $params)
            ->assertStatus(302)
            ->assertSessionHas('success');

        $courseMember = CourseMember::all();
        for($i = 0; $i < count($courseMember);$i++){
            $this->assertEquals($params['id'], $courseMember[$i]->teacherID);
            $this->assertEquals($params['courses'][$i], $courseMember[$i]->courseID);
        }
    }

    /**
    * Valid params for updating or creating a resource
    *
    * @param  array  $overrides new params
    * @return array Valid params for updating or creating a resource
    */
    private function validParams($overrides = [])
    {
        return array_merge([
            'firstName' => 'first', //required
            'lastName' => 'last', //required
            'email' => "test@email.com", //valid email
            'phone' => "+1 123 456 7890", //required
        ], $overrides);
    }
}
