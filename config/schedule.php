<?php

/**
 * @var \yii2mod\scheduling\Schedule
 *
 * Add to cron the following command:
 *
 *  ~~~
 *     * * * * * php yii schedule/run
 *  ~~~
 *
 * Also you can set the schedule file path:
 *
 * ~~~
 *     * * * * * php yii schedule/run --scheduleFile=@app/config/schedule.php
 * ~~~
 *
 * @see https://github.com/yii2mod/yii2-scheduling
 */

// for example: generate sitemap every week
$schedule->command('app/generate-sitemap')->description('Generate Sitemap')->weekly();
