<!DOCTYPE html>
<html ng-app="app">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
  <base href="/">
  <title>DuoShouDang</title>
  <meta name="description" content="">
  <meta name="fragment" content="!">

  <!-- Fav Icon -->
  <link href="assets/images/brand/favicon.ico" rel="shortcut icon" type="image/x-icon">

  <!-- Apple META -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="black">

  <!-- inject:css -->
  <!-- endinject -->
</head>
<body  class="ng-cloak">
  <header ng-include="'app/modules/home/views/header.view.html'" class="navbar navbar-fixed-top"></header>
  <section id="content" ui-view>
    <!-- App content here -->
  </section>
  <footer ng-include="'app/modules/home/views/footer.view.html'" class="container"></footer>
  <!-- inject:js -->
  <!-- endinject -->
</body>
</html>
