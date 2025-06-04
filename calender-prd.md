# PRD: Calendar Integration for Class Scheduling (Enhanced)

---

## 1. Overview

**Purpose**  
This document describes the requirements for integrating complex class scheduling data into a comprehensive calendar system within our custom WordPress app. The calendar will provide administrators with a centralized view of all scheduled class sessions, recurring patterns, exception/cancellation dates, agent assignments, and public holidays with sophisticated conflict management.

**Background**  
We have a comprehensive "New Class" form that captures extensive scheduling data including:
- Recurring schedule patterns (weekly, biweekly, monthly, custom)
- Complex time slot management with automatic duration calculations
- Dynamic exception date handling with reason codes
- Sophisticated public holiday conflict detection and override capabilities
- Stop/restart date history for class interruptions
- Agent assignments with backup agent scheduling
- Learner management with exam subset tracking
- Comprehensive schedule statistics and analytics

Currently, administrators must view and manage class schedules via list views and individual class pages. By introducing a calendar view (using our existing FullCalendar integration), we aim to:  
- Provide centralized visualization of complex recurring schedules
- Surface exception/cancellation days with contextual information
- Display agent assignments and backup scheduling
- Show holiday conflicts and override status
- Prevent double-booking and reduce manual schedule lookups
- Integrate schedule analytics for better resource planning

**Stakeholder**  
- **Primary User:** Administrators (Admins only)
- **Secondary Users:** Project Supervisors (view-only access)
- **Tech Stack:** WordPress (PHP + PostgreSQL), FullCalendar (already integrated), Bootstrap 5

---

## 2. Goals & Objectives

1. **Centralized Schedule Visualization**  
   - Present all class sessions in a comprehensive calendar view with multiple viewing options
   - Display recurring patterns with visual indicators
   - Overlay exception/cancellation dates, public holidays, and stop/restart periods
   - Show agent assignments and backup scheduling

2. **Enhanced Contextual Details**  
   - Enable admins to hover or click on any calendar event to see comprehensive metadata
   - Display agent assignments, learner counts, exception reasons, and schedule statistics
   - Provide quick access to edit functionality

3. **Data Consistency & Source-of-Truth**  
   - Leverage the existing complex class data as the single source of truth
   - Automatically generate recurring events based on sophisticated schedule patterns
   - Handle complex scenarios like stop/restart dates, agent changes, and holiday overrides

4. **Advanced Schedule Management**  
   - Provide visual conflict detection for agent double-booking
   - Show schedule density and resource utilization
   - Integrate with existing schedule statistics and analytics

5. **Phased Interaction Model**  
   - **Phase 1:** Read-only calendar display with comprehensive event details
   - **Phase 2:** Interactive features like filtering and search
   - **Phase 3:** Limited editing capabilities (reschedule, agent assignment)
   - **Phase 4:** Full calendar-based schedule management

---

## 3. Enhanced Scope

### In Scope

#### **Event Types (Comprehensive)**
- **Regular Class Sessions:** Generated from recurring patterns with full schedule complexity
- **Exception/Cancellation Dates:** Multiple types with reason codes and impact analysis
- **Public Holidays:** Dynamic conflict detection with override status display
- **Stop/Restart Periods:** Class interruption periods with restart scheduling
- **Agent Assignment Events:** Primary agent, backup agents, and agent change history
- **Schedule Milestones:** Delivery dates, QA visits, exam dates

#### **Calendar Views**
- **Month-View (Primary):** Comprehensive monthly grid with event density management
- **Week-View (Phase 2):** Detailed weekly view with time slots and agent scheduling
- **Agenda-View (Phase 3):** List-based view with filtering and search capabilities

#### **Event Detail Display (Enhanced)**
On hover or click, display comprehensive information:
- **Class Information:** Code, subject, type, duration, learner count
- **Schedule Details:** Time slots, recurring pattern, total sessions
- **Staff Assignments:** Primary agent, backup agents, project supervisor
- **Status Information:** SETA funding, exam class designation, completion status
- **Exception Details:** Reason codes, impact on schedule, makeup sessions
- **Holiday Information:** Override status, conflict resolution

#### **Advanced Features**
- **Visual Conflict Detection:** Highlight agent double-booking and resource conflicts
- **Schedule Statistics Integration:** Display analytics from existing statistics system
- **Filtering and Search:** By agent, client, class type, status
- **Export Capabilities:** Calendar data export for reporting

### Out of Scope (Initial Phase)
- Full drag-and-drop editing (reserved for Phase 3)
- Learner-facing calendar views
- Real-time collaborative editing
- Mobile-optimized views (desktop/tablet focus)

---

## 4. Enhanced Functional Requirements

### 4.1 Comprehensive Data Sources & Mapping

| **Data Source** | **Form Field(s)** | **Calendar Representation** |
|-----------------|-------------------|------------------------------|
| **Recurring Schedule Patterns** | • Schedule Pattern (weekly/biweekly/monthly/custom)<br>• Days of Week (checkbox array)<br>• Start/End Times<br>• Duration calculations<br>• Start/End Dates | • **Series Events:** Each occurrence as individual event<br>• **Pattern Indicator:** Visual cue for recurring series<br>• **Time Display:** Precise start/end times<br>• **Duration Badge:** Hours indicator |
| **Exception Management** | • Exception Dates array<br>• Exception Reasons (Client Cancelled, Agent Absent, etc.)<br>• Impact on schedule | • **Exception Events:** Distinct visual styling<br>• **Reason Display:** Tooltip with full context<br>• **Impact Indicator:** Shows affected sessions |
| **Holiday Conflict System** | • Dynamic holiday detection<br>• Override status per holiday<br>• Conflict resolution | • **Holiday Events:** Base layer display<br>• **Override Indicators:** Visual status of overrides<br>• **Conflict Badges:** Shows resolution status |
| **Stop/Restart History** | • Stop Dates array<br>• Restart Dates array<br>• Reason tracking | • **Period Blocks:** Visual representation of gaps<br>• **Restart Indicators:** Clear restart points<br>• **Impact Display:** Shows schedule adjustments |
| **Agent Assignments** | • Initial Class Agent<br>• Backup Agents with dates<br>• Agent change history | • **Agent Badges:** Color-coded by agent<br>• **Backup Indicators:** Secondary agent display<br>• **Change Markers:** Visual agent transitions |
| **Schedule Statistics** | • Total sessions, hours<br>• Calendar days, weeks<br>• Attendance impact metrics | • **Statistics Panel:** Integrated analytics display<br>• **Progress Indicators:** Completion status<br>• **Utilization Metrics:** Resource usage display |

### 4.2 Enhanced Calendar Display & Event Types

#### **Visual Hierarchy & Color Coding**
```css
/* Primary Event Types */
.event-session-regular     { background: #0d6efd; }  /* Blue - Regular sessions */
.event-session-makeup      { background: #6f42c1; }  /* Purple - Makeup sessions */
.event-exception          { background: #dc3545; }  /* Red - Exceptions/cancellations */
.event-holiday            { background: #6c757d; }  /* Gray - Public holidays */
.event-holiday-override   { background: #fd7e14; }  /* Orange - Overridden holidays */
.event-stop-period        { background: #ffc107; }  /* Yellow - Stop periods */
.event-agent-change       { border-left: 4px solid #20c997; } /* Teal border - Agent changes */

/* Agent Color Coding */
.agent-primary            { border-top: 3px solid #198754; }    /* Green - Primary agent */
.agent-backup             { border-top: 3px solid #0dcaf0; }    /* Cyan - Backup agent */

/* Status Indicators */
.status-seta-funded       { badge: "SETA" color: #198754; }     /* Green badge */
.status-exam-class        { badge: "EXAM" color: #fd7e14; }     /* Orange badge */
.status-completed         { opacity: 0.7; text-decoration: line-through; }
```

#### **Event Rendering (Advanced)**
- **Month-View Grid:**
  - Intelligent event stacking with priority ordering
  - "+X more" indicator with expandable details
  - Agent color-coding on event borders
  - Status badges for SETA/Exam classes
  - Conflict indicators for overlapping schedules

- **Event Density Management:**
  - Automatic grouping of related events
  - Expandable event clusters
  - Visual indicators for high-density days
  - Overflow handling with modal details

#### **Enhanced Tooltips & Popovers**

**For Regular Class Sessions:**
```
┌─────────────────────────────────────┐
│ Class Code: 11-REALLL-RLN-2025-06-25│
│ Subject: Real Estate Law & Practice  │
│ Time: 08:00 – 12:00 (4 hours)       │
│ Agent: ID123 : John Smith            │
│ Backup: ID456 : Jane Doe             │
│ Learners: 15 (12 exam candidates)   │
│ Status: SETA Funded, Exam Class     │
│ ─────────────────────────────────── │
│ [Edit Class] [View Details]          │
└─────────────────────────────────────┘
```

**For Exception Events:**
```
┌─────────────────────────────────────┐
│ CANCELLED: 11-REALLL-RLN-2025-06-25│
│ Reason: Client Cancelled             │
│ Impact: 1 session, 4 hours lost     │
│ Makeup: Scheduled for 2025-07-02    │
│ ─────────────────────────────────── │
│ [Edit Class] [Schedule Makeup]       │
└─────────────────────────────────────┘
```

**For Holiday Conflicts:**
```
┌─────────────────────────────────────┐
│ PUBLIC HOLIDAY: Youth Day            │
│ Conflicts with: 2 scheduled classes │
│ Override Status: Classes Cancelled   │
│ Alternative: Makeup sessions planned │
│ ─────────────────────────────────── │
│ [View Conflicts] [Manage Overrides] │
└─────────────────────────────────────┘
```

### 4.3 Advanced Recurrence & Event Generation

#### **Recurring Pattern Engine**
- **Server-Side Calculation:** PHP-based recurrence engine handling complex patterns
- **Pattern Types:**
  - Weekly: Specific days of week with custom intervals
  - Biweekly: Every two weeks on selected days
  - Monthly: Specific day of month or relative positioning
  - Custom: User-defined intervals and exceptions

#### **Exception Handling Logic**
```php
// Pseudo-code for exception handling
function generateCalendarEvents($classId, $startDate, $endDate) {
    $baseSchedule = getRecurringSchedule($classId);
    $exceptions = getExceptionDates($classId);
    $stopRestartPeriods = getStopRestartHistory($classId);
    $holidays = getHolidayConflicts($classId, $startDate, $endDate);

    $events = [];

    // Generate base recurring events
    foreach ($baseSchedule->getOccurrences($startDate, $endDate) as $occurrence) {
        // Skip if in stop period
        if ($this->isInStopPeriod($occurrence, $stopRestartPeriods)) {
            continue;
        }

        // Check for exceptions
        if ($this->hasException($occurrence, $exceptions)) {
            $events[] = $this->createExceptionEvent($occurrence, $exceptions);
            continue;
        }

        // Check for holiday conflicts
        if ($this->hasHolidayConflict($occurrence, $holidays)) {
            $events[] = $this->createHolidayConflictEvent($occurrence, $holidays);
            if (!$this->isHolidayOverridden($occurrence, $holidays)) {
                continue; // Skip regular session if holiday not overridden
            }
        }

        // Create regular session event
        $events[] = $this->createSessionEvent($occurrence);
    }

    return $events;
}
```

### 4.4 Schedule Statistics Integration

#### **Analytics Panel**
Integrate existing schedule statistics into calendar view:

- **Training Duration Metrics:**
  - Total calendar days, weeks, months
  - Actual training days (excluding exceptions)
  - Completion percentage

- **Session Analytics:**
  - Total scheduled sessions vs. completed
  - Total training hours vs. delivered
  - Average hours per month

- **Attendance Impact:**
  - Holidays affecting classes
  - Exception dates and reasons
  - Makeup sessions scheduled

- **Resource Utilization:**
  - Agent workload distribution
  - Client site utilization
  - Peak scheduling periods

---

## 5. Enhanced Non-Functional Requirements

### **Performance (Advanced)**
- **Calendar Loading:** Sub-2 second load time for any month view (up to 500 events)
- **Caching Strategy:**
  - Level 1: Generated event JSON (5-minute cache)
  - Level 2: Recurring pattern calculations (1-hour cache)
  - Level 3: Schedule statistics (15-minute cache)
- **Progressive Loading:** Load current month immediately, adjacent months on demand
- **Event Density Optimization:** Intelligent grouping for high-density periods

### **Responsiveness (Enhanced)**
- **Desktop (Primary):** Full-featured calendar with all interactive elements
- **Tablet (Secondary):** Optimized touch interface with gesture support
- **Mobile (Future):** Simplified agenda view for emergency access

### **Access Control (Granular)**
- **Administrator:** Full calendar access with editing capabilities
- **Project Supervisor:** Read-only access with filtering by assigned classes
- **Agent:** Limited view of own assigned classes (future enhancement)
- **API Security:** JWT-based authentication for calendar data endpoints

### **Maintainability (Structured)**
- **Modular Architecture:** Separate classes for calendar rendering, event generation, and data management
- **Plugin Structure:** Self-contained calendar plugin with clear interfaces
- **Documentation:** Comprehensive code documentation and user guides
- **Testing:** Unit tests for recurrence logic and integration tests for calendar display

---

## 6. Enhanced Data Flow & Architecture

```text
Class Creation/Edit Form → Complex Schedule Data → PostgreSQL Database
                                    ↓
                        Schedule Calculation Service
                                    ↓
                    ┌───────────────────────────────────┐
                    │     Event Generation Engine         │
                    │  • Recurring Pattern Processor      │
                    │  • Exception Handler               │
                    │  • Holiday Conflict Resolver       │
                    │  • Agent Assignment Tracker        │
                    │  • Statistics Calculator           │
                    └───────────────────────────────────┘
                                    ↓
                        Multi-Level Caching Layer
                                    ↓
                        REST API Endpoints
                                    ↓
    Calendar Page (/app/calendar/) → FullCalendar JavaScript → Enhanced UI
                                    ↓
                    Interactive Features (Phase 2+)
                    • Filtering & Search
                    • Export Capabilities
                    • Limited Editing
```

### **API Endpoints (Proposed)**
```
GET  /wp-json/wecoza/v1/calendar/events/{year}/{month}
GET  /wp-json/wecoza/v1/calendar/statistics/{classId}
GET  /wp-json/wecoza/v1/calendar/conflicts/{date}
POST /wp-json/wecoza/v1/calendar/export
```

---

## 7. Implementation Phases

### **Phase 1: Foundation (MVP)**
- Basic calendar display with existing class data
- Simple event rendering (sessions, exceptions, holidays)
- Read-only interaction with basic tooltips
- Essential performance optimizations

### **Phase 2: Enhanced Visualization**
- Advanced event styling and visual hierarchy
- Comprehensive tooltip system
- Schedule statistics integration
- Filtering and search capabilities

### **Phase 3: Interactive Features**
- Limited editing capabilities (reschedule, agent assignment)
- Export functionality
- Advanced conflict detection
- Week and agenda views

### **Phase 4: Advanced Management**
- Full calendar-based schedule management
- Drag-and-drop functionality
- Real-time collaboration features
- Mobile optimization

---

## 8. Risk Assessment & Mitigation

### **Technical Risks**
- **Complex Recurrence Logic:** Mitigate with comprehensive testing and fallback mechanisms
- **Performance with Large Datasets:** Implement progressive loading and intelligent caching
- **Browser Compatibility:** Use established FullCalendar library with proven compatibility

### **User Experience Risks**
- **Information Overload:** Implement progressive disclosure and intelligent defaults
- **Learning Curve:** Provide comprehensive tooltips and user guidance
- **Mobile Usability:** Phase mobile optimization to ensure desktop experience first

### **Data Integrity Risks**
- **Schedule Conflicts:** Implement robust conflict detection and resolution
- **Cache Inconsistency:** Use cache invalidation strategies and fallback to live data
- **Agent Assignment Conflicts:** Real-time validation and conflict warnings

---

## 9. Success Metrics

### **User Adoption**
- Calendar page views and engagement time
- Reduction in schedule-related support requests
- User feedback and satisfaction scores

### **Operational Efficiency**
- Reduction in schedule conflicts and double-bookings
- Faster schedule planning and resource allocation
- Improved visibility into resource utilization

### **Technical Performance**
- Page load times and user interaction responsiveness
- Cache hit rates and database query optimization
- Error rates and system stability metrics

---

*This enhanced PRD reflects the true complexity of the WeCoza class scheduling system and provides a roadmap for comprehensive calendar integration that leverages all existing form capabilities while providing a superior user experience for schedule management.*
