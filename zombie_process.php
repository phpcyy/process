<?php


/**
 * 测试僵尸进程
 */

$pid = pcntl_fork();

if ($pid < 0) {
    exit("failed");
} else if ($pid == 0) {//子进程
    sleep(10);
} else {
    sleep(100);
}

/**
 * 在子进程运行 10s 结束后，进程表中的数据父进程迟迟不接收，子进程在 10s 到 100s 期间的状态为『僵尸进程』。
 * 在 100s 后，父进程结束，这时候子进程成为『孤儿进程』，由 Init 进程（pid） 收养，进程完全退出。
 */
