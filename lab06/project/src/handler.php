<?php

require_once 'classes/FormHandler.php';

function handleForm()
{
    $handler = new FormHandler();
    return $handler->handle($_POST);
}