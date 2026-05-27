<?php

namespace App\Livewire\Dashboard;

use Illuminate\Support\Facades\Route;
use Livewire\Component;

class Supervisor extends Component
{
    public array $stats = [];
    public array $students = [];
    public array $taskCompletion = [];
    public array $verifications = [];
    public array $submissions = [];
    public array $messages = [];

    public function mount()
    {
        $this->stats = [
            'interns' => 12,
            'activeInternships' => 3,
            'pendingTasks' => 18,
            'pendingVerifications' => 4,
        ];

        $this->students = [
            [
                'name' => 'John Doe',
                'company' => 'Tech Corp',
                'position' => 'Software Developer',
                'progress' => 75,
                'hours' => 180,
                'totalHours' => 240,
                'status' => 'good',
                'tasks' => [
                    ['title' => 'Code Review', 'completed' => true],
                    ['title' => 'API Development', 'completed' => true],
                    ['title' => 'Testing', 'completed' => false],
                    ['title' => 'Documentation', 'completed' => false],
                ],
            ],
            [
                'name' => 'Jane Smith',
                'company' => 'Innovation Labs',
                'position' => 'UX Designer',
                'progress' => 60,
                'hours' => 150,
                'totalHours' => 240,
                'status' => 'good',
                'tasks' => [
                    ['title' => 'User Research', 'completed' => true],
                    ['title' => 'Wireframes', 'completed' => true],
                    ['title' => 'Prototyping', 'completed' => false],
                    ['title' => 'Testing', 'completed' => false],
                ],
            ],
            [
                'name' => 'Bob Wilson',
                'company' => 'Data Systems Inc',
                'position' => 'Data Analyst',
                'progress' => 45,
                'hours' => 120,
                'totalHours' => 240,
                'status' => 'warning',
                'tasks' => [
                    ['title' => 'Data Cleaning', 'completed' => true],
                    ['title' => 'Analysis Setup', 'completed' => false],
                    ['title' => 'Reporting', 'completed' => false],
                    ['title' => 'Presentation', 'completed' => false],
                ],
            ],
            [
                'name' => 'Alice Brown',
                'company' => 'Cloud Solutions',
                'position' => 'Cloud Engineer',
                'progress' => 30,
                'hours' => 80,
                'totalHours' => 240,
                'status' => 'attention',
                'tasks' => [
                    ['title' => 'Environment Setup', 'completed' => true],
                    ['title' => 'Basic Training', 'completed' => false],
                    ['title' => 'Project Work', 'completed' => false],
                    ['title' => 'Final Review', 'completed' => false],
                ],
            ],
        ];

        $this->taskCompletion = [
            'completed' => 45,
            'in_progress' => 12,
            'overdue' => 3,
            'pending' => 18,
            'rate' => 78,
        ];

        $this->verifications = [
            [
                'student' => 'John Doe',
                'type' => 'Completion Certificate',
                'category' => 'Document',
                'time' => '2 hours ago',
                'documentType' => 'Completion Certificate',
            ],
            [
                'student' => 'Jane Smith',
                'type' => 'Weekly Log',
                'category' => 'Hours',
                'time' => '5 hours ago',
                'documentType' => 'Weekly Log',
            ],
            [
                'student' => 'Bob Wilson',
                'type' => 'Progress Report',
                'category' => 'Document',
                'time' => '1 day ago',
                'documentType' => 'Progress Report',
            ],
        ];

        $this->submissions = [
            [
                'student' => 'John Doe',
                'type' => 'Logbook Entry',
                'action' => 'submitted',
                'detail' => 'Logbook entry',
                'time' => 'Yesterday 4:30 PM',
            ],
            [
                'student' => 'Alice Brown',
                'type' => 'Task',
                'action' => 'submitted',
                'detail' => 'Task: "API Documentation"',
                'time' => 'Today 9:15 AM',
            ],
            [
                'student' => 'Jane Smith',
                'type' => 'Verification',
                'action' => 'submitted',
                'detail' => 'Verification',
                'time' => 'Today 11:45 AM',
            ],
            [
                'student' => 'Bob Wilson',
                'type' => 'Weekly Report',
                'action' => 'submitted',
                'detail' => 'Weekly report',
                'time' => 'Today 2:00 PM',
            ],
        ];

        $this->messages = [
            [
                'student' => 'John Doe',
                'preview' => 'Question about task #5 - I need clarification on the requirements for the API integration module. Could you please provide more details?',
                'time' => '1 hour ago',
            ],
            [
                'student' => 'Jane Smith',
                'preview' => 'Request for feedback - I have completed the wireframes for the mobile app and would appreciate your feedback.',
                'time' => '3 hours ago',
            ],
            [
                'student' => 'Alice Brown',
                'preview' => 'Clarification needed - I am confused about the cloud architecture assignment. Could we schedule a call?',
                'time' => 'Yesterday',
            ],
        ];
    }

    public function approveVerification($index)
    {
        $student = $this->verifications[$index]['student'];
        unset($this->verifications[$index]);
        $this->verifications = array_values($this->verifications);
        $this->stats['pendingVerifications'] = count($this->verifications);
        session()->flash('message', "Verification for {$student} approved successfully.");
    }

    public function rejectVerification($index)
    {
        $student = $this->verifications[$index]['student'];
        unset($this->verifications[$index]);
        $this->verifications = array_values($this->verifications);
        $this->stats['pendingVerifications'] = count($this->verifications);
        session()->flash('message', "Verification for {$student} rejected.");
    }

    public function replyToMessage($index)
    {
        $student = $this->messages[$index]['student'];

        if (Route::has('messages.compose')) {
            return redirect()->route('messages.compose', ['student' => $student]);
        }
    }

    public function getInitialsAttribute($name)
    {
        $words = explode(' ', $name);
        $initials = '';
        foreach ($words as $word) {
            $initials .= strtoupper(substr($word, 0, 1));
        }
        return $initials;
    }

    public function getStatusColorAttribute($status)
    {
        return match ($status) {
            'good' => 'green',
            'warning' => 'yellow',
            'attention' => 'red',
            default => 'gray',
        };
    }

    public function render()
    {
        return view('livewire.dashboard.supervisor')
            ->layout('layouts.dashboard', [
                'title' => 'Supervisor Dashboard',
            ]);
    }
}

