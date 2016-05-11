# Shopping

## Prerequisites

* Git
* Node.js &amp; Node Package Manager (NPM) [下载链接](https://nodejs.org/en/download/)
* Bower

```
$ npm install -g bower
```

* Karma (Optional) - used for testing

```
$ npm install -g karma
```

## 安装


Clone this repository to your folder.

```
$ git clone https://github.com/DuoShouDang/Shopping.git

```
Download npm and bower packages

```
npm install
```

Perform the build operations using Gulp:

```
$ npm run build       # Builds for production
$ npm run build-dev   # Builds for development
```

Serve the application using Browsersync: *(for development purposes)*

```
$ npm run start       # Serves the production build
$ npm run start-dev   # Serves the development build
```

Run unit tests using Karma:

```
$ npm run test-unit
```

###其它

可能的报错：安装phantomJS出错   
（大绿🐍的）解决方案：

```
export PHANTOMJS_CDNURL=http://cnpmjs.org/downloads
npm install -g phantomjs
```

`npm install`后自动执行`bower install`。若此步骤出错可以手动执行

```
bower install --allow-root
```

安装过程中出现的其他问题请移至issues.


## 前端说明

### 目录结构

根目录下包含以下文件和文件夹：

* src
* test
* 配置和部署相关文件

`src` 目录下包含前端所需要运行的一切文件；`test` 目录下包含所有测试文件。

```
.
├── src                                # 客户端部分
│   ├── app                            # AngularJS应用文件
│   │   ├── components                 # AngularJS公共组件
│   │   │   ├── directives
│   │   │   └── filters
│   │   ├── core                       # 核心模块
│   │   ├── modules                    # 分功能模块
│   │   │   └── home                   # 功能模块例子
│   │   ├── services                   # Service定义
│   │   ├── app.config.js              # 应用配置
│   │   └── app.module.js              # 应用模块定义
│   ├── assets                         # 非JS文件和第三方文件
│   │   ├── images                     # 图片
│   │   ├── stylesheets                # LESS, CSS文件
│   │   ├── lib                        # 第三方库
│   │   └── vendor                     # 第三方库
│   │       ├── angular                # AngularJS
│   │       └── ...
│   ├── build                          # Minified JS&CSS
│   └── layout                         # 部分HTML文件（定义网站layout）
├── tests                              # 测试代码
│   └── e2e                            # End-to-end
├── .bowerrc                           # Bower配置文件
├── .editorconfig                      # IDE Editor配置文件
├── .gitattributes                     # Git配置文件
├── .gitignore                         # Git配置文件
├── .jscsrc                            # JSCS配置文件
├── .jshintrc                          # JSHint配置文件
├── .travis.yml                        # Travis-CI配置文件
├── LICENSE                            # MIT License
├── README.md                          # README
├── bower.json                         # 定义Bower依赖包
├── gulp.conf.json                     # Gulp配置文件
├── gulpfile.js                        # Gulp tasks文件
├── karma.conf.js                      # Karma单元测试配置文件
├── package.json                       # 定义Node.js依赖包
└── protractor.conf.js 
```

### 模块结构

每一个模块应写在自己的目录下。

```
src/app/modules/home/
├── controllers                        # Controller
│   ├── example.home.controller.js
│   └── another-example.home.controller.js
├── views                              # Views
│   ├── example.home.view.html
│   └── another-example.home.view.html
├── config                             # 模块配置
│   ├── home.route.js                  # 路径定义
│   ├── home.menus.js                  # (可选) 添加至导航栏
│   └── home.spec.js                   # 单元测试
└── home.module.js                     # 模块定义

```

### 其它

**重要!!!**  
引入依赖包时，在bower.json或package.json中添加相应说明：

bower.js

```
"dependencies": {
    "angular": "~1.5.0",
    "your-new-dependency-here": "~required.version.number"
}
```

package.json

```
"dependencies": {
    "acl": "~0.4.9",
    "your-new-dependency-here": "~required.version.number"
}
```

如果需要引入的第三方库或插件不在bower或npm上，复制粘贴到`src/app/assets/lib/`即可。`node_modules/`和`src/app/assets/vendor`**不会被git索引！**


