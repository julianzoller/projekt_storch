<template>
    <div class="social_media">
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
            <div class="area inactiveSection">
                <router-link to="/text_generieren">
                    <h2>Text generieren</h2>
                </router-link>
            </div>
            <div class="area active">
                <router-link to="/social_media">
                    <h2>Auf Social Media posten</h2>
                </router-link> <br>
                <div class="row">
                    <div class="col">
                        <label>Video Vorschau:</label><br><br>
                        <img src="https://zuerichgitarrenunterricht.ch/wp-content/uploads/2020/03/video-placeholder.png" width="100%" >
                    </div>
                    <div class="col">
                        <form>
                            <label>Generierter Text mit Hashtags:</label>
                            <br><br>
                            <textarea class="form-control" rows="11" type="text-area" id="tags" name="tags"
                                readonly></textarea>
                        </form>
                    </div>
                    <div class="col-auto">
                        <br><br>
                        <button class="btn btn-primary" id="start" value="start"><span id="spinner-start"
                                class="spinner-border spinner-border-sm" role="status" aria-hidden="true"
                                style="display: none; margin-right: 10px;"></span>Auf Instagram posten</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    // @ is an alias to /src
    import $ from "jquery";

    export default {
        name: 'social_media',
        data() {
            return {
                tags: ''
            }
        },
        components: {},
        mounted() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            this.tags = urlParams.get('tags')
            this.getHashtags()
        },
        methods: {
            getHashtags() {
                var hashtags = "Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam voluptua. At vero eos et accusam et justo duo dolores et ea rebum. Stet clita kasd gubergren, no sea takimata sanctus est Lorem ipsum dolor sit amet.\n\n#"
                hashtags += this.tags.split(' ').join(' #')
                document.getElementById("tags").innerHTML = hashtags
            }
        }
    }
</script>
<style>
    .social_media {
        text-align: left;
    }
</style>