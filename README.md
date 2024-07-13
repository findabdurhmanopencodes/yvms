# Youth Volunteer Management System (YVMS) <a href="http://yvms.mop.gov.et/developers">Goto Website</a>

Youth Volunteer Management System (YVMS) is a web-based application developed by Jimma University's ICT Development Office in collaboration with the Ministry of Peace, National Volunteerism Program. The system automates the entire process of the national volunteerism program from online application to deployment and community engagement.

## Features

- **Online Application:** Allows youth volunteers to apply online.
- **Application Review:** Facilitates review and approval of volunteer applications.
- **Deployment Management:** Manages the deployment of volunteers to various community projects.
- **Community Engagement:** Tracks and manages volunteer activities and engagement with communities.
- **Reporting:** Provides reports and analytics on volunteer activities and impact.

## Screenshots

![Screenshot 1](https://github.com/findabdurhmanopencodes/yvms/blob/master/screenshot/01.png)
![Screenshot 2](https://github.com/findabdurhmanopencodes/yvms/blob/master/screenshot/02.png)
![Screenshot 3](https://github.com/findabdurhmanopencodes/yvms/blob/master/screenshot/03.png)
![Screenshot 4](https://github.com/findabdurhmanopencodes/yvms/blob/master/screenshot/04.png)
![Screenshot 5](https://github.com/findabdurhmanopencodes/yvms/blob/master/screenshot/05.png)

## Technologies Used

- **Frontend:** HTML, CSS, JavaScript
- **Backend:** PHP, Laravel
- **Database:** MySQL
- **Deployment:** Docker, AWS

## Installation

To run this project locally, follow these steps:

1. Clone the repository:
   ```bash
   git clone https://github.com/your_username/yvms.git
   cd yvms
   ```
2. Install dependencies:
   ```bash
   composer install
   npm install
   ```
3. Set up environment variables:
   - Copy `.env.example` to `.env` and configure database settings.
   - Generate application key:
     ```bash
     php artisan key:generate
     ```
4. Run migrations and seed data:
   ```bash
   php artisan migrate --seed
   ```
5. Start the development server:
   ```bash
   php artisan serve
   ```
6. Access the application in your web browser at `http://localhost:8000`.

## Usage

- Register as a new user or login with existing credentials.
- Explore different modules such as application submission, volunteer management, and reporting.

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License

[MIT](https://choosealicense.com/licenses/mit/)
