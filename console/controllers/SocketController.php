<?php
/**
 * Created by Madetec-Solution.
 * Developer: Mirkhanov Z.S.
 */

namespace console\controllers;

use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use uztelecom\repositories\UserRepository;
use uztelecom\websocket\controllers\OnlineController;
use Ratchet\App;
use yii\console\Controller;

/**
 * @property UserRepository $users
 */

class SocketController extends Controller
{
    private $users;

    public function __construct(
        string $id,
        $module,
        UserRepository $users,
        array $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->users = $users;
    }


    /**
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionUp()
    {
        $path = \Yii::getAlias('@path/yii');
        $shell = 'ps -C php -f';
        $output = shell_exec($shell);
        if (strpos($output, '/usr/bin/php ' . $path . ' socket/run') === false) {
            $this->stdout(PHP_EOL . 'server not running' . PHP_EOL);
            shell_exec('/usr/bin/php ' . $path . ' socket/run > /dev/null &');
            $this->stdout(PHP_EOL . 'server run' . PHP_EOL);
        } else {
            $this->stdout(PHP_EOL . 'server running' . PHP_EOL);
        }
    }

    /**
     * @throws \DomainException
     */
    public function actionRun()
    {
        $this->stdout('start server' . PHP_EOL);
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new OnlineController($this->users)
                )
            ),
            8082
        );
        $server->run();
    }

    /**
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionReload()
    {
        $path = \Yii::getAlias('@path/yii');
        $shell = 'ps -C php -f';
        $output = shell_exec($shell);
        if (strpos($output, '/usr/bin/php ' . $path . ' socket/run') === false) {
            $this->stdout(PHP_EOL . 'server not running' . PHP_EOL);
            shell_exec('/usr/bin/php ' . $path . ' socket/run > /dev/null &');
        } else {
            $this->stop($output, $path);
            $this->stdout(PHP_EOL . 'server run' . PHP_EOL);
            shell_exec('/usr/bin/php ' . $path . ' socket/run > /dev/null &');
        }
    }

    /**
     * @throws \yii\base\InvalidArgumentException
     */
    public function actionStop()
    {
        $path = \Yii::getAlias('@path/yii');
        $shell = 'ps -C php -f';
        $output = shell_exec($shell);
        $this->stop($output, $path);
    }


    protected function stop($shellResponse, $path)
    {
        $arr = explode("\n", $shellResponse);
        $arr = array_filter($arr);
        $arr = count($arr) > 1 ? array_slice($arr, '1') : null;
        foreach ($arr as $item) {
            if (strpos($item, '/usr/bin/php ' . $path . ' socket/run')) {
                $ids = explode(' ', $item);
                $ids = array_filter($ids, function ($item) {
                    return is_numeric($item) && $item != 0;
                });
                $ids = array_unique($ids);
                $ids = array_values($ids);
                if (count($ids) > 1) {
                    $pid = (int)$ids[0];
                    shell_exec("kill $pid");
                    $this->stdout(PHP_EOL . 'server stop' . PHP_EOL);
                }
            }
        }
    }
}