# Prison Management System

A comprehensive Laravel-based prison management system designed to handle all aspects of correctional facility operations, from inmate management to staff coordination and security oversight.

## 🏛️ System Overview

This Prison Management System provides a complete digital solution for managing correctional facilities with hierarchical structure support and department-based operations. The system follows modern prison management principles with support for decentralized unit management.

## ✨ Features

### Core Departments

#### 🛡️ Security Department
- **Security Incident Management**: Track and resolve security incidents with severity levels
- **Staff Coordination**: Manage security personnel and their assignments
- **Intelligence Operations**: Monitor and report on facility security status
- **Incident Resolution Workflow**: Structured process for incident investigation and closure

#### 👥 Inmate Management Department
- **Inmate Registration**: Complete intake process with classification system
- **Record Keeping**: Comprehensive inmate profiles with criminal history
- **Release Planning**: Track upcoming releases and manage discharge processes
- **Security Level Classification**: Minimum, Medium, Maximum, and Supermax classifications
- **Cell and Block Management**: Assign and track inmate housing locations

#### 🏥 Medical Services Department
- **Medical Records**: Complete healthcare documentation for inmates
- **Treatment Tracking**: Monitor ongoing medical treatments and medications
- **Follow-up Management**: Schedule and track required medical follow-ups
- **Emergency Response**: Quick access to critical medical information
- **Health Screening**: Comprehensive medical assessments

#### 🏢 Administration Department
- **Financial Management**: Department budgets and expense tracking
- **Human Resources**: Staff management and organizational structure
- **Operational Oversight**: Monitor facility-wide operations and statistics
- **Report Generation**: Comprehensive reporting across all departments

### Specialized Departments

#### 🎓 Rehabilitation Programs
- **Program Management**: Create and manage various rehabilitation programs
- **Inmate Enrollment**: Track inmate participation and progress
- **Program Types**: Substance abuse treatment, education, vocational training, anger management
- **Progress Tracking**: Monitor completion rates and outcomes
- **Certification Management**: Issue certificates for completed programs

#### 👨‍👩‍👧‍👦 Visitation Management
- **Visit Scheduling**: Manage family and legal visits
- **Visitor Screening**: Background checks and approval workflow
- **Visit Tracking**: Monitor visit history and patterns
- **Multiple Visit Types**: Family, legal, official, and religious visits
- **Approval Process**: Staff-based visit authorization system

#### 🍽️ Food Services
- **Menu Planning**: Plan and track daily meals
- **Dietary Management**: Handle special dietary requirements and allergies
- **Cost Tracking**: Monitor food service expenses
- **Nutritional Information**: Maintain meal nutritional data
- **Service Status**: Track meal preparation and distribution

#### 🔧 Maintenance Department
- **Work Order Management**: Track facility maintenance requests
- **Priority System**: Categorize requests by urgency level
- **Cost Estimation**: Budget and track maintenance expenses
- **Completion Tracking**: Monitor work order status and completion

#### ⛪ Chaplaincy Services
- **Religious Services**: Schedule and manage religious activities
- **Multi-Faith Support**: Christianity, Islam, Judaism, Buddhism, Hinduism, and others
- **Attendance Tracking**: Monitor inmate participation in religious programs
- **Spiritual Counseling**: One-on-one spiritual support services

## 🏗️ System Architecture

### Database Structure
- **Hierarchical Design**: Department-based organization with staff assignments
- **Relationship Mapping**: Complex relationships between inmates, staff, and services
- **Security Levels**: Comprehensive security classification system
- **Audit Trail**: Track all significant system changes and activities

### User Interface
- **Modern Bootstrap Design**: Responsive and professional interface
- **Department-Specific Dashboards**: Tailored views for each department
- **Real-time Statistics**: Live updates on facility status and metrics
- **Intuitive Navigation**: Easy access to all system functions

## 🚀 Installation & Setup

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL 5.7+ or SQLite
- Node.js and NPM (for frontend assets)

### Installation Steps

1. **Clone the Repository**
   ```bash
   git clone [repository-url]
   cd prison-management-system
   ```

2. **Install Dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Database Setup**
   ```bash
   # Configure your database in .env file
   php artisan migrate
   php artisan db:seed
   ```

5. **Start the Application**
   ```bash
   php artisan serve
   ```

## 📊 Dashboard Features

### Main Dashboard
- **System Overview**: Total inmates, staff, and department statistics
- **Security Metrics**: Open incidents, critical alerts, and recent activity
- **Medical Alerts**: Follow-ups required and recent medical visits
- **Quick Actions**: Rapid access to common tasks
- **Department Distribution**: Staff allocation and budget overview

### Specialized Dashboards
- **Security Dashboard**: Incident tracking and security metrics
- **Medical Dashboard**: Healthcare statistics and follow-up management
- **Inmate Management Dashboard**: Population statistics and release planning

## 🔐 Security Features

- **Role-Based Access**: Different access levels for various staff positions
- **Audit Logging**: Track all system activities and changes
- **Data Protection**: Secure handling of sensitive inmate and staff information
- **Security Clearance Levels**: Low, Medium, High, and Maximum clearance requirements

## 📋 Department Management

### Core Departments Setup
The system comes pre-configured with essential departments:
- Security Department ($2.5M budget)
- Inmate Management Department ($1.8M budget)
- Medical Services Department ($3.2M budget)
- Administration Department ($1.5M budget)

### Specialized Services
- Rehabilitation Programs Department ($950K budget)
- Food Services Department ($800K budget)
- Maintenance Department ($650K budget)
- Laundry Services Department ($200K budget)
- Chaplaincy Department ($150K budget)

## 🎯 Key Workflows

### Inmate Intake Process
1. **Registration**: Complete inmate information entry
2. **Classification**: Assign appropriate security level
3. **Housing Assignment**: Allocate cell and block placement
4. **Medical Screening**: Initial health assessment
5. **Program Eligibility**: Evaluate for rehabilitation programs

### Security Incident Management
1. **Incident Reporting**: Staff report security events
2. **Investigation**: Assign investigation team
3. **Resolution**: Document actions taken
4. **Follow-up**: Monitor ongoing implications
5. **Closure**: Complete incident documentation

### Visit Management Process
1. **Visit Request**: Visitor submits visit application
2. **Background Check**: Verify visitor eligibility
3. **Approval**: Staff approve or deny request
4. **Scheduling**: Assign visit time and location
5. **Monitoring**: Track visit completion

## 📈 Reporting Capabilities

- **Population Reports**: Inmate statistics by security level, block, and demographics
- **Incident Analysis**: Security incident trends and patterns
- **Medical Reports**: Health service utilization and follow-up tracking
- **Program Effectiveness**: Rehabilitation program completion rates
- **Staff Reports**: Department performance and resource allocation

## 🛠️ Configuration

### Environment Variables
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=prison_management
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### System Settings
- Default pagination: 15 items per page
- Security incident retention: Indefinite
- Visit approval timeframe: 48 hours
- Medical follow-up alerts: 30 days

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch
3. Commit your changes
4. Push to the branch
5. Create a Pull Request

## 📄 License

This Prison Management System is proprietary software designed for correctional facility use. Please contact the development team for licensing information.

## 🆘 Support

For technical support, system configuration, or feature requests, please contact the development team or create an issue in the repository.

## 🔄 System Updates

Regular updates include:
- Security patches
- Feature enhancements
- Performance optimizations
- Compliance updates

---

**Prison Management System** - Comprehensive correctional facility management solution built with Laravel framework.
