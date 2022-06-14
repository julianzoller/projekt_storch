<template>
    <div class="text_generieren">
        <div class="container">
            <br><br><br><br><br><br>
            <div class="area inactiveSection">
                <router-link to="/video_upload">
                    <h2>Highlight Video hochladen</h2>
                </router-link>
            </div>
            <div class="area inactiveSection">
                <router-link to="/schlagworte_generieren">
                    <h2>Schlagworte generieren</h2>
                </router-link>
            </div>
            <div class="area">
                <router-link to="/text_generieren">
                    <h2>Text generieren</h2>
                </router-link>
                <br>
                <p>Schlagworte: {{finalJson}}</p>
                <button class="btn btn-primary" id="start" value="start" @click="generateText()"><span
                        id="spinner-start" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                        style="display: none; margin-right: 10px;"></span>Text generieren</button>
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
        name: 'text_generieren',
        data() {
            return {
                token: '',
                json: '',
                finalJson: '',
                confidence: '',
                countTags: ''
            }
        },
        components: {},
        mounted() {
            this.loadTags()
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            this.confidence = urlParams.get('confidence')
            this.countTags = urlParams.get('countTags')
        },
        methods: {
            async generateText() {
                await this.translateTags()
                
            },
            async loadTags() {
                await this.getAccessToken()
                await this.getTags()
                this.convertJSON()
            },
            translateTags() {
                const axios = require("axios");
                const ref = this

                const options = {
                    method: 'POST',
                    url: 'https://deep-translate1.p.rapidapi.com/language/translate/v2',
                    headers: {
                        'content-type': 'application/json',
                        'X-RapidAPI-Key': 'e47253e0f2msh2515b06c7290456p1f848fjsn14374003b931',
                        'X-RapidAPI-Host': 'deep-translate1.p.rapidapi.com'
                    },
                    data: '{"q":"' + this.finalJson + '","source":"en","target":"de"}'
                };
                axios.request(options).then(function (response) {
                    ref.finalJson = response.data.data.translations.translatedText
                    ref.$router.push({
                    path: '/social_media',
                    query: {
                        tags: ref.finalJson
                    }
                })
                }).catch(function (error) {
                    console.error(error);
                });
            },
            convertJSON() {
                var json = this.json
                const confidence = parseFloat(this.confidence) / 100
                const countTags = parseInt(this.countTags)
                var obj = JSON.parse(json)
                var wordCount = 0
                for (let i = 0; i < obj.fragments.length; i++) {
                    var currFragment = obj.fragments[i]
                    for (let j = 0; j < currFragment.events.length; j++) {
                        var eventArray = currFragment.events[j][0]
                        for (let x = 0; x < eventArray.annotations.length; x++) {
                            var tag = eventArray.annotations[x].tag;
                            var tagConfidence = eventArray.annotations[x].confidence
                            if (!this.finalJson.includes(tag) && countTags > wordCount && confidence <= tagConfidence) {
                                this.finalJson = this.finalJson + " " + tag
                                wordCount++;
                            }
                        }
                    }
                }
            },
            getTags() {
                const ref = this;
                var axios = require('axios');
                var data = JSON.stringify({
                    "pwd": "projectStork",
                    "token": ref.token
                });

                var config = {
                    method: 'post',
                    url: 'https://entwicklung.zollerdesign.de/PHP/getAnnotations.php',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    data: data
                };

                return axios(config)
                    .then(function (response) {
                        const formatted = JSON.stringify(response.data);
                        ref.json = formatted
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
                    url: 'https://entwicklung.zollerdesign.de/PHP/getContainerAuthToken.php',
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
        }
    }
</script>
<style>
    .text_generieren {
        text-align: left;
    }
</style>