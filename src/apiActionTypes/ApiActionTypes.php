<?php

namespace src\ApiActionTypes;

use src\Path;

class ApiActionTypes
{
    const GET_STOCKS_ACTION = 'getStocksAction';
    const CORRECTION_STOCKS_ACTION = 'correctionStocksAction';

    public string $indexPath;

    public function __construct(string $indexPath)
    {
        $this->indexPath = $indexPath;
    }

    public function getApiAction(): string
    {
        $rootPath = Path::getProjectRootPath();
        $relativeIndexPath = str_replace($rootPath, '',$this->indexPath);
        $action = '';
        if ($relativeIndexPath === Path::API_STOCKS_GET_DIRECTORY) {
            $action = self::GET_STOCKS_ACTION;
        } elseif ($relativeIndexPath === Path::API_STOCKS_CORRECTION_DIRECTORY) {
            $action = self::CORRECTION_STOCKS_ACTION;
        }

        if (empty($action)) {
            throw new ApiActionTypesException("Unknown Api Action Type");
        }

        return $action;
    }
}