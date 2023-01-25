## About studyspot 📚

studySpot is a student/university oriented social media website created by students! The goal of studySpot is to offer students a way to connect with their fellow classmates without the clutter of other social media sites. Think of a subreddit or a Discord community but intended purely for university students and focuses on using sticky notes.

Check it out [here](http://studyspot.herokuapp.com/). 
> Please have cookies enabled! 

## This project is still currently under development 🚧

These are the features I wish to add:

- Sorting the posts by likes, dislikes, and date
- Add a comments container next to enlarged post
- Add tags in enlarged post
- Admins/Moderators Roles
- Profile Page
	- Forgot Password, 2FA, Security questions
	- Add/Change Name
	- Add Profile Picture
- Leave/Join Communities (Ajax) 
- Edit/Remove Posts/Communities
- Notifications
- Login/Signup error messages (Ajax)
- Recommend other communities
- Make the site more responsive

## Usage 🧑‍💻

### Database Setup
This app uses MySQL. To use something different, open up config/Database.php and change the default driver.

To use MySQL, make sure you install it, setup a database and then add your db credentials(database, username and password) to the .env.example file and rename it to .env

### Migrations
To create all the nessesary tables and columns, run the following
```
php artisan migrate
```

### Seeding The Database
To add the dummy communities, posts with five users, run the following
```
php artisan db:seed
```

### File Uploading
When uploading files, they go to "storage/app/public". Create a symlink with the following command to make them publicly accessible.
```
php artisan storage:link
```

### Running The App
Upload the files to your document root, Valet folder or run 
```
php artisan serve
```

## Special Thanks ❤️
- Brad Traversy for his awesome Laravel course on [YouTube](https://www.youtube.com/watch?v=MYyJ4PuL4pY).
- Envato Tuts+ for their cool sticky note [design](https://codepen.io/tutsplus/pen/qBqWrqx).
- [Prosymbols](https://www.flaticon.com/authors/prosymbols) for the icons
