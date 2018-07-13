<?php

/**
 * 测试 fork 进程，并避免产生僵尸进程
 */

$pid = pcntl_fork();

if ($pid < 0) {
    exit("fork failed");
} else if ($pid == 0) {
    $son_pid = pcntl_fork();

    if ($son_pid < 0) {
        die("fork failed");
    } else if ($son_pid == 0) {
        //do son's process business
        sleep(100);
    } else {
        //exit at now
        exit();
    }
} else {
    $get_pid = pcntl_waitpid($pid, $status);
    if ($get_pid != $pid) {
        exit("son process exited not expected");
    }

    //do father's process business
    sleep(100);
}


/**
 * 执行结果
 *
 * 子进程（pid=34007）退出后，父进程（pid=34006）继续执行，孙子进程（pid=34008）由 Init 进程（pid=1）收养后，继续执行，从而避免出现了僵尸进程
 *
 * 501 34006 33933     4006   0  31  0  4386784  19136 -      S+                  0 ttys001    0:00.08 php fork_safe_process.php
 * 501 34008     1        6   0  31  0  4396000    696 -      S+                  0 ttys001    0:00.00 php fork_safe_process.php
 */

