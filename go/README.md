### 国内会报unrecognized import path

```
go get golang.org/x/tools/cmd/goimports

# 等价于如下命令，使用下面的命令不会报错
go get github.com/golang/tools/cmd/goimports

# 建立软链
ln -s github.com/golang golang.org/x
```