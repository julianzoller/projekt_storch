<template>
  <div class="about">
        <div class="container">
        <br><br><br><br><br><br>
        <div class="area active">
            <router-link to="video_upload.html">
                <h2>Highlight Video hochladen</h2>
            </router-link>
            <br>

            <div class="row">
                <div class="col">
                    <form>
                        <input class="form-control" type="file" name="fileToUpload" id="fileToUpload" accept="image/*">
                    </form>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary" id="start" value="start" onclick="window.location.href='schlagworte_generieren.html'"><span id="spinner-start" class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display: none; margin-right: 10px;"></span>Hochladen</button>
                </div>
            </div>
        </div>
        <div class="area inactiveSection">
            <router-link to="schlagworte_generieren.html">
                <h2>Schlagworte generieren</h2>
            </router-link>
        </div>
        <div class="area inactiveSection">
            <router-link to="text_generieren.html">
                <h2>Text generieren</h2>
            </router-link>
        </div>
        <div class="area inactiveSection">
            <router-link to="social_media.html">
                <h2>Auf Social Media posten</h2>
            </router-link>
        </div>
    </div>
  </div>
</template>
