# Marketing Expenses Admin Panel

A Laravel application with Filament admin panel for managing marketing expenses and generating analytics reports. This admin-only application provides comprehensive expense tracking by traffic source with interactive charts and detailed reporting.

## Current Application State

This is a **admin panel application**. The application automatically redirects all traffic from the root URL (`/`) to the admin panel (`/admin`).

### What's Included ✅

- **Complete Marketing Expense Management**
  - Add, edit, delete expense records
  - Track expenses by traffic source and date
  - Bulk operations and advanced filtering

- **Traffic Source Management**
  - Manage advertising platforms (Google Ads, Meta, TikTok, etc.)
  - Color-coded sources for visual identification
  - Enable/disable sources as needed

- **Advanced Reporting & Analytics**
  - Interactive pie charts with hover tooltips
  - Date range filtering with inclusive end dates
  - Real-time percentage calculations
  - Detailed expense breakdowns
  - Export capabilities

- **Admin Panel Features**
  - Secure Filament-based authentication
  - Responsive design for desktop and mobile
  - Dark/light theme support
  - User management and permissions

## Technology Stack

- **Framework**: Laravel 12.x with PHP 8.2+
- **Admin Interface**: Filament 3.x
- **Database**: SQLite (development) / MySQL (production)
- **Charts**: Chart.js with responsive design
- **Styling**: Tailwind CSS (minimal custom styles)
- **Architecture**: Single-purpose admin application

## Quick Start

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & NPM (for asset compilation)

### Installation

1. **Clone and setup**:

   ```bash
   git clone https://github.com/AzamkhonKh/eroi_demo.git
   cd eroi_demo
   composer install
   ```

2. **Environment configuration**:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

3. **Asset compilation**:

   ```bash
   npm install && npm run build
   ```

4. **Start development server**:

   ```bash
   php artisan serve
   ```

5. **Access the application**:
   - Visit <http://localhost:8000> (redirects to admin)
   - Direct admin access: <http://localhost:8000/admin>

## Default Admin Credentials

- **Email**: <admin@admin.com>
- **Password**: password

## Key Features

### 📊 Interactive Reports

- **Date Range Selection**: Pick any start and end date
- **Pie Chart Visualization**: See expense distribution by traffic source
- **Percentage Calculations**: Automatic percentage breakdown
- **Hover Details**: Tooltips showing amounts and percentages
- **Responsive Design**: Works on desktop and mobile

### 💰 Expense Management

- **Quick Entry**: Fast expense recording with validation
- **Bulk Operations**: Select multiple records for batch actions
- **Advanced Filtering**: Filter by date, source, amount ranges
- **Search Functionality**: Global search across all fields

### 🎯 Traffic Source Management

- **Platform Setup**: Configure advertising platforms
- **Color Coding**: Visual identification in charts
- **Status Management**: Enable/disable sources
- **Usage Tracking**: See which sources are most used
