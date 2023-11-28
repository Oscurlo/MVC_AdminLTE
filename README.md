# MVC with AdminLTE 3

## Configuration and Download

### Project Download

If you are using git, you can clone this repository using the following command. Otherwise, you can simply download the project.

```sh
git clone https://github.com/Oscurlo/MVC_AdminLTE.git
```

### Dependencies

Dependencies are managed with Composer. To install the necessary dependencies, use the following command:

```sh
composer install
```

### Configuration

Rename the file ".env.dist" to ".env".

Asignar variables requeridas

```env
BASE_FOLDER=C:/pathFile,
BASE_SERVER=https://domain.com,
DB_HOST=domain,
DB_USERNAME=user,
DB_PASSWORD=pass,
DB_DATABASE=dbname,
DB_MANAGER=[MYSQL or SQLSRV or SQLITE]
```

## Project Structure

The project is based on the Model-View-Controller software architecture.

```sh
app
├── Controllers/
├── Models/
└── Views/
```

It includes logic for independent views for clients or administrators.

For security purposes, each independent view has a template to load the corresponding view and a separate folder for each.

- Templates

```sh
template
├── AdminMode.php
└── ClientMode.php
```

- Views

```sh
app
└── Views
    ├── AdminMode/
    └── ClientMode/
```
