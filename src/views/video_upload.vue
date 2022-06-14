<template>
  <div class="video_upload">
    <b-alert :show="dismissCountDown" :variant="variant" @dismissed="dismissCountDown=0"
      @dismiss-count-down="countDownChanged">
      <p>{{uploadResponse}}.</p>
    </b-alert>
    <div class="overlay"></div>
    <div class="spanner">
      <h1 style="color:white">{{uploadResponse}}</h1>
      <div class="loader"></div>
    </div>
    <div class="container">
      <br><br><br><br><br><br>
      <div class="area active">
        <router-link to="/video_upload">
          <h2>Highlight Video hochladen</h2>
        </router-link>
        <br>
        <div class="row">
          <div class="col">
            <form>
              <input class="form-control" type="file" name="fileToUpload" id="fileToUpload" accept="video/*"
                @change="handleFileUpload( $event )">
            </form>
          </div>
          <div class="col">
            <video id="video-preview" controls v-show="file != ''" />
          </div>
          <div class="col-auto">
            <button class="btn btn-primary" id="start" value="start" @click="uploadVideo()"><span id="spinner-start"
                class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                style="display: none; margin-right: 10px;"></span>Hochladen</button>
          </div>
        </div>
      </div>
      <div class="area inactiveSection">
        <router-link to="/schlagworte_generieren">
          <h2>Schlagworte generieren</h2>
        </router-link>
      </div>
      <div class="area inactiveSection">
        <router-link to="/text_generieren">
          <h2>Text generieren</h2>
        </router-link>
      </div>
      <div class="area inactiveSection">
        <router-link to="/social_media">
          <h2>Auf Social Media posten</h2>
        </router-link>
      </div>
    </div>
  </div>
</template>

<script>
  // @ is an alias to /src
  import $ from "jquery";

  export default {
    name: 'video_upload',
    data() {
      return {
        token: '',
        uploadResponse: '',
        dismissSecs: 5,
        dismissCountDown: 0,
        showDismissibleAlert: false,
        variant: ""
      }
    },
    components: {},
    mounted() {
      if (this.file == undefined) {
        document.getElementById("video-preview").style.display = "none"
        document.getElementById("start").style.display = "none"
      }
    },
    methods: {
      previewVideo() {
        let video = document.getElementById('video-preview');
        document.getElementById("start").style.display = "block"

        video.style.display = "block";
        let reader = new FileReader();

        reader.readAsDataURL(this.file);
        reader.addEventListener('load', function () {
          video.src = reader.result;
        });
      },
      handleFileUpload(event) {
        this.file = event.target.files[0];
        this.previewVideo();
      },
      uploadVideo() {
        this.uploadResponse = "Upload"
        const ref = this;
        $("div.spanner").addClass("show");
        $("div.overlay").addClass("show");

        var formData = new FormData();
        formData.append('file', this.file);
        var axios = require('axios');

        //URL aendern
        axios.post('https://entwicklung.zollerdesign.de/PHP/uploadVideo.php', formData, {
            header: {
              'Content-Type': 'video/mp4'
            }
          }).then(function (response) {
            console.log(response.data)
            $("div.spanner").removeClass("show");
            $("div.overlay").removeClass("show");
            if (response.data != "") {
              ref.variant = "danger"
              ref.uploadResponse = "Upload failed"
              ref.showAlert()
              
            } else {
              ref.uploadResponse = "Upload succeeded, redirceting to next step in a few seconds..."
              ref.variant = "success"
              ref.showAlert()
              setTimeout(function() { 
                ref.$router.push('/schlagworte_generieren')
               }, 3000);
            }
            
          })
          .catch(function (error) {
            console.log(error);
          });

      },
      countDownChanged(dismissCountDown) {
        this.dismissCountDown = dismissCountDown
      },
      showAlert() {
        this.dismissCountDown = this.dismissSecs
      },
    }
  }
</script>
<style>
  .video_upload {
    text-align: left;
  }

  video {
    max-width: 50%;
  }


  .spanner {
    position: absolute;
    top: 50%;
    left: 0;
    width: 100%;
    display: block;
    text-align: center;
    height: 300px;
    color: #FFF;
    transform: translateY(-50%);
    z-index: 1000;
    visibility: hidden;
    text-align: center;
  }

  .overlay {
    position: fixed;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    visibility: hidden;
  }

  .loader,
  .loader:before,
  .loader:after {
    border-radius: 50%;
    width: 2.5em;
    height: 2.5em;
    -webkit-animation-fill-mode: both;
    animation-fill-mode: both;
    -webkit-animation: load7 1.8s infinite ease-in-out;
    animation: load7 1.8s infinite ease-in-out;
  }

  .loader {
    color: #ffffff;
    font-size: 10px;
    margin: 80px auto;
    position: relative;
    text-indent: -9999em;
    -webkit-transform: translateZ(0);
    -ms-transform: translateZ(0);
    transform: translateZ(0);
    -webkit-animation-delay: -0.16s;
    animation-delay: -0.16s;
  }

  .loader:before,
  .loader:after {
    content: '';
    position: absolute;
    top: 0;
  }

  .loader:before {
    left: -3.5em;
    -webkit-animation-delay: -0.32s;
    animation-delay: -0.32s;
  }

  .loader:after {
    left: 3.5em;
  }

  @-webkit-keyframes load7 {

    0%,
    80%,
    100% {
      box-shadow: 0 2.5em 0 -1.3em;
    }

    40% {
      box-shadow: 0 2.5em 0 0;
    }
  }

  @keyframes load7 {

    0%,
    80%,
    100% {
      box-shadow: 0 2.5em 0 -1.3em;
    }

    40% {
      box-shadow: 0 2.5em 0 0;
    }
  }

  .show {
    visibility: visible;
  }

  .spanner,
  .overlay {
    opacity: 0;
    -webkit-transition: all 0.3s;
    -moz-transition: all 0.3s;
    transition: all 0.3s;
  }

  .spanner.show,
  .overlay.show {
    opacity: 1;
    z-index: 2000;
  }
</style>