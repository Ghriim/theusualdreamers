<?php

$container->setParameter('database_driver', getenv('DATABASE_DRIVER'));
$container->setParameter('database_host', getenv('DATABASE_HOST'));
$container->setParameter('database_port', getenv('DATABASE_PORT'));
$container->setParameter('database_name', getenv('DATABASE_NAME'));
$container->setParameter('database_user', getenv('DATABASE_USER'));
$container->setParameter('database_password', getenv('DATABASE_PASSWORD'));

$container->setParameter('secret', getenv('SECRET'));

$container->setParameter('mailer_username', getenv('MAILER_USER'));
$container->setParameter('mailer_password', getenv('MAILER_PASSWORD'));

$container->setParameter('root_url', getenv('ROOT_URL'));