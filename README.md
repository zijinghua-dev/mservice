# About this packge
这是一个微服务包
#如何使用
（1）composer require zijinghua-dev/mservice  
（2）在api或web请求的URL query或header中增加usr, 其值为请求用户的uuid  
（3）如果某个请求需要识别用户，可以在路由中使用auth middleware，其参数为user。
    