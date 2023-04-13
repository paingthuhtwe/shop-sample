<?php

use function Pest\Laravel\get;

test('/articles route', function () {
    get('/articles')->assertOk();
});
