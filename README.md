# CI4 CMS
CI4 CMS is a semi-content management system created using CodeIgniter 4 Framework, it is useful for manage the content of small websites that have Home, About Us, Service, Projects, Contact Us, etc.. pages.

### Installation 

https://www.youtube.com/playlist?list=PL4hKweKn2p-g9UV_qlCR3IDmrLF35s9tM

## Specification

PHP 7.2 or above

## Configure .env File

### CMS Environment

CI_ENVIRONMENT = 'development'  // or production

### CMS Settings

cms.site.title='CI4 CMS'<br/>
cms.admin.email=''<br/>
cms.default.lang='en'<br/>
cms.config.form_management=true<br/>
cms.smtp.enable=false<br/>
cms.smtp.email=''<br/>
cms.smtp.password=''<br/>
cms.smtp.port=''<br/>
cms.smtp.encrypt='ssl'<br/>

### Database Setup

database.default.hostname = 'localhost'<br/>
database.default.database = 'ci4_cms'<br/>
database.default.username = 'root'<br/>
database.default.password = ''<br/>

## CMS Migration & Seed

Don't forget to set Config\Migrations:enabled to true.<br/>

$ php spark migrate<br/> 
$ php spark db:seed FormFieldTypes<br/>
$ php spark db:seed FormFields<br/>
$ php spark db:seed FormPages<br/>
$ php spark db:seed ContentFileTypes<br/>
$ php spark db:seed ContentFileGroups<br/>
$ php spark db:seed Languages<br/>
$ php spark db:seed Settings<br/>

### IonAuth Migration & Seed

$ php spark migrate -n IonAuth<br/>
$ php spark db:seed IonAuth\Database\Seeds\IonAuthSeeder<br/>


## Run Project 

$ php spark serve<br/>

URL:<br/>
http://localhost:8080<br/>
http://localhost:8080/admin<br/>

email: admin@admin.com<br/>
password: password<br/>


## Hosting Project 

1. Move all files and folder from public folder to root<br/>
2. In index.php change directory path:<br/>
$pathsPath = realpath(FCPATH . '../app/Config/Paths.php');<br/>
$pathsPath = realpath(FCPATH . '/app/Config/Paths.php');<br/>
3. In spark file change directory path<br/>
define('FCPATH', __DIR__ . '/public' . DIRECTORY_SEPARATOR);<br/>
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);<br/>
4. Remove public folder make sure everything inside is moved to root<br/>
5. .env file uncomment app.baseURL and add project hosted URL<br/>
eg: app.baseURL=http://localhost:8080<br/>
