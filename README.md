# lab

## Running `userdata.php`

This repository includes a simple PHP script (`userdata.php`) that
connects to a SQL Server instance using the `sqlsrv` extension.
Set the following environment variables before running the script:

```
export SQLSRV_SERVER="your_server"       # e.g. tcp:localhost,1433
export SQLSRV_DATABASE="ICCLdb"
export SQLSRV_USER="iccldbuser"
export SQLSRV_PASSWORD="your_password"
```

After configuring these variables, run the script with PHP:

```
php userdata.php
```

If the connection fails, check the server name, network accessibility and
credentials. Connection errors are logged via `error_log` for easier
troubleshooting.

## Running `pumpdata.php`

The repository also provides `pumpdata.php`, which queries the `Pumpdata` table using the same connection parameters. Use the same environment variables as above and run:

```
php pumpdata.php
```
