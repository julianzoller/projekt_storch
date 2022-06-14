<template>
    <div class="schlagworte_generieren">
        <b-alert :show="dismissCountDown" :variant="variant" @dismissed="dismissCountDown=0"
            @dismiss-count-down="countDownChanged">
            <p>{{uploadResponse}}.</p>
        </b-alert>
        <div class="container">
            <br><br><br><br><br><br>
            <div class="area inactiveSection">
                <router-link to="/video_upload">
                    <h2>Highlight Video hochladen</h2>
                </router-link>
            </div>
            <div class="area active">
                <router-link to="/schlagworte_generieren">
                    <h2>Schlagworte generieren</h2>
                </router-link>
                <br>
                <!-- <form> -->
                <div class="row">
                    <div class="col">
                        <label for="numberOfTags">Anzahl Tags:</label><br><br>
                        <input class="form-control" type="number" name="numberOfTags" id="numberOfTags" value="10">
                    </div>
                    <div class="col">
                        <label for="minConfidence">Minimum Confidence:</label><br><br>
                        <input type="range" class="form-range" min="0" max="100" step="10" id="minConfidence"
                            name="minConfidence">
                        <br>
                        <p id="value">50%</p>
                    </div>
                    <div class="col-auto"><br><br>
                        <button class="btn btn-primary" id="start" value="start" @click="startTransformJob()"><span
                                id="spinner-start" class="spinner-border spinner-border-sm" role="status"
                                aria-hidden="true" style="display: none; margin-right: 10px;"></span>Tags
                            generieren</button>
                    </div>
                </div>
                <div class="row" id="stateSection" style="display: none">
                    <b-button variant="primary ">
                        <b-spinner small></b-spinner>
                        <span class="sr-only"> Loading... {{state}}%</span>
                    </b-button>
                </div>
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
        name: 'schlagworte_generieren',
        data() {
            return {
                token: '',
                dismissSecs: 5,
                dismissCountDown: 0,
                uploadResponse: '',
                showDismissibleAlert: false,
                variant: "",
                state: "0",
                confidence: 50
            }
        },
        components: {},
        mounted() {
            const slideValue = document.getElementById("value");
            const inputSlider = document.getElementById("minConfidence");
            const ref = this
            inputSlider.oninput = (() => {
                let value = inputSlider.value;
                slideValue.textContent = value + "%";
                slideValue.classList.add("show");
                ref.confidence = value
            });
            inputSlider.onblur = (() => {
                slideValue.classList.remove("show");
            });

        },
        methods: {
            getState() {
                document.getElementById("stateSection").style.display = "block"
                const ref = this;
                const countTags = document.getElementById("numberOfTags").value 
                const confidence = this.confidence 
                var axios = require('axios');
                var data = JSON.stringify({
                    "pwd": "projectStork",
                    "token": ref.token
                });

                var config = {
                    method: 'post',
                    url: 'https://entwicklung.zollerdesign.de/PHP/getJobState.php',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    data: data
                };

                return axios(config)
                    .then(function (response) {
                        ref.state = response.data.properties.outputs[0].progress
                        if (response.data.properties.outputs[0].progress == 100) {
                            document.getElementById("stateSection").style.display = "none"
                            ref.uploadResponse =
                                "Transformation succeeded, redirceting to next step in a few seconds..."
                            ref.variant = "success"
                            ref.showAlert()
                            setTimeout(function () {
                                ref.$router.push({ path: '/text_generieren', query: { countTags: countTags, confidence: confidence } })
                            }, 3000);
                        } 
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            async deleteJob() {
                const ref = this;
                var axios = require('axios');
                var data = JSON.stringify({
                    "pwd": "projectStork",
                    "token": ref.token
                });

                var config = {
                    method: 'post',
                    url: 'https://entwicklung.zollerdesign.de/PHP/deleteTransformJob.php',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    data: data
                };

                return axios(config)
                    .then(function (response) {
                        console.log(response.data)
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            async startTransformJob() {
                await this.getAccessToken()
                await this.deleteJob()
                const ref = this;
                var axios = require('axios');
                var data = JSON.stringify({
                    "pwd": "projectStork",
                    "token": ref.token
                });

                var config = {
                    method: 'post',
                    url: 'https://entwicklung.zollerdesign.de/PHP/startTransformJob.php',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    data: data
                };

                return axios(config)
                    .then(function (response) {
                        if (JSON.stringify(response.data).includes("Transformation failed")) {
                            ref.variant = "danger"
                            ref.uploadResponse = "Transformation failed"
                            ref.showAlert()
                        } else {
                            ref.uploadResponse =
                                "Transformation started.."
                            ref.variant = "success"
                            ref.showAlert()

                            function foo() {

                                ref.getState()

                                setTimeout(foo, 5000);
                            }

                            foo();
                            
                        }
                    })
                    .catch(function (error) {
                        console.log(error);
                    });
            },
            getAccessToken() {
                const ref = this;
                var axios = require('axios');
                var data = JSON.stringify({
                    "pwd": "projectStork"
                });

                var config = {
                    method: 'post',
                    url: 'https://entwicklung.zollerdesign.de/PHP/getAuthToken.php',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    data: data
                };

                return axios(config)
                    .then(function (response) {
                        if (response.data == ("Authentication failed" ||
                                "Authentication failed, wrong credentials or wrong account settings!")) {
                            alert("Authentication failed, wrong credentials or wrong account settings!")
                        } else {
                            ref.token = response.data.access_token
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
    .schlagworte_generieren {
        text-align: left;
    }
</style>