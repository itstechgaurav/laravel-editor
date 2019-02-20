<template>
  <div id="assets-window">
    <div class="class mt-4">
      <div class="row space-a">
        <div class="card col-3 my-3 col-4-md col-6-sm col-12-xs" v-for="(asset, index) in assets" :key="index">
          <div class="card-head row v-center px-0">
            <div class="col-9 mb-0 v-center">
              <p class="text mute">{{asset.name}}</p>
            </div>
            <div class="col-2 mb-0">
              <div class="dropdown dropdown-white-dark dropdown-icon-hide">
                <div class="dropdown-head ion ion-ios-arrow-down"></div>
                <div
                  class="dropdown-body"
                  style="right: 0;max-height: auto !important;overflow: hidden !important;"
                >
                  <div class="dropdown-item">
                    <input
                      type="text"
                      class="input-input copy-input"
                      :value="fullUrl('/uploads/' + asset.url)"
                    >
                    <a
                      class="btn btn-prime btn-s v-center text-white copy tooltip"
                      data-tooltip="Click TO Copy"
                      style="text-decoration: none;"
                    >Copy</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="card-body row p-0">
            <div class="w-10 projects-iframe-conteiner">
              <img :src="'/uploads/' + asset.url" class="w-10" style="height: 100%;">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ["assets"],
  mounted() {
      this.autoRun();
  },
  methods: {
      fullUrl(url) {
          return window.location.origin + url;
      },
      autoRun() {
        let copies = document.querySelectorAll(".copy");
        if(copies.length) {
            copies.forEach(function(it) {
                it.addEventListener("click", function(e) {
                    it.previousElementSibling.select();
                    document.execCommand("copy");
                })
            })
        }
      }
  }
};
</script>