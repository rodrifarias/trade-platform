<?php

/** @throws Throwable */
function throwIf(bool $shouldThrow, Exception|Throwable $exception): void
{
    ! $shouldThrow ?: throw $exception;
}
