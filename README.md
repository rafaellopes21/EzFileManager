# EzFileManager
EzFileManager - Easy and Simple Filemanager UI

--------
EzFileManager is a free, nonprofit OpenSource PHP Project designed to simplify files and directories manipulations and storages. With a focus on ease of use, it provides efficient tools for common tasks like creating, renaming, moving, copying, deleting, uploading, downloading and manipulating files and folders.

## Requirements
The project is really simple, but needs some tools to work, see the table below:

| Tool     | Version        | Requirement |
|----------|----------------|-------------|
| PHP      | 7.3 or Higher  | Required    |
| COMPOSER | 2.0 or Higher  | Required    |
| APACHE   | 2.2 or Higher  | Required    |
| SQLITE   | 3.28 or Higher | Optional    |

## Clone/Download
In your terminal, copy and paste the following command where your php server installed:
```sh
git clone https://github.com/rafaellopes21/EzFileManager.git
```

## Run Project
Once you cloned the project, you can just run the command below where the project is located:

- This command will install all dependencies (if necessary) and will start the server.
```sh
composer start
```

## (Optional Method) Run Project
If you prefer, you can run the project in the classic way:
1. Install composer dependencies
```sh
composer install
```
2. Run the server
```sh
php -S 127.0.0.1:8001 -t public
```
*Recommended to start the project with "composer start", because is more simple*

## (Optional) Enable Database and Users
If you want to use *EzFileManager* with all resources and database, you will need to enable the following extension below in your *php.ini* file:
```
- pdo_sqlite
```

## (Optional) Increase upload size
If you need to work with handling files that will be large in size, make sure to change the following parameters in your *php.ini* file:
```
- memory_limit
- upload_max_filesize
- post_max_size
```


## Donate
If you find this project helpful and valuable, please consider supporting me. Your contribution help me to maintain and improve this OpenSource Project for everyone use with no cost. Every little bit helps!

[Donate Here](https://nubank.com.br/pagar/5th42/1efRKgR2V8)

Thank you for your generosity and support! 🙏
____
This README provides an overview of the EzFileManager Project, its features, and how to use it. Adjustments can be made as needed to meet your specific needs.