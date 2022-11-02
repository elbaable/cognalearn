<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Teachers;
use App\Models\Courses;
use App\Models\CourseMember;

class CourseTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use RefreshDatabase;

    public function test_course_index()
    {
        $course = Courses::factory()->create();

        $this->actingAsAdmin()
            ->get("/")
            ->assertOk()
            ->assertSee($course->name)
            ->assertSee($course->courseCode)
            ->assertSee($course->description);
    }

    public function test_course_search()
    {
        $course = Courses::factory()->create(['name' => 'Hello World', 'courseCode' => 'code']);
        $params = [
            'name' => 'Hello',
            'code' => 'cod'
        ];

        $this->actingAsAdmin()
            ->post("/", $params)
            ->assertOk()
            ->assertSee($course->name)
            ->assertSee($course->courseCode)
            ->assertSee($course->description);
    }

    public function test_course_detail()
    {
        $course = Courses::factory()->create();
        $teacher = Teachers::factory()->create();
        CourseMember::factory()->create(['teacherID' => $teacher->id, 'courseID' => $course->id]);

        $this->actingAsAdmin()
            ->get("course/{$course->id}")
            ->assertOk()
            ->assertSee($course->name)
            ->assertSee($teacher->firstName);
    }

    public function test_course_store()
    {
        $params = $this->validParams();

        $this->actingAsAdmin()
            ->post('add-course', $params)
            ->assertStatus(302);

        $course = Courses::first();

        $this->assertDatabaseHas('courses', $params);
    }

    public function test_course_store_fail()
    {
        $params = $this->validParams(['content' => null]);

        $this->actingAsAdmin()
            ->post('add-course', $params)
            ->assertStatus(302)
            ->assertSessionHas('success');
    }

    public function test_course_edit()
    {
        $course = Courses::factory()->create();

        $this->actingAsAdmin()
            ->get("edit-course/{$course->id}")
            ->assertOk()
            ->assertSee($course->name)
            ->assertSee($course->courseCode)
            ->assertSee($course->description);
    }

    public function test_course_update()
    {
        $course = Courses::factory()->create();
        $params = $this->validParams();
        $params['id'] = $course->id;

        $response = $this->actingAsAdmin()
            ->post("update-course", $params)
            ->assertStatus(302)
            ->assertSessionHas('success');

        $course->refresh();

        $this->assertDatabaseHas('courses', $params);
        $this->assertEquals($params['description'], $course->description);
    }

    public function test_course_delete()
    {
        $course = Courses::factory()->create();

        $this->actingAsAdmin()
            ->get("delete-course/{$course->id}")
            ->assertStatus(302)
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('courses', $course->toArray());
    }

    public function test_teachers_store()
    {
        $teachers = array(1,2,3,4);
        $params = [
            'id' => 1,
            'teachers' => $teachers
        ];

        $this->actingAsAdmin()
            ->post('add-teachers', $params)
            ->assertStatus(302)
            ->assertSessionHas('success');

        $courseMember = CourseMember::all();
        for($i = 0; $i < count($courseMember);$i++){
            $this->assertEquals($params['id'], $courseMember[$i]->courseID);
            $this->assertEquals($params['teachers'][$i], $courseMember[$i]->teacherID);
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
            'name' => 'hello world', //required
            'courseCode' => 'courseCode', //min 5
            'description' => "I'm a description I'm a description I'm a description I'm a description I'm a description I'm a description", //min 50
            'startDate' => now()->format('Y-m-d'), //required
            'endDate' => now()->format('Y-m-d'), //required
        ], $overrides);
    }
}
