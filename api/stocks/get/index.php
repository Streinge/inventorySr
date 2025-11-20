index.php:
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../../autoload.php';

$bootstrap = new \src\Bootstrap();
$bootstrap->handle();

Bootstrap.php:

<?php

namespace src;

use src\config\ConfigLoader;
use src\config\ConfigException;

use src\Exceptions\HttpException;
use src\FileLogger;
use src\SrApi;

final class Bootstrap
{
    public static function handle(): void
    {
        try {
            $config = (new ConfigLoader())->loadFromPhpFile();
        } catch (ConfigException $e) {
            FileLogger($e->getMessage(), true);
            http_response_code($e->getHttpCode());
            exit();
        }

    }
}

ConfigLoader.php:

<?php

namespace src\config;

use src\Path;
use src\config\ConfigException;
use src\config\Config;

class ConfigLoader
{
    const CONFIG_FILE_NAME = "config.php";
  
    /**
     * Загружает и возвращает данные конфигурации из файла
     *
     * @return array
     * @throws ConfigException
     */

    public function loadsFromPhpFile(?string $configFilePath = null): Config
    {

        if (!$configFilePath) {
            $basePath = Path::getProjectRootPath();
            $configFilePath = rtrim($basePath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . self::CONFIG_FILE_NAME;
        }

        if (!file_exists($configFilePath)) {
            throw new ConfigException("Config file don't exists for path: " . $configFilePath, 500);
        }

        $configData = include $configFilePath;

        if (!is_array($configData)) {
            throw new ConfigException("Config data must be array", 500);
        }

        if (empty($configData)) {
            throw new ConfigException("Config data don't defined", 500);
        }

        return new Config($configData);
    }
  
}

Config.php

<?php

namespace src\config;

use src\config\ConfigException;

class Config
{

    private string $companyId;
    private string $companyToken;
    private string $generalPassword;


    public function __construct(array $configData = [])
    {
        if (empty($configData)) {
            throw new ConfigException("Config Data Array is Empty", 500);
        }

        $this->companyId = $configData['companyId'] ?? '';
        $this->companyToken = $configData['companyToken'] ?? '';
        $this->generalPassword = $configData['generalPassword'] ?? '';

        if (empty($this->companyId) || empty($this->companyToken) || empty($this->generalPassword)) {
            throw new ConfigException("Invalid config data", 500);
        }
        
    }

    public function getCompanyId(): string
    {
        return $this->companyId;
    }
    public function getCompanyToken(): string
    {
        return $this->companyToken;
    }
  
}


Ты продакт разработчик PHP c 10 летним опытом, проверь мой код выше на соответствие всем нормам и стандартам принятым для промышленной разработки на PHP, и объясни почему что то хорошо или плохо, но коротко одним абазцем. Но сообщи только три самых важных ошибки.
