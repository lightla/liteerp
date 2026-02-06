# HRM Extension for LiteERP

A comprehensive Human Resource Management extension with integrated email notifications.

## Features

### ✅ Leave Management
- Submit leave requests (vacation, sick leave, etc.)
- Approval workflow with email notifications
- Leave request status tracking

### ✅ Time Attendance
- Daily check-in/check-out tracking
- Automatic working hours calculation
- End-of-day reports
- Monthly attendance summaries with CSV export

### ✅ Employment Contracts
- Upload and store contract documents
- Secure contract download
- Contract management per user

## Email Integration

The extension automatically integrates with SMTP settings configured in LiteERP:

- **Runtime SMTP Configuration**: Notifications automatically detect and use configured SMTP settings
- **Fallback Handling**: Gracefully handles cases where SMTP is not configured
- **No External Dependencies**: Works independently while leveraging existing SMTP configuration

## Installation

1. **Install HRM extension:**
   ```bash
   # Copy HRM extension to extensions directory
   cp -r hrm /path/to/liteerp/app/extensions/

   # Install HRM extension
   php artisan extension:install hrm
   ```

2. **Run migrations:**
   ```bash
   php artisan migrate
   ```

3. **Configure SMTP (optional but recommended):**
   - Install and configure the SMTP extension if email notifications are needed
   - The HRM extension will automatically use SMTP settings if available

## API Endpoints

### Leave Requests
- `POST /api/hrm/leave-requests` - Create leave request
- `GET /api/hrm/leave-requests` - List user's leave requests
- `POST /api/hrm/leave-requests/{id}/approve` - Approve leave request
- `POST /api/hrm/leave-requests/{id}/reject` - Reject leave request

### Time Attendance
- `POST /api/hrm/attendance` - Record attendance
- `POST /api/hrm/attendance/end-of-day` - Create end-of-day report
- `GET /api/hrm/attendance/monthly/{userId}/{month}/{year}` - Get monthly summary
- `GET /api/hrm/attendance/export/{userId}/{month}/{year}` - Export monthly report (CSV)

### Employment Contracts
- `POST /api/hrm/contracts` - Upload contract
- `GET /api/hrm/contracts` - List contracts
- `GET /api/hrm/contracts/{id}/download` - Download contract

## Email Notifications

The extension automatically sends email notifications when SMTP is configured:

- **Leave Request Submitted**: Sent to approver when a new request is created
- **Leave Request Approved**: Sent to employee when request is approved
- **Leave Request Rejected**: Sent to employee when request is rejected

## Security

- Policy-based authorization
- Input validation
- User-specific data access
- Secure file storage for contracts

## Frontend Integration

The extension includes React components that are automatically loaded:

- `LeaveRequestForm` - Submit leave requests
- `TimeAttendanceForm` - Record daily attendance
- `MonthlyAttendanceSummary` - View attendance reports
- `LeaveApprovalList` - Approve pending requests
- `ContractList` - Manage contracts

The main HRM interface is rendered in an element with id `extension-hrm`.

## Database Tables

- `leave_requests` - Leave request data
- `time_attendances` - Daily attendance records
- `end_of_day_reports` - End-of-day summaries
- `employment_contracts` - Contract file information

## Configuration

No additional configuration required. The extension uses Laravel's built-in features and follows LiteERP conventions.