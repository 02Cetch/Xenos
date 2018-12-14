<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://pp.userapi.com/c830509/v830509539/1da3e4/R16VKw73izM.jpg" height="60px">
    </a>
    <h1 align="center">Xenos: The Job Searching Site</h1>
    <br>
</p>

<h2>Frontend:</h2>

<p>The frontend part of the site has multiple functionality.</p>
<p>You can view company vacancies or user resumes.</p>
<p>Notification system that will show account activity.</p>
<p>There is also a complaint system implemented with redis.</p>
<p>Especially for companies there is a contact button, which will send the user a notification that the company liked his resume. Also uses redis.</p>
<h3>User Account:</h3>
<h4>Account Types:</h4>
<p>
User account has 2 types - a job seeker and company.

The user and the company have a number of functional differences:
<ul>
    <li>The company can create vacancies, users - resumes</li>
    <li>Companies can contact the user through the "Contact" button in their resume.</li>
    <li>Users and companies have different fields that they can edit in their account</li>
</ul>

</p>

<h2>Backend:</h2>

<p>The backend part of the site is created as an admin panel with an RBAC access system.</p>
<p>
From the moment all migrations are installed, a user with admin rights is created, which has access to the admin.
The login information for this user is located in the migration file: "m181210_150335_create_rbac_data"
</p>
<p>In the admin panel there is access to user complaints, where it can approve it or remove</p>
<p>The admin user can give the role to another user</p>
    
<h3>Console:</h3>
<p>The console has only one controller, which removes all notifications older than 30 days.</p>



DIRECTORY STRUCTURE
-------------------

```
common
    config/              contains shared configurations
    mail/                contains view files for e-mails
    models/              contains model classes used in both backend and frontend
    tests/               contains tests for common classes    
console
    config/              contains console configurations
    controllers/         contains console controllers (commands)
    migrations/          contains database migrations
    models/              contains console-specific model classes
    runtime/             contains files generated during runtime
backend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains backend configurations
    controllers/         contains Web controller classes
    models/              contains backend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for backend application    
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
frontend
    assets/              contains application assets such as JavaScript and CSS
    config/              contains frontend configurations
    controllers/         contains Web controller classes
    models/              contains frontend-specific model classes
    runtime/             contains files generated during runtime
    tests/               contains tests for frontend application
    views/               contains view files for the Web application
    web/                 contains the entry script and Web resources
    widgets/             contains frontend widgets
vendor/                  contains dependent 3rd-party packages
environments/            contains environment-based overrides
```
