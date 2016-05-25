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

* Lessc - used for compiling Less files

```
$ npm install -g less
```

## 安装

Clone this repository.

```
$ git clone https://github.com/DuoShouDang/Shopping.git
```
Download npm and bower packages.

```
npm install
```

Build the project: *(clean project; 合并且minify css, js文件；依赖注入)*

```
$ npm run build       # Builds for production
$ npm run build-dev   # Builds for development
```

Serve the application using Browsersync: *(仅供静态页面调试)*  
执行后应在浏览器中自动打开`index.html`; 如果没有，则访问localhost:3000即可。  
实时监测文件变化并在文件内容改变时重新build、重启服务器刷新页面。**执行start之前不需要手动执行build.**

```
$ npm run start       # Serves the production build
$ npm run start-dev   # Serves the development build
```

Run unit tests using Karma: *(没有做过并不知道这是啥)*

```
$ npm run test-unit
```

### 关于Gulp

`gulpfile.js`中定义了一些任务；可以查看任务并执行

```
$ npm run gulp task:name
```

如只clean项目则可以`npm run gulp clean`。
用npm run定义或查看执行任务的详情时，可看`package.json`。例如，可以看到

```
"scripts": {
    "build": "npm run gulp prebuild; npm run gulp build",
    ...
}
```

定义了`npm run build`任务实际执行

```
$ npm run gulp prebuild  
$ npm run gulp build
```

### 其它

可能的报错：安装phantomJS出错   
（大绿🐍的）解决方案：

```
export PHANTOMJS_CDNURL=http://cnpmjs.org/downloads
npm install -g phantomjs-prebuilt
```

`npm install`后自动执行`bower install`。若此步骤或之前步骤出错可以手动执行：

```
bower install --allow-root
```

依赖包应该安装在src/assets/vendors目录下面。

**安装过程中出现的其他问题请移至issues.**


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
│   │   └── vendor                     # 第三方库
│   │       ├── angular                # AngularJS
│   │       └── ...
│   ├── build                          # Minified JS&CSS
│   └── layout                         # 定义网站全局layout的HTML模版
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
└── protractor.conf.js                 # 这玩意我也没用过
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
│   ├── home.menus.js                  # (以后开发阶段可选) 添加至导航栏
│   └── home.spec.js                   # 单元测试
└── home.module.js                     # 模块定义

```

### 样式

样式表文件均在`src/assets/stylesheets`，拟写LESS文件，再将其编译成CSS.   
自动编译LESS的逻辑尚未实现（说白就是懒）\_(:з」∠)\_

### 其它

**重要!!!**  
引入依赖包时，在bower.json或package.json中添加相应说明：

bower.json

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

`node_modules/`和`src/app/assets/vendor`**不会被git索引！**前端开发人员自行负责维护`bower.json`和`package.json`中的内容，并在文件内容有修改时自行用npm或bower在本地添加相应的依赖包。

第三方文件尽量使用bower或npm上已有的；如以后需要用到不支持bower或npm的代码或服务就再说。。
