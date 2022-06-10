<?php

/*
    @param string $dest
    @param int delay
    @return void
*/
function redirect(string $dest, int $delay = 0): void {
    sleep($delay);
    header("Location: {$dest}");
}