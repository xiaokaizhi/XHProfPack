记录日志
（1）将xhprof数据实时记录到php-resque系统中，实时的扫描队列，将结果写入mysql，待查询处理
（2）将xhprof数据写入到本地日志，将写入本地log文件中的xhprof data提取出来，用到了大文本处理的思想，最后将结果载入到mysql数据库中。


大文本处理思路

按一千万行的数据来计算，假设你对 PHP 最熟悉，开发速度最快，假设你要写入到 MySQL 中。

1. 用 shell 将一千万行文件切分成 100 个文件,这样每个文件有10万行,具体做法可以 man split。

2. 写 php 脚本,脚本内容是读一个文件,然后输出有效的数据。注意数据格式，严格按照表中字段的顺序来写，字段之间用半角分号隔开，行之间用 \n 隔开。具体参数可配置，参见 MySQL 的 load data 命令参数。注意是 php cli 方式运行的，不要拿 Apache 或者 其他 web server 下面跑这个东西。如果按行读不知道怎么搞可以直接用 php 的 file() 函数，生成的 sql 语句通过 error_log($sql, 3, "/path/to/dataa") 函数写入到文件中。同时可以 echo 一些调试信息，以备后续检查。

3. 写 shell 脚本调用 php 处理日志.脚本可以类似来写
/path/to/php/bin/php -f genMySQLdata.php source=loga out=dataa > /errora.log & /path/to/php/bin/php -f genMySQLdata.php source=logb out=datab > /errorb.log & /path/to/php/bin/php -f genMySQLdata.php source=logc out=datac > /errorc.log & 

....重复一百行，机器配置低可以分批写，每个写 10 行也行。这个脚本内容很有规律吧，本身也可以用 php 来生成。时间又省了。 在机器上执行这个 shell 脚本，实际上就启动多个 PHP 进程来生成数据。配置够牛的话，就等于你启动了 100 个 PHP 进程来处理数据。速度又快了。

4.继续写 shell 脚本，内容是打开 MySQL 用 load data 来载入数据。

文件权限/path/to/dataa

mysql -h127.0.0.1 -uUser -ppwd -P3306 -D dbname --local-infile -e 'load data local infile "/path/to/dataa" into table TableName(Field1, Field1, Field1);' 
其中的 field1 ... 要跟生成数据的顺序对应，这个命令可以直接执行，也可以放到 shell 里面重复写 N 行,然后执行 shell 脚本。



