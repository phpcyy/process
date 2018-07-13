<?php

/**
 * 测试孤儿进程
 */

$pid = pcntl_fork();

if ($pid < 0) {
    exit("forked failed");
} else if ($pid == 0) {//子进程
    sleep(100);
} else {
    sleep(10);
    die;
}

/**
 * 在执行到第 10s 时，父进程退出，这时子进程由 Init 进程（pid=1）收养，被称为『孤儿进程』。
 *
 * 孤儿进程对系统是没有危害的。
 *
 * 501 34207     1        6   0  31  0  4386784   1112 -      S                   0 ttys002    0:00.00 php orphan_proccess.php
 */