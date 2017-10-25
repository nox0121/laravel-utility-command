# Laravel Utility Command

這個套件集合了許多有用的 Artisan 命令，主要用來協助系統管理與設定。

目前包含了以下套件：

* [Mysql Command](https://github.com/nox0121/mysql-command)

### 安裝方式

`composer require nox0121/laravel-utility-command`

### 設定 app.confg

	'providers' => [
	    ...
	    Nox0121\MysqlCommand\MysqlCommandServiceProvider::class,
		Nox0121\LaravelUtilityCommand\LaravelUtilityCommandServiceProvider::class,
	    ...
	];

### 支援指令如下：

1. `php artisan server:initial` - 初始化資料庫且執行 migration 和 ReleaseSeeder。
2. `php artisan server:optimize` - 優化系統設定。 (包含 route/api/config cache)
3. `php artisan server:no-optimize` - 移除優化系統設定。 (包含 route/api/config cache)
4. `php artisan mysql:create-database` - 根據 .env 設定，建立資料庫。
5. `php artisan mysql:dump-database` - 根據 .env 的資料庫及 `APP_STORAGE_PATH` 設定，傾倒資料庫。
6. `php artisan mysql:mysql:restore-database` - 根據 .env 的資料庫及 `APP_STORAGE_PATH` 設定，還原資料庫。
