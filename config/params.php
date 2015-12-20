<?php

return [
    'adminEmail' => 'denis.kravtsov.1986@mail.ru',

    'postman' => [
        'class' => 'rmrevin\yii\postman\Component',
        'driver' => 'smtp',
        'default_from' => ['noreply@test3w.ru', 'Aqua'],
        'subject_prefix' => null,
        'subject_suffix' => null,
        'table' => '{{%email_sent}}',
        'view_path' => '/email',
    ],
];
