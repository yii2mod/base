<?php

namespace app\commands;

use Yii;
use yii\base\InvalidConfigException;
use yii\console\Controller;
use yii\helpers\Console;

/**
 * Class BaseController
 *
 * @author Igor Chepurnoy <chepurnoi.igor@gmail.com>
 *
 * @since 1.0
 */
class BaseController extends Controller
{
    /**
     * @var array list of disabled actions
     */
    public $disabledActions = [];

    /**
     * @var string the running command name
     */
    protected $command;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'cronLogger' => [
                'class' => 'yii2mod\cron\behaviors\CronLoggerBehavior',
                'actions' => ['*'],
            ],
        ];
    }

    /**
     * Before action event
     *
     * @param \yii\base\Action $action
     *
     * @return bool
     */
    public function beforeAction($action)
    {
        $this->command = $action->controller->id . '/' . $action->id;

        if ($this->isDisabledAction($action->id)) {
            $this->stdout("Command '{$this->command}' is disabled.\n", Console::FG_RED);

            return false;
        }

        if (!parent::beforeAction($action)) {
            return false;
        }

        $this->stdout("Running the command `{$this->command}` at the " . Yii::$app->formatter->asDatetime(time()) . "\n", Console::FG_GREEN);

        return true;
    }

    /**
     * After action event
     *
     * @param \yii\base\Action $action
     * @param mixed $result
     *
     * @return mixed
     */
    public function afterAction($action, $result)
    {
        $result = parent::afterAction($action, $result);

        $this->stdout("Command `{$this->command}` finished at the " . Yii::$app->formatter->asDatetime(time()) . "\n", Console::FG_GREEN);

        return $result;
    }

    /**
     * Check whether the current action is disabled
     *
     * @param $id string action id
     *
     * @throws InvalidConfigException
     *
     * @return bool
     */
    protected function isDisabledAction($id)
    {
        if (!is_array($this->disabledActions)) {
            throw new InvalidConfigException('The "disabledActions" property must be an array.');
        }

        if (in_array('*', $this->disabledActions) || in_array($id, $this->disabledActions)) {
            return true;
        }

        return false;
    }
}
