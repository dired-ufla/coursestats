# Courses Usage Statistics
In our institution (Federal University of Lavras, Lavras, Brazil - in portuguese, [Universidade Federal de Lavras - UFLA](http://www.ufla.br/portal/), we have an expressive amount of courses in progress (~ 1.7k in just one Moodle instance, called "Campus Virtual"). The sector that coordinates the activities related to the "Campus Virtual" administration is called "[Diretoria de Educação à Distância (DIRED)](http://www.dired.ufla.br/portal/)". A question we have made to ourselves is: "how are all these courses being used by the professors?". 

In our preliminary research, we have found three main types of usage:

- The course is simply used as a communication channel by means of the announcement **forum** (forum usage is not recorded unless it's a discussion created in the news forum);

- The course is used as either a **repository** of files or a repository of URLs to external resources; and

- The course is effectively used by means of several types of **activities**, such as Quiz, Chat, Lesson, Wiki, among others.

We believe that the knowledge about the courses usage types is important because this may improve the strategies of training and information dissimination about the resources available in Moodle. However, gathering the statistics of courses usage is not a trivial task, mainly when this is performed in a manual way; the last time we did that, it tooks us 16 hours of our precious time ;).

Hence, we developed "Courses Usage Statistics"; this is a Moodle report plugin that helps the admin to known how the courses are being used by users (e.g. as forum, as file repositories or as activities repositories). Feel free to use and contribute to this project by improving the plugin functionality or letting us to know about possible bugs existing in its code. You can see some screenshots at https://moodle.org/plugins/report_coursestats.

**Important**: this plugin only records information after it's been installed.

## Releases

- v2.8: in this version, users may see a list of created, used or non-used courses.
- v2.7.6: in this version, the course module updates are taken into account.
- v2.7.5: in this version, the plugin does not consider hidden courses anymore.
- v2.7: this version fixes some security issues as well as includes new features, such as "category statistics" and "export to CSV" functionality  
- v2.6.1: this version fixes an error regarding the amount of courses
- v2.6: this version improves the layout of the plugin main page
- v2.5: this version presents information about created courses in a graphical way (using pie charts). 
- v2.4: this version improves the plugin main page by including information about created courses instead of only used courses. 
- v2.3: this version fixes a pagination issue. 
- v2.2: this version upgrades the front-end of the main page and the translation file. 
- v2.1: this version fixes an issue related to plugin upgrade. 
- v2.0: this version allows the user filtering data based on course categories. 
- v1.3: this version fixes an issue related to division by zero error and improves the documentation about the plugin. 
- v1.2: this version fixes an issue related to number format. 
- v1.1: this version includes filters to usage types, such as, forum, repository and activities. 
- v1.0: this is the first version of the plugin.
