<?php

it('returns a successful response', function () {
    $response = $this->get('/welcome/home');

    $response->assertStatus(200);
});
