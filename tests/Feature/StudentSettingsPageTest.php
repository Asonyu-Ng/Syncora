<?php

namespace Tests\Feature;

use App\Livewire\Student\Settings;
use App\Models\StudentProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class StudentSettingsPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_student_settings_page_renders(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        StudentProfile::firstOrCreate(['user_id' => $student->id]);

        Livewire::actingAs($student)
            ->test(Settings::class)
            ->assertSee('Settings')
            ->assertSee('General')
            ->assertSee('Privacy')
            ->assertDontSee('Account Security');
    }

    public function test_account_security_only_renders_on_security_tab(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        StudentProfile::firstOrCreate(['user_id' => $student->id]);

        Livewire::actingAs($student)
            ->test(Settings::class)
            ->set('tab', 'security')
            ->assertSee('Account Security')
            ->assertSee('Password')
            ->assertSee('Two-Factor Authentication')
            ->assertSee('Active Sessions');
    }

    public function test_student_settings_persist_to_student_profile_settings_json(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $profile = StudentProfile::firstOrCreate(['user_id' => $student->id]);

        Livewire::actingAs($student)
            ->test(Settings::class)
            ->set('notifyAnnouncements', true)
            ->set('privacyProfileVisibility', 'private')
            ->set('language', 'French')
            ->set('timezone', 'UTC')
            ->set('theme', 'dark');

        $profile->refresh();

        $this->assertSame(true, $profile->settings['notifications']['announcements'] ?? null);
        $this->assertSame('private', $profile->settings['privacy']['profile_visibility'] ?? null);
        $this->assertSame('French', $profile->settings['region']['language'] ?? null);
        $this->assertSame('UTC', $profile->settings['region']['timezone'] ?? null);
        $this->assertSame('dark', $profile->settings['appearance']['theme'] ?? null);
    }

    public function test_profile_dropdown_links_to_student_profile_and_settings_pages(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        StudentProfile::firstOrCreate(['user_id' => $student->id]);

        $this->actingAs($student);

        $html = view('components.dashboard.profile-dropdown')->render();

        $this->assertStringContainsString(route('student.profile'), $html);
        $this->assertStringContainsString(route('student.settings'), $html);
    }
}
