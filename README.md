 <h1 align='center'>Admin panel</h1>

<h3>Index</h3>

- **[Installation](#Installation)**
- **[User Crendential](#UserCrendential)**
- **[Site Setting](#SiteSetting)**
- **[Email Configuration](#EmailConfiguration)**
- **[Module](#Module)**
- **[Menu](#Menu)**
- **[Role](#Role)**
- **[Menu Permission](#MenuPermission)**

 <h3 id="Installation">Installation</h3>

Clone git repository to local storage
```
git clone https://gitlab.com/nanoit.biz/admin_panel.git
```
Create .env file & need .env file updated
```
cp .env.example .env
```
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=admin_panel
DB_USERNAME=root
DB_PASSWORD=
```
Key to generate in .env
```
php artisan key:generate
```
Migrate database and get all dependency tables with data
```
php artisan migrate
```
To run test project at [localhost:8000](http://localhost:8000)
```
php artisan serve
```
<h3 id="UserCrendential">User Crendential</h3>

```
email - dev@nanoit.biz
password - dev@nano
```

<h3 id="SiteSetting">Site Setting</h3>

![Site Setting](public/markdown/site_setting.png)

<h3 id="EmailConfiguration">Email Configuration</h3>

![Email Configuration](public/markdown/email_config.png)

<h3 id="Module">Module</h3>

![Module](public/markdown/module.png)

<h3 id="Menu">Menu</h3>

![MenuList](public/markdown/menu_list.png)

![MenuAdd](public/markdown/menu_add.png)

<h3 id="RoleAdd">Role</h3>

![RoleAdd](public/markdown/role_add.png)

<h3 id="MenuPermission">Menu Permission</h3>

#### grid line

![MenuPermission](public/markdown/menu_permission.png)

#### Inline

![MenuPermissionInline](public/markdown/menu_permission_inline.png)
