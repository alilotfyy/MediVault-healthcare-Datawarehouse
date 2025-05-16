# MediVault Healthcare Data Warehouse

## Overview

MediVault Healthcare Data Warehouse is a comprehensive digital platform designed to centralize healthcare data, streamline patient-doctor interactions, and facilitate medical record management. The system serves as a user-friendly interface for managing appointments, medical histories, prescriptions, analytics, and secure communication between patients and doctors.

---

## Features

- **User Authentication**: Separate roles for patients and doctors with secure login.
- **Patient Management**: Patients can update personal info, medical history, insurance details, and book appointments.
- **Doctor Dashboard**: Doctors can manage appointments, write reports, upload lab and imaging results, and communicate securely with patients.
- **Medical Records**: Access and update electronic health records (EHR), including lab tests, imaging, vaccination records, and medication history.
- **Health Tracking & Analytics**: Visualize vitals such as blood pressure and glucose levels with interactive charts.
- **Communication System**: Secure text-based chat between patients and doctors.
- **Insurance & Billing**: Manage insurance information and billing history.
- **Complex Query Support**: Run advanced SQL queries like top patients by appointment count or analyze medical metrics.

---

## Tech Stack

- **Frontend**: HTML5, CSS3, JavaScript, Chart.js
- **Backend**: PHP (running on XAMPP)
- **Database**: MySQL
- **Tools**: phpMyAdmin, VS Code

---

## Database Design

The system uses a relational database with the following core tables:

- `users` (doctors and patients)
- `patients_info`
- `insurance_info`
- `appointments`
- `medical_history`
- `medical_reports`
- `medications`
- `analytics`
- `messages`

Refer to the project documentation for detailed ER and EER diagrams.

---

## Installation and Setup

1. Clone the repository to your local machine.
2. Install [XAMPP](https://www.apachefriends.org/index.html) and start Apache and MySQL services.
3. Import the provided `mediVault.sql` database dump via phpMyAdmin.
4. Place the project files inside the `htdocs` folder (e.g., `C:/xampp/htdocs/mediVault`).
5. Update `db.php` with your database credentials if necessary.
6. Access the project via browser at `http://localhost/mediVault`.

---

## Usage

- Register as a patient or doctor.
- Patients can update profiles, book appointments, and view medical records.
- Doctors can manage appointments, create reports, upload lab results, and chat with patients.
- Use the dashboards to navigate the system functionalities.

---

## Future Enhancements

- Real-time video consultations.
- AI-powered health insights and diagnostics.
- Integration with wearable devices for automatic health tracking.
- Full-fledged billing and insurance claim management.
- Mobile applications for Android and iOS.

---

## Contributing

Contributions are welcome! Please fork the repository and create pull requests for any improvements or bug fixes.

---

## License

This project is licensed under the MIT License.

---

## Contact

For questions or support, contact the project maintainer at [your.email@example.com].
