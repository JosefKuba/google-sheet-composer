<?php

declare(strict_types=1);

namespace App\Command\Avater;

use Minicli\Command\CommandController;

class DataController extends CommandController
{

    public function desc()
    {
        return [
            'command'   => 'php artisan data',
            'desc'      => '处理头像数据',
        ];
    }

    public function help()
    {
        echo "这是帮助手册" . PHP_EOL;
    }

    public function handle(): void
    {
        if ($this->hasFlag("help")) {
            $this->help();
        } else {
            $this->exec();
        }
    }

    public function exec(): void
    {
        $avaterClient = $this->getApp()->redis->getAvaterClient();

        $path = AVATER_INPUT_PATH . "ids_bad";
        $ids = getLine($path);

        $count = 0;
        foreach ($ids as $id) {
            if (!$avaterClient->exists($id)) {
                $count++;
            }
        }

        $this->info(sprintf("新ID：%d 个", $count));
    }
}
