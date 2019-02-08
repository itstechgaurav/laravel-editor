<template>
    <div id="editor-editor" class="pos-window">
        <div id="editor-top" class="group space-b">
            <div class="refresh-icon v-center">
                <i class="ion ion-ios-loop text-white mx-a pointer"></i>
            </div>
            <input class="url-bar v-center space-a w-7" disabled :value="this.title.substring(0, 25)">
            <div data-title="open in new window" class="refrsh-icon v-center title-tip title-tip-left title-tip-light" @click="launchBrowser()">
                <i class="ion ion-ios-browsers-outline text-white pointer" style="font-size: 1.8rem;"></i>
            </div>
        </div>
        <div id="editor-bottom">
            <iframe allow="midi; geolocation; microphone; camera; encrypted-media;" sandbox="allow-forms allow-scripts allow-same-origin allow-modals allow-popups" allowfullscreen="" allowpaymentrequest="" id="app-browser-window" frameborder="0" class="pos-window"></iframe>
        </div>
    </div>
</template>

<script>

    import axios from "axios";

    export default {
        data() {
            return {
                fs: null,
                title: "Document",
                mainBrowser: null
            }
        },
        mounted() {
            this.browser = document.getElementById("app-browser-window");
            this.bDoc = this.browser.contentWindow.document;
            this.$eBus.$on("runCode", this.renderPage)
            this.$eBus.$on("uploadCode", this.uploadCode);
            this.renderPage(this.$store.state.all.fs);
            spyder.rerun();
        },
        methods: {
            launchBrowser() {
                this.$eBus.$emit("changeView", {
                    name: "left",
                    active: true
                });
                this.mainBrowser = window.open(window.location.href, "_blank", '');
                this.mainBrowser.onbeforeunload = function() {
                    this.$eBus.$emit("changeView", {
                        name: "left-right",
                        active: true
                    });
                    this.mainBrowser = null;
                    return "Are You Sure";
                }.bind(this);
                this.reRender();
            },
            renderPage(fs) {
                this.fs =fs;
                let __hm = this.fs[0].content;
                let __cs = this.fs[1].content;
                let __js = this.fs[2].content;
                __hm = __hm.replace("<loadcss/>", `${'<style>' + __cs +'</style>'}`);
                __hm = __hm.replace("<loadjs/>", `${'<script>' + __js +'</' + 'script>'}`);
                
                
                if(this.$store.state.all.activeView !== "left") {
                    this.bDoc.open();
                    this.bDoc.write(__hm);
                    this.bDoc.close();
                    this.title = this.bDoc.querySelector("title").innerText;
                }

                this.result = __hm;
                this.$store.state.all.fs = this.fs;
                this.$store.state.all.result = this.result;

                if(this.mainBrowser) {
                    this.mainBrowser.document.open();
                    this.mainBrowser.document.write(__hm);
                    this.mainBrowser.document.close();
                }

            },
            reRender() {
                this.renderPage(this.fs);
            },
            uploadCode(fs) {

                if(!this.$store.state.allowSave) {
                    console.log("You Can not Save");
                    return false;
                }

                this.renderPage(fs);
                let codeCollection = JSON.stringify({
                        activeView: this.$store.state.all.activeView,
                        fs: this.fs,
                        result: this.result,
                        editor: this.$store.state.all.editor});
                let isInitial = (codeCollection === this.$store.state.initial)
                if(!isInitial) {
                    this.$store.state.initial = codeCollection;
                    axios.post(window.location.href, {
                        meta: codeCollection
                    }).then(res => {
                        console.log(res.data);
                    }).catch(err => {
                        console.log(err)
                    })
                } else {
                    addMsg("warn", "Nothing Changed");
                }
            }

        }
    }
</script>