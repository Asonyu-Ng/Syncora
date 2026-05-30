<?php

namespace Tests\Feature;

use App\Livewire\Student\Profile;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StudentProfilePageTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_profile_page_renders(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        StudentProfile::firstOrCreate(['user_id' => $student->id], [
            'university' => 'University of Bameda',
            'department' => 'Computer Science',
            'level' => '300',
        ]);

        Livewire::actingAs($student)
            ->test(Profile::class)
            ->assertSee('My Profile')
            ->assertSee('Profile Information')
            ->assertSee('Academic Summary');
    }

    public function test_student_can_update_profile_details(): void
    {
        $student = User::factory()->create(['role' => 'student', 'name' => 'Old Name']);
        StudentProfile::firstOrCreate(['user_id' => $student->id]);

        Livewire::actingAs($student)
            ->test(Profile::class)
            ->set('name', 'New Name')
            ->set('phone', '+1 555 0100')
            ->set('address', 'Chicago, IL')
            ->set('university', 'University of Lagos')
            ->set('department', 'Software Engineering')
            ->set('level', '300')
            ->set('bio', 'Bio text')
            ->call('saveProfile')
            ->assertDispatched('close-modal', 'student-profile-edit');

        $this->assertDatabaseHas('users', [
            'id' => $student->id,
            'name' => 'New Name',
        ]);

        $this->assertDatabaseHas('student_profiles', [
            'user_id' => $student->id,
            'phone' => '+1 555 0100',
            'address' => 'Chicago, IL',
            'university' => 'University of Lagos',
            'department' => 'Software Engineering',
            'level' => '300',
        ]);
    }
}

