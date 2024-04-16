Authors:
Nick Matsuda
Lucca Nelson
Jack Fallon



About the Project:

This code is the 3rd part of a larger project in designing and implementiting a database.

The code provided is for a simple application that serves as a modified implmentation of a web-based database (phase 2),
which follows a simplified version of the actual SIS system; used as a way for students and faculty to manage their academics. 
(Ex. Check grades, sign up for classes, etc.)

The application is a partial implementation of web-based design.



How to run the project:

This project uses the Android Studio software to emulate the application on an actual android mobile device. 
By downloading the entire code (keeping the same file structure) and importing the project to AndroidStudio, 
the project can built and run. The project will need some time to initially configure the gradle (which can take several minutes).

Since the project relies on queries on a database in order for the application to work properly, you will need to make sure you have an Apache server 
set up that contains the necessary queries. The server can be ran and configured using XAMPP. You will absolutely need to modify the url in the "strings.xml" 
file to match the corresponding internal IP of your server in order to properly connect to your database. It will also need to contain the pathway to the respective php code,
which should be located in your "htdocs" folder for XAMPP.

Example: "http://123.45.67.8:X/pathway/to/phpcode/"

(Tip: Run the 'ipconfig' command in your local terminal to find the IP)

The application will not work correctly if the connection is not configured properly.



Note: 
The database implemented in phase 2 of the project has NOT been modified for phase 3 (this phase). The project runs using the same existing database structure/data (php code NOT included currently).
