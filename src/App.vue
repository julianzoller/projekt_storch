<template>
  <div id="app" class="">
     
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top" style="padding-left:2rem">
      <a class="navbar-brand" href="/">
        <img src="@/assets/images/Logo_HSPF.png" width="100%" height="30" alt="">
      </a>
      
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
        aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">
          <!--  <a class="nav-item nav-link active" href="Landingpage.html">Home</a> -->
          <!--   <a class="nav-item nav-link" href="Analyzer.html">Analyzer</a> -->
          <!--    <a class="nav-item nav-link" href="Database.html">Database</a> -->
        </div>
      </div>
    </nav>
    <transition>
      <router-view />
    </transition>
    <footer class="text-center text-white">
      <div class="container pt-4">
        <section class="text-dark" style="margin-bottom:1%;">
          <img src="@/assets/images/Logo_HSPF.png" style="width:7%;"> <br><br>
          © 2022 Copyright | Dominik Oelfin, Tim Keller, Julian Zoller &amp; Moritz Pinder |
          <a class="text-dark" href="https://www.hs-pforzheim.de/">hs-pforzheim.de</a>
        </section>
      </div>
    </footer>
  </div>
</template>
<script>
export default {
  
}
</script>

<style>
  #app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
  }

  #nav {
    padding: 30px;
  }

  #nav a {
    font-weight: bold;
    color: #2c3e50;
  }

  #nav a.router-link-exact-active {
    color: #42b983;
  }

  body {
    overflow-y: scroll !important;
  }

  nav {
    box-shadow: 0px 0px 27px 0px #DBDBDB;
  }

  body {
    background-image: url("assets/images/Dreieck.png");
    background-attachment: fixed;
    background-position: bottom;
    background-size: contain;
    background-repeat: no-repeat;
  }

  footer {
    background-color: rgba(248, 249, 250);
    width: 100%;
    position: fixed;
    bottom: 0;
    box-shadow: 0px 0px 27px 0px #DBDBDB;
  }

  button {
    box-shadow: 0px 0px 27px 0px #DBDBDB;
    transition: .2s ease-in-out 0s !important;
  }

  button:hover {
    transform: scale(1.1);
  }

  .big-button {
    padding: 50px !important;
    margin-right: 30px;
    font-size: 22px !important;
    box-shadow: 0px 0px 27px 0px #DBDBDB;
    background-color: white !important;
    min-width: 300px;
  }

  .profile {
    width: 100px;
    margin: 20px;
  }

  .tagsintable {
    background: white !important;
    border: none !important;
    resize: none !important;
    width: 150% !important;
  }

  .table {
    background-color: white;
    box-shadow: 0px 0px 27px 0px #DBDBDB;
    border-radius: 5px;
  }

  .table th {
    padding-left: 20px !important;
    padding-right: 20px !important;
  }

  .table td {
    padding-left: 20px !important;
    padding-right: 20px !important;
  }

  .area {
    border-bottom: 1px solid #292929;
    padding: 10px;
  }

  .active {
    border-bottom: 1px solid #292929;
    padding: 10px;
    padding-bottom: 30px;
    padding-top: 15px;
  }

  .area:last-of-type {
    border-bottom: none
  }

  .inactiveSection {
    opacity: 30%!important;
    padding-top: 15px;
  }

  a {
    color: black !important;
    text-decoration: none !important;
  }
</style>