# Syncora SaaS Dashboard System Specification

## Why
Syncora requires a modern, role-based SaaS dashboard system that provides distinct experiences for Admin, Student, Supervisor, and Company users while maintaining code reusability, clean architecture, and mobile-first responsive design inspired by Linear, Notion, and Stripe Dashboard.

## What Changes

### 1. Dashboard Layout System
- **Shared Dashboard Layout** (`layouts/dashboard.blade.php`)
  - Sticky top navigation bar
  - Collapsible responsive sidebar
  - Main content area with max-width constraints
  - Footer with copyright and version info
  
- **Sidebar Navigation** (`Components/Sidebar.php`)
  - Logo and company branding
  - Role-based navigation menu
  - Collapsible on mobile (hamburger menu)
  - Active state highlighting
  - Quick action buttons
  - User profile section

- **Top Navigation Bar** (`Components/Navbar.php`)
  - Breadcrumb navigation
  - Search functionality
  - Notification bell with badge
  - User avatar dropdown menu
  - Mobile responsive hamburger menu

### 2. Role-Based Dashboard Routing

**Route Structure:**
```
/dashboard                    → Role-specific dashboard
/admin/dashboard              → Admin dashboard
/student/dashboard            → Student dashboard  
/supervisor/dashboard        → Supervisor dashboard
/company/dashboard            → Company dashboard
```

**Middleware:** `RoleMiddleware`
- Validates user role
- Redirects to appropriate dashboard
- Protects role-specific routes

### 3. Individual Dashboard Views

#### Admin Dashboard (`Dashboard/Admin.php`)
**Widgets:**
- Total users count with trend
- Total internships count
- Active internships status
- Recent registrations chart
- System health metrics
- Quick actions panel

**Navigation Items:**
- Dashboard (overview)
- User Management
- Internship Management
- Verification Queue
- Reports & Analytics
- System Settings

#### Student Dashboard (`Dashboard/Student.php`)
**Widgets:**
- Active internship card
- Application status tracker
- Pending tasks count
- Hours logged this week
- Upcoming deadlines
- Recent notifications

**Navigation Items:**
- Dashboard (overview)
- Browse Internships
- My Applications
- My Tasks
- Logbook
- Reports
- Profile

#### Supervisor Dashboard (`Dashboard/Supervisor.php`)
**Widgets:**
- Supervised internships count
- Pending verifications
- Student progress overview
- Task completion rates
- Recent submissions
- Messages from students

**Navigation Items:**
- Dashboard (overview)
- My Internships
- Student Management
- Task Assignment
- Verification Queue
- Reports
- Messages

#### Company Dashboard (`Dashboard/Company.php`)
**Widgets:**
- Posted internships count
- Application received
- Active positions
- Hired students
- Upcoming deadlines
- Company profile completion

**Navigation Items:**
- Dashboard (overview)
- Post Internship
- Manage Internships
- Applications Received
- Student Database
- Reports

### 4. Reusable Livewire Components

#### Stats Card Component (`Components/StatsCard.php`)
```blade
<x-stats-card 
    title="Total Users"
    value="1,234"
    trend="+12%"
    trendDirection="up"
    icon="users"
    color="blue"
/>
```
**Props:**
- `title`: Card heading
- `value`: Numeric or string value
- `trend`: Percentage change (+12%, -5%)
- `trendDirection`: "up" | "down" | "neutral"
- `icon`: Heroicon name
- `color`: blue | green | yellow | red | purple | gray

#### Data Table Component (`Components/DataTable.php`)
```blade
<x-data-table 
    :headers="['Name', 'Email', 'Status', 'Actions']"
    :rows="$users"
    sortable="true"
    searchable="true"
    paginate="true"
/>
```
**Props:**
- `headers`: Array of column names
- `rows`: Collection of data
- `sortable`: Enable column sorting
- `searchable`: Enable search bar
- `paginate`: Enable pagination
- `actions`: Array of action buttons

#### Widget Card Component (`Components/Widget.php`)
```blade
<x-widget title="Recent Activity">
    <x-slot:actions>
        <button class="text-sm text-blue-600">View All</button>
    </x-slot>
    <!-- Widget content -->
</x-widget>
```

#### Notification Badge (`Components/NotificationBell.php`)
- Real-time notification count
- Dropdown with recent notifications
- Mark as read functionality
- "View all" link

#### Avatar Component (`Components/Avatar.php`)
```blade
<x-avatar 
    name="John Doe"
    email="john@example.com"
    size="md"
    src="/avatar.jpg"
/>
```
**Sizes:** xs | sm | md | lg | xl

#### Dropdown Menu (`Components/Dropdown.php`)
```blade
<x-dropdown align="right">
    <x-slot:trigger>
        <button>Open</button>
    </x-slot>
    <x-dropdown.item label="Profile" />
    <x-dropdown.item label="Settings" />
    <x-dropdown.divider />
    <x-dropdown.item label="Logout" />
</x-dropdown>
```

### 5. UI Styling System

**Color Palette:**
```css
/* Primary Colors */
--color-primary-50: #eff6ff
--color-primary-100: #dbeafe
--color-primary-200: #bfdbfe
--color-primary-500: #3b82f6
--color-primary-600: #2563eb
--color-primary-700: #1d4ed8

/* Neutral Colors */
--color-gray-50: #f9fafb
--color-gray-100: #f3f4f6
--color-gray-200: #e5e7eb
--color-gray-300: #d1d5db
--color-gray-400: #9ca3af
--color-gray-500: #6b7280
--color-gray-600: #4b5563
--color-gray-700: #374151
--color-gray-800: #1f2937
--color-gray-900: #111827
```

## MODIFIED Requirements

### Requirement: Dashboard layout has no desktop gap
The dashboard layout SHALL not show an unintended blank gap between the sidebar and the main content area on desktop breakpoints.

#### Scenario: Desktop layout alignment
- **WHEN** a user views any dashboard (Admin/Student/Supervisor/Company) at `lg` breakpoint and above
- **THEN** the main content container starts immediately to the right of the sidebar (no empty column)
- **AND** the sticky navbar aligns with the main content container (no offset gap)

#### Scenario: Collapsed sidebar alignment
- **WHEN** the sidebar is collapsed at `lg` breakpoint and above
- **THEN** the main content container aligns to the collapsed sidebar width without leaving extra space

**Typography:**
- Font Family: Inter (Google Fonts)
- Headings: font-weight: 600-700
- Body: font-weight: 400-500
- Line height: 1.5-1.75

**Spacing System:**
- Base unit: 4px
- Spacing scale: 4, 8, 12, 16, 24, 32, 48, 64, 96px

**Border Radius:**
- Small: rounded-lg (8px)
- Medium: rounded-xl (12px)
- Large: rounded-2xl (16px)

**Shadows:**
```css
/* Soft shadows for cards */
shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1);
shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1);
```

### 6. Responsive Breakpoints

```css
/* Mobile First */
sm: 640px   /* Large phones */
md: 768px   /* Tablets */
lg: 1024px  /* Small laptops */
xl: 1280px  /* Desktops */
2xl: 1536px /* Large screens */
```

**Mobile Behavior:**
- Sidebar: Hidden by default, slide-out on hamburger click
- Cards: Single column layout
- Tables: Horizontal scroll or card view
- Navigation: Bottom tab bar for main sections

**Tablet Behavior:**
- Sidebar: Collapsible (icon-only)
- Cards: 2-column grid
- Tables: Responsive with horizontal scroll

**Desktop Behavior:**
- Sidebar: Visible (expanded)
- Cards: 3-4 column grid
- Tables: Full responsive table

### 7. Animation & Transitions

**Page Transitions:**
- Fade in/out with 200ms duration
- Content slide-up animation

**Component Transitions:**
- Hover effects: 150ms ease
- Modal: Scale + fade (300ms)
- Dropdown: Slide + fade (200ms)
- Toast: Slide in from right (300ms)

### 8. Dashboard Layout Component Structure

```
app/
├── View/
│   └── Components/
│       ├── Dashboard/
│       │   ├── Sidebar.php
│       │   ├── Navbar.php
│       │   ├── Footer.php
│       │   └── Layout.php
│       ├── StatsCard.php
│       ├── DataTable.php
│       ├── Widget.php
│       ├── NotificationBell.php
│       ├── Avatar.php
│       └── Dropdown.php
└── Livewire/
    └── Dashboard/
        ├── Admin.php
        ├── Student.php
        ├── Supervisor.php
        └── Company.php
```

### 9. View Files Structure

```
resources/
└── views/
    ├── layouts/
    │   └── dashboard.blade.php
    ├── livewire/
    │   └── dashboard/
    │       ├── admin.blade.php
    │       ├── student.blade.php
    │       ├── supervisor.blade.php
    │       └── company.blade.php
    └── components/
        ├── dashboard/
        │   ├── sidebar.blade.php
        │   ├── navbar.blade.php
        │   └── footer.blade.php
        ├── stats-card.blade.php
        ├── data-table.blade.php
        ├── widget.blade.php
        ├── notification-bell.blade.php
        ├── avatar.blade.php
        └── dropdown.blade.php
```

### 10. Example Dashboard Data

**Admin Dashboard Data:**
```php
[
    'stats' => [
        'total_users' => 1234,
        'total_internships' => 89,
        'active_internships' => 45,
        'pending_verifications' => 23,
        'total_applications' => 567,
    ],
    'charts' => [
        'user_registrations' => [...],
        'internship_trends' => [...],
    ],
    'recent_activity' => [...],
]

**Student Dashboard Data:**
```php
[
    'stats' => [
        'active_internship' => [...],
        'pending_tasks' => 5,
        'hours_this_week' => 32,
        'upcoming_deadlines' => [...],
    ],
    'applications' => [...],
    'notifications' => [...],
]
```

## Impact

### Affected Code
- `app/Http/Livewire/Dashboard/` - New dashboard components
- `app/View/Components/` - New blade components
- `resources/views/layouts/` - Dashboard layout
- `resources/views/livewire/dashboard/` - Dashboard views
- `routes/web.php` - New routes
- `app/Http/Middleware/` - Role middleware
- `resources/css/app.css` - Tailwind customizations
- `tailwind.config.js` - Theme configuration

### Affected Features
- User authentication (role detection)
- Navigation system
- Dashboard analytics
- Responsive design system
- Component library

## Requirements

### Requirement: Dashboard Layout System
The system SHALL provide a shared dashboard layout with sticky navbar, collapsible sidebar, and responsive design that works on mobile, tablet, and desktop devices.

#### Scenario: Mobile User Access
- **WHEN** user accesses dashboard on mobile device
- **THEN** sidebar should be hidden by default
- **AND** hamburger menu should be visible
- **AND** content should be single column
- **AND** bottom navigation should be available

#### Scenario: Desktop User Access
- **WHEN** user accesses dashboard on desktop
- **THEN** sidebar should be expanded
- **AND** content should use 3-4 column grid
- **AND** all widgets should be visible

### Requirement: Role-Based Navigation
The system SHALL display navigation menu items specific to each user's role, showing only authorized menu items.

#### Scenario: Admin User Login
- **WHEN** admin user logs in
- **THEN** sidebar should show admin-specific menu items
- **AND** user should be redirected to `/admin/dashboard`

#### Scenario: Student User Login
- **WHEN** student user logs in
- **THEN** sidebar should show student-specific menu items
- **AND** user should be redirected to `/student/dashboard`

### Requirement: Reusable Stats Card
The system SHALL provide a stats card component that displays metrics with optional trend indicators and icons.

#### Scenario: Display Positive Trend
- **WHEN** stats card receives positive trend value
- **THEN** trend badge should show green color
- **AND** arrow icon should point up

#### Scenario: Display Negative Trend
- **WHEN** stats card receives negative trend value
- **THEN** trend badge should show red color
- **AND** arrow icon should point down

### Requirement: Responsive Data Table
The system SHALL provide a data table component that transforms into card view on mobile devices.

#### Scenario: Mobile Table View
- **WHEN** data table is viewed on mobile
- **THEN** table should transform to card layout
- **OR** table should have horizontal scroll

### Requirement: Modern SaaS UI
The system SHALL implement a clean, minimal UI with soft shadows, rounded corners, and whitespace-heavy design.

#### Scenario: Card Styling
- **WHEN** card component is rendered
- **THEN** it should have `rounded-xl` border radius
- **AND** it should have `shadow-md` shadow
- **AND** it should have proper padding and margin
