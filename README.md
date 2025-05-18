# DB2 Android App Project

## Authors  
Nick Matsuda, Lucca Nelson, Jack Fallon

---

## About the Project  
This project is the third phase of a larger database design and implementation effort. It provides a simplified Android application version of the previously developed web-based database system (Phase 2). The system models a simplified Student Information System (SIS) that allows students and faculty to manage academic information (e.g., checking grades, signing up for classes).

This app is a partial implementation focusing on mobile access to the database.

See the [Phase 2 project here](https://github.com/Soren64/fullstack-php-web-app) for the web-based database implementation.

---

## How to Run the Project  

### Prerequisites  
- Android Studio installed  
- Apache and MySQL server running (XAMPP recommended)  
- The Phase 3 PHP backend code placed in the `htdocs/Phase3` folder of your XAMPP installation  
- Existing database from Phase 2 (no schema changes needed)

### Setup Steps  
1. **Import the Project**  
   Download or clone the project folder (keep the file structure intact) and open it in Android Studio.  
   Let Gradle sync and configure (may take several minutes).  

2. **Configure the Backend URL**  
   Open `app/src/main/res/values/strings.xml` and update the `url` value to match your local server’s IP and the Phase3 folder path.  
   Example: http://192.168.x.x:80/Phase3/

   *(Tip: Use the `ipconfig` command on Windows or `ifconfig` on macOS/Linux to find your local IP address.)*  

3. **Start Your Server**  
Run Apache and MySQL modules in XAMPP or your preferred server environment.

4. **Launch the App**  
Run the app on an Android emulator or physical device connected to the same network as your server.

---

## Important Notes  
- The app relies on the database created in Phase 2. No new tables or data schema changes are introduced in this phase.  
- The PHP backend must be accessible at the configured URL for the app to function properly.

## License
This project was developed for educational purposes and is not licensed for production use.
