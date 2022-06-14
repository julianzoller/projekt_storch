<template>
  <div class="home">
    <h1 style="margin-top: 50px">Projekt Storch</h1>
    <div class="row justify-content-center" style="margin-top: 100px">
        
      <div class="col-6">
        <input type="file" class="btn btn-secondary" id="selectFiles" value="Import" /><br />
        <textarea style="width: 90%; margin-top: 10px" rows="20" id="result"></textarea>
      </div>
      <div class="col-6">
        <button type="button" class="btn btn-primary" @click="convertJSON()">Convert into Tags</button>
        <h3 style="margin-top: 10px">Tags:</h3>
        <p>{{json}}</p>
      </div>
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
        jsonRAW: "",
        json: ""
      }
    },
    components: {},
    mounted() {
      let ref = this
      $("input#selectFiles").change(function () {
        ref.importJSON()
      });
    },
    methods: {
      importJSON() {
        var files = document.getElementById('selectFiles').files;
        console.log(files);
        if (files.length <= 0) {
          return false;
        }

        var fr = new FileReader();

        fr.onload = function (e) {
          console.log(e);
          var result = JSON.parse(e.target.result);
          var formatted = JSON.stringify(result, null, 2);
          document.getElementById('result').value = formatted;
        }

        fr.readAsText(files.item(0));
      },
      convertJSON() {
        var json = document.getElementById('result').value


        var obj = JSON.parse(json)
        console.log(obj)
        console.log(obj.fragments[0].events[0][0].annotations[0].tag)
        for (let i = 0; i < obj.fragments.length; i++) {
          var currFragment = obj.fragments[i]
          for (let j = 0; j < currFragment.events.length; j++) {
            var eventArray = currFragment.events[j][0]
            for (let x = 0; x < eventArray.annotations.length; x++) {
              var tag = eventArray.annotations[x].tag;
              if (!this.json.includes(tag)) {
                this.json = this.json + " " + tag
              }
            }
          }
        }

      }
    }
  }
</script>