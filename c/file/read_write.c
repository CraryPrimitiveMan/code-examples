#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>

int main(void)
{
    char buf[100];
    int num = 0;

    // 获取键盘输入，还记得POSIX的文件描述符吗？
    if ((num = read(STDIN_FILENO, buf, 10)) == -1) {
        printf ("read error");
        error(-1);
    } else {
    // 将键盘输入又输出到屏幕上
        write(STDOUT_FILENO, buf, num);
    }

    return 0;
}
