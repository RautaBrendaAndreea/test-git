<?php

dataset('group_chat_created', function () {
    $file = file_get_contents(__DIR__.'/../Fixtures/Updates/group_chat_created.json');

    return [json_decode($file)];
});
