<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class DashboardController extends Controller
{
    public function admin(): View
    {
        $stats = [
            'totalUsers' => 1234,
            'userTrend' => '+12%',
            'totalInternships' => 89,
            'internshipTrend' => '+8%',
            'activeApplications' => 567,
            'applicationTrend' => '-3%',
            'pendingVerifications' => 23,
        ];

        $registrationData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
            'values' => [120, 145, 132, 168, 195, 210, 245],
        ];

        $activities = [
            [
                'icon' => 'user',
                'title' => 'John Doe registered as Student',
                'time' => '2 minutes ago',
                'type' => 'registration',
            ],
            [
                'icon' => 'briefcase',
                'title' => 'New internship posted: Software Developer',
                'time' => '15 minutes ago',
                'type' => 'internship',
            ],
            [
                'icon' => 'shield-check',
                'title' => 'Verification approved for Jane Smith',
                'time' => '1 hour ago',
                'type' => 'verification',
            ],
            [
                'icon' => 'document-text',
                'title' => 'Application submitted for Marketing Intern',
                'time' => '2 hours ago',
                'type' => 'application',
            ],
        ];

        return view('livewire.dashboard.admin', [
            'title' => 'Admin Dashboard',
            'stats' => $stats,
            'registrationData' => $registrationData,
            'activities' => $activities,
        ]);
    }

    public function student(): View
    {
        $user = [
            'name' => 'John Doe',
            'email' => 'john.doe@student.edu'
        ];

        $activeInternship = [
            'company' => 'TechCorp Inc.',
            'position' => 'Software Development Intern',
            'startDate' => '2026-01-15',
            'endDate' => '2026-04-15',
            'progress' => 45,
            'supervisor' => 'Dr. Sarah Johnson'
        ];

        $tasks = [
            [
                'title' => 'Complete API documentation',
                'due' => 'Tomorrow',
                'priority' => 'high'
            ],
            [
                'title' => 'Code review for feature X',
                'due' => 'In 3 days',
                'priority' => 'medium'
            ],
            [
                'title' => 'Write unit tests',
                'due' => 'Next week',
                'priority' => 'low'
            ],
        ];

        $hoursThisWeek = [
            'logged' => 32,
            'target' => 40,
        ];

        $notifications = [
            [
                'title' => 'Task assigned: Update documentation',
                'time' => '2 hours ago',
                'unread' => true
            ],
            [
                'title' => 'Logbook entry approved by supervisor',
                'time' => '5 hours ago',
                'unread' => true
            ],
            [
                'title' => 'New message from Dr. Johnson',
                'time' => '1 day ago',
                'unread' => true
            ],
        ];

        return view('livewire.dashboard.student', [
            'title' => 'Student Dashboard',
            'user' => $user,
            'activeInternship' => $activeInternship,
            'tasks' => $tasks,
            'hoursThisWeek' => $hoursThisWeek,
            'hoursThisMonth' => 128,
            'notifications' => $notifications,
        ]);
    }

    public function supervisor(): View
    {
        $stats = [
            'interns' => 12,
            'activeInternships' => 3,
            'pendingTasks' => 18,
            'pendingVerifications' => 4,
        ];

        $students = [
            [
                'name' => 'John Doe',
                'company' => 'Tech Corp',
                'position' => 'Software Developer',
                'progress' => 75,
                'status' => 'good',
            ],
            [
                'name' => 'Jane Smith',
                'company' => 'Innovation Labs',
                'position' => 'UX Designer',
                'progress' => 60,
                'status' => 'good',
            ],
            [
                'name' => 'Bob Wilson',
                'company' => 'Data Systems Inc',
                'position' => 'Data Analyst',
                'progress' => 45,
                'status' => 'warning',
            ],
        ];

        $verifications = [
            [
                'student' => 'John Doe',
                'type' => 'Completion Certificate',
                'time' => '2 hours ago',
            ],
            [
                'student' => 'Jane Smith',
                'type' => 'Weekly Log',
                'time' => '5 hours ago',
            ],
        ];

        return view('livewire.dashboard.supervisor', [
            'title' => 'Supervisor Dashboard',
            'stats' => $stats,
            'students' => $students,
            'verifications' => $verifications,
        ]);
    }

    public function company(): View
    {
        $stats = [
            'postedInternships' => 8,
            'postedInternshipsTrend' => '+2',
            'applicationsReceived' => 127,
            'applicationsReceivedTrend' => '+23',
            'activePositions' => 3,
            'hiredThisMonth' => 2
        ];

        $activeInternships = [
            [
                'id' => 1,
                'title' => 'Software Development Intern',
                'location' => 'San Francisco, CA',
                'duration' => '3 months',
                'applications' => 45,
                'status' => 'active',
                'posted' => '2 weeks ago',
                'description' => 'Join our engineering team to build cutting-edge software solutions.'
            ],
            [
                'id' => 2,
                'title' => 'UX Design Intern',
                'location' => 'Remote',
                'duration' => '6 months',
                'applications' => 32,
                'status' => 'active',
                'posted' => '1 week ago',
                'description' => 'Work with our design team to create intuitive user experiences.'
            ],
        ];

        $recentApplications = [
            [
                'student' => 'John Doe',
                'internship' => 'Software Development',
                'university' => 'Stanford University',
                'major' => 'Computer Science',
                'time' => '2 hours ago',
            ],
            [
                'student' => 'Jane Smith',
                'internship' => 'UX Design',
                'university' => 'MIT',
                'major' => 'Design',
                'time' => '5 hours ago',
            ],
        ];

        return view('livewire.dashboard.company', [
            'title' => 'Company Dashboard',
            'stats' => $stats,
            'activeInternships' => $activeInternships,
            'recentApplications' => $recentApplications,
        ]);
    }
}

