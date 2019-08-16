<?php
declare(strict_types=1);

$app = new \Core\App();

$app->makeServerRequest();

$app->makeDIContainer();

$app->setDependencies();

$app->getContainer()->set(\Core\App::class, $app); // Set application instance in DI

$app->dispatchAction();


