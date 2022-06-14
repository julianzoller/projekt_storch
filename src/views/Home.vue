<template>
  <div class="home">
    <div class="container">
      <div id="alert"></div>
      <br>
      <H1>Willkommen!</H1>
      <br>
      <h2>Über das Projekt</h2>
      <br>
      <p>
        Projektbeschreibung. <br><br> Projektteam:
      </p>
      <table>
        <tr>
          <td>
            <img class="profile" src="@/assets/images/Tim.png">
          </td>
          <td>
            <b>Tim Keller</b> <br> Matr. Nr. 325416 <br> kellertm@hs-pforzheim.de
          </td>
          <td style="padding-left: 30px;">
            <img class="profile" src="@/assets/images/Dominik.png">
          </td>
          <td>
            <b>Dominik Oelfin</b> <br> Matr. Nr. 325424 <br> oelfindo@hs-pforzheim.de
          </td>
        </tr>
        <tr>
          <td>
            <img class="profile" src="@/assets/images/Julian.png">
          </td>
          <td>
            <b>Julian Zoller</b> <br> Matr. Nr. 317731 <br> zollerju@hs-pforzheim.de
          </td>
          <td style="padding-left: 30px;">
            <img class="profile" src="@/assets/images/Moritz.png">
          </td>
          <td>
            <b>Moritz Pinder</b> <br> Matr. Nr. 317051 <br> pindermo@hs-pforzheim.de
          </td>
        </tr>
      </table>
      <br><br>
        <router-link to="/video_upload">
          <button class="btn btn-primary">Start</button>
        </router-link>
    </div>
  </div>
</template>

<script>
  // @ is an alias to /src
  import $ from "jquery";

  export default {
    name: 'Home',
    data() {
      return {

      }
    },
    components: {},
    mounted() {

    },
    methods: {
      
    }
  }
</script>
<style>
  .home {
    text-align: left;
  }
</style>