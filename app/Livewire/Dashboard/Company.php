<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Company extends Component
{
    public array $company = [];
    public array $activeInternships = [];
    public int $totalApplications = 0;
    public int $totalHired = 0;
    public array $pipeline = [];
    public array $recentApplications = [];
    public array $recommendedStudents = [];
    public array $profileCompletion = [];

    public function mount()
    {
        $this->company = [
            'name' => 'TechCorp Inc.',
            'logo' => '/logos/techcorp.png',
            'profileCompletion' => 75
        ];

        $this->activeInternships = [
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
            [
                'id' => 3,
                'title' => 'Marketing Intern',
                'location' => 'New York, NY',
                'duration' => '3 months',
                'applications' => 50,
                'status' => 'active',
                'posted' => '3 days ago',
                'description' => 'Help drive our marketing initiatives across multiple channels.'
            ]
        ];

        $this->totalApplications = 127;
        $this->totalHired = 2;

        $this->pipeline = [
            'applied' => 127,
            'under_review' => 45,
            'interview' => 12,
            'final_round' => 5,
            'offered' => 3,
            'hired' => 2
        ];

        $this->recentApplications = [
            [
                'student' => 'John Doe',
                'internship' => 'Software Development',
                'university' => 'Stanford University',
                'major' => 'Computer Science',
                'time' => '2 hours ago',
                'avatar' => 'JD'
            ],
            [
                'student' => 'Jane Smith',
                'internship' => 'UX Design',
                'university' => 'MIT',
                'major' => 'Design',
                'time' => '5 hours ago',
                'avatar' => 'JS'
            ],
            [
                'student' => 'Bob Wilson',
                'internship' => 'Marketing',
                'university' => 'Harvard',
                'major' => 'Business',
                'time' => '1 day ago',
                'avatar' => 'BW'
            ],
            [
                'student' => 'Alice Johnson',
                'internship' => 'Software Development',
                'university' => 'UC Berkeley',
                'major' => 'Computer Science',
                'time' => '1 day ago',
                'avatar' => 'AJ'
            ],
            [
                'student' => 'Michael Brown',
                'internship' => 'Marketing',
                'university' => 'UCLA',
                'major' => 'Marketing',
                'time' => '2 days ago',
                'avatar' => 'MB'
            ]
        ];

        $this->recommendedStudents = [
            [
                'name' => 'Jane Doe',
                'university' => 'Stanford University',
                'gpa' => 3.8,
                'major' => 'Computer Science',
                'match' => 95,
                'position' => 'Software Development',
                'avatar' => 'JDo'
            ],
            [
                'name' => 'John Smith',
                'university' => 'MIT',
                'gpa' => 3.9,
                'major' => 'Design',
                'match' => 92,
                'position' => 'UX Design',
                'avatar' => 'JSm'
            ],
            [
                'name' => 'Alice Johnson',
                'university' => 'UC Berkeley',
                'gpa' => 3.7,
                'major' => 'Business',
                'match' => 88,
                'position' => 'Marketing',
                'avatar' => 'AJo'
            ]
        ];

        $this->profileCompletion = [
            'total' => 75,
            'items' => [
                ['label' => 'Company logo uploaded', 'completed' => true],
                ['label' => 'Company description added', 'completed' => true],
                ['label' => 'Contact information verified', 'completed' => true],
                ['label' => 'Benefits package not added', 'completed' => false],
                ['label' => 'Video introduction not added', 'completed' => false]
            ]
        ];
    }

    public function getStatsProperty()
    {
        return [
            'postedInternships' => 8,
            'postedInternshipsTrend' => '+2',
            'applicationsReceived' => 127,
            'applicationsReceivedTrend' => '+23',
            'activePositions' => 3,
            'hiredThisMonth' => 2
        ];
    }

    public function getPipelinePercentages()
    {
        $max = $this->pipeline['applied'];

        return [
            'applied' => 100,
            'under_review' => ($this->pipeline['under_review'] / $max) * 100,
            'interview' => ($this->pipeline['interview'] / $max) * 100,
            'final_round' => ($this->pipeline['final_round'] / $max) * 100,
            'offered' => ($this->pipeline['offered'] / $max) * 100,
            'hired' => ($this->pipeline['hired'] / $max) * 100
        ];
    }

    public function getMissingProfileItems()
    {
        return array_filter($this->profileCompletion['items'], fn ($item) => !$item['completed']);
    }

    public function viewInternship($id)
    {
        if (Route::has('internships.show')) {
            return redirect()->route('internships.show', $id);
        }
    }

    public function viewApplication($index)
    {
        if (Route::has('applications.show')) {
            return redirect()->route('applications.show', $index);
        }
    }

    public function quickReview($index)
    {
        session()->flash('message', 'Application review initiated for ' . $this->recentApplications[$index]['student']);
    }

    public function viewStudent($index)
    {
        if (Route::has('students.show')) {
            return redirect()->route('students.show', $index);
        }
    }

    public function render()
    {
        return view('livewire.dashboard.company')
            ->layout('layouts.dashboard', [
                'title' => 'Company Dashboard',
            ]);
    }
}

